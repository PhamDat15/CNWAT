<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 11: Quản Lý Học Sinh MySQL | Phạm Tiến Đạt - AT200311</title>
    <link rel="stylesheet" href="../NhiemVu03_LayVaGuiDuLieu/style.css">
    <style>
        .db-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 15px;
        }
        .db-table th {
            background: #f1f5f9;
            color: #1e293b;
            padding: 10px;
            font-size: 13px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }
        .db-table td {
            padding: 8px 10px;
            font-size: 13px;
            border: 1px solid #cbd5e1;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 6px;
        }
        .pagination a {
            padding: 5px 12px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #1e293b;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }
        .pagination a.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="student-info">
            <p><strong>Thông tin của sinh viên:</strong></p>
            <p>Họ và tên: Phạm Tiến Đạt</p>
            <p>MSSV: AT200311</p>
            <p>Lớp: AT20A</p>
            <img src="images/avatar.jpg" alt="Avatar" width="80" height="80">
        </div>
        <div class="banner">
            <img src="images/banner.jpg" alt="Banner Bác Hồ">
        </div>
    </header>

    <div class="container">
