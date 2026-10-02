<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - THƯ VIỆN HÀM MẢNG SỐ
// ========================================================

// 1. Tìm giá trị nhỏ nhất trong mảng
function minDay($mangSo) {
    if (empty($mangSo)) return 0;
    $min = $mangSo[0];
    foreach ($mangSo as $val) {
        if ($val < $min) {
            $min = $val;
        }
    }
    return $min;
}

// 2. Tìm giá trị lớn nhất trong mảng
function maxDay($mangSo) {
    if (empty($mangSo)) return 0;
    $max = $mangSo[0];
    foreach ($mangSo as $val) {
        if ($val > $max) {
            $max = $val;
        }
    }
    return $max;
}

// 3. Tính giá trị trung bình cộng của dãy số
function avgDay($mangSo) {
    if (empty($mangSo)) return 0;
    $sum = TongDay1($mangSo);
    return round($sum / count($mangSo), 2);
}

// 4. Sắp xếp dãy số tăng dần
function sortDay($mangSo) {
    $arr = $mangSo;
    sort($arr);
    return $arr;
}

// 5. Đảo ngược dãy số
function daoNguocDay($mangSo) {
    return array_reverse($mangSo);
}

// 6. Tính tổng theo cách 1: dùng vòng lặp for với count()
function TongDay1($mangSo) {
    $sum = 0;
    $len = count($mangSo);
    for ($i = 0; $i < $len; $i++) {
        $sum += $mangSo[$i];
    }
    return $sum;
}

// 7. Tính tổng theo cách 2: dùng vòng lặp foreach
function TongDay2($mangSo) {
    $sum = 0;
    foreach ($mangSo as $item) {
        $sum += $item;
    }
    return $sum;
}
?>
