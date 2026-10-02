<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ 2: Sử dụng Template PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <?php include 'left.php'; ?>

    <div class="main-content">
        <div class="header-img">
            <img src="images/banner.jpg" alt="Banner Bác Hồ">
        </div>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <div class="menu">
            <a href="register.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Register</a>
            <a href="result_register.php" class="<?php echo ($current_page == 'result_register.php') ? 'active' : ''; ?>">ResultRegister</a>
            <a href="calculate.php" class="<?php echo ($current_page == 'calculate.php') ? 'active' : ''; ?>">Calculate</a>
        </div>

        <div class="content">
