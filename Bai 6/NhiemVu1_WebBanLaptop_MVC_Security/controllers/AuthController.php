<?php
/**
 * AuthController: Xác thực người dùng, Đăng ký, Đăng nhập, Đăng xuất
 * Tích hợp Brute Force Protection, Bcrypt Password Hashing, Session Fixation Prevention
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login(): void {
        if (Security::isLoggedIn()) {
            $this->redirect('index.php?r=home/index');
        }

        $error = null;

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            // Kiểm tra Rate Limit chống tấn công dò mật khẩu Brute Force
            if (!Security::checkRateLimit('login', 5, 300)) {
                $error = 'Bạn đã đăng nhập sai quá 5 lần liên tiếp. Vì lý do an toàn, vui lòng thử lại sau 5 phút!';
                $this->render('auth/login', ['pageTitle' => 'Đăng Nhập', 'error' => $error]);
                return;
            }

            $username = trim($this->post('username', ''));
            $password = $this->post('password', '', true);

            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
            } else {
                $user = $this->userModel->findByUsername($username);
                if (!$user) {
                    // Thử tìm theo email
                    $user = $this->userModel->findByEmail($username);
                }

                if ($user && Security::verifyPassword($password, $user['password'])) {
                    // Đăng nhập thành công -> Xóa bộ đếm Brute Force
                    Security::clearRateLimit('login');

                    // Chống Session Fixation Attack bằng cách tái tạo ID phiên
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'fullname' => $user['fullname'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ];

                    $this->setFlash('success', 'Chào mừng ' . Security::escape($user['fullname']) . ' đã đăng nhập thành công!');
                    
                    if ($user['role'] === 'admin') {
                        $this->redirect('index.php?r=admin/dashboard');
                    } else {
                        $this->redirect('index.php?r=home/index');
                    }
                } else {
                    $error = 'Tài khoản hoặc mật khẩu không chính xác!';
                }
            }
        }

        $this->render('auth/login', [
            'pageTitle' => 'Đăng Nhập Tài Khoản',
            'error' => $error
        ]);
    }

    public function register(): void {
        if (Security::isLoggedIn()) {
            $this->redirect('index.php?r=home/index');
        }

        $errors = [];
        $formData = [
            'username' => '',
            'fullname' => '',
            'email' => ''
        ];

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            $username = trim($this->post('username', ''));
            $fullname = trim($this->post('fullname', ''));
            $email = trim($this->post('email', ''));
            $password = $this->post('password', '', true);
            $passwordConfirm = $this->post('password_confirm', '', true);

            $formData = [
                'username' => $username,
                'fullname' => $fullname,
                'email' => $email
            ];

            // 1. Kiểm tra username
            if (empty($username) || !preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
                $errors[] = 'Tên đăng nhập phải từ 3-30 ký tự, chỉ chứa chữ cái, số và dấu gạch dưới (_).';
            } elseif ($this->userModel->findByUsername($username)) {
                $errors[] = 'Tên đăng nhập này đã được sử dụng. Vui lòng chọn tên khác.';
            }

            // 2. Kiểm tra fullname
            if (empty($fullname) || mb_strlen($fullname) < 2) {
                $errors[] = 'Họ và tên không được để trống.';
            }

            // 3. Kiểm tra email
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Định dạng email không hợp lệ.';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email này đã được đăng ký tài khoản.';
            }

            // 4. Kiểm tra mật khẩu
            if (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có độ dài tối thiểu 6 ký tự.';
            } elseif ($password !== $passwordConfirm) {
                $errors[] = 'Xác nhận mật khẩu không trùng khớp.';
            }

            if (empty($errors)) {
                $hashedPassword = Security::hashPassword($password);
                $userId = $this->userModel->create($username, $hashedPassword, $fullname, $email, 'customer');

                $this->setFlash('success', 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ.');
                $this->redirect('index.php?r=auth/login');
            }
        }

        $this->render('auth/register', [
            'pageTitle' => 'Đăng Ký Tài Khoản Mới',
            'errors' => $errors,
            'formData' => $formData
        ]);
    }

    public function logout(): void {
        Security::startSecureSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->redirect('index.php?r=home/index');
    }

    public function profile(): void {
        $this->requireAuth();
        $user = Security::getUser();
        $userData = $this->userModel->findById($user['id']);

        $message = null;
        $error = null;

        if ($this->isPost()) {
            $this->validateCsrfOrAbort();

            $fullname = trim($this->post('fullname', ''));
            $email = trim($this->post('email', ''));
            $newPassword = $this->post('new_password', '', true);

            if (empty($fullname) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Dữ liệu thông tin không hợp lệ.';
            } else {
                $this->userModel->update($user['id'], [
                    'fullname' => $fullname,
                    'email' => $email,
                    'role' => $userData['role']
                ]);

                if (!empty($newPassword)) {
                    if (strlen($newPassword) < 6) {
                        $error = 'Mật khẩu mới phải từ 6 ký tự trở lên.';
                    } else {
                        $this->userModel->updatePassword($user['id'], Security::hashPassword($newPassword));
                    }
                }

                if (!$error) {
                    $_SESSION['user']['fullname'] = $fullname;
                    $_SESSION['user']['email'] = $email;
                    $message = 'Cập nhật hồ sơ tài khoản thành công!';
                    $userData = $this->userModel->findById($user['id']);
                }
            }
        }

        $this->render('auth/profile', [
            'pageTitle' => 'Hồ Sơ Cá Nhân',
            'user' => $userData,
            'message' => $message,
            'error' => $error
        ]);
    }
}
