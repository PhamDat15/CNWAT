<?php
// ========================================================
// HỌC VIỆN KỸ THUẬT MẬT MÃ - KHOA AN TOÀN THÔNG TIN
// BÀI THỰC HÀNH 4: PHP VÀ CSDL - THƯ VIỆN HÀM XỬ LÝ MA TRẬN
// ========================================================

// 1. Tìm phần tử lớn nhất trong ma trận
function maxMatran($mang2Chieu) {
    $max = $mang2Chieu[0][0];
    for ($i = 0; $i < count($mang2Chieu); $i++) {
        for ($j = 0; $j < count($mang2Chieu[$i]); $j++) {
            if ($mang2Chieu[$i][$j] > $max) {
                $max = $mang2Chieu[$i][$j];
            }
        }
    }
    return $max;
}

// 2. Tìm phần tử nhỏ nhất trong ma trận
function minMatran($mang2Chieu) {
    $min = $mang2Chieu[0][0];
    for ($i = 0; $i < count($mang2Chieu); $i++) {
        for ($j = 0; $j < count($mang2Chieu[$i]); $j++) {
            if ($mang2Chieu[$i][$j] < $min) {
                $min = $mang2Chieu[$i][$j];
            }
        }
    }
    return $min;
}

// 3. Tính tổng các phần tử trên đường chéo chính (i == j)
function tongTrenCheoChinh($mang2Chieu) {
    $sum = 0;
    $n = min(count($mang2Chieu), count($mang2Chieu[0]));
    for ($i = 0; $i < $n; $i++) {
        $sum += $mang2Chieu[$i][$i];
    }
    return $sum;
}

// 4. Tính tổng các phần tử trên đường chéo phụ (j == n - 1 - i)
function tongTrenCheoPhu($mang2Chieu) {
    $sum = 0;
    $n = min(count($mang2Chieu), count($mang2Chieu[0]));
    for ($i = 0; $i < $n; $i++) {
        $sum += $mang2Chieu[$i][$n - 1 - $i];
    }
    return $sum;
}

// 5. Tính ma trận tổng của hai ma trận cùng kích thước
function tinhMatranTong($matran1, $matran2) {
    $rows = count($matran1);
    $cols = count($matran1[0]);
    $res = [];
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            $res[$i][$j] = $matran1[$i][$j] + $matran2[$i][$j];
        }
    }
    return $res;
}

// 6. Tính ma trận tích của hai ma trận (m x k nhân k x n)
function tinhMatranTich($matran1, $matran2) {
    $rows1 = count($matran1);
    $cols1 = count($matran1[0]);
    $cols2 = count($matran2[0]);
    $res = [];

    for ($i = 0; $i < $rows1; $i++) {
        for ($j = 0; $j < $cols2; $j++) {
            $res[$i][$j] = 0;
            for ($k = 0; $k < $cols1; $k++) {
                $res[$i][$j] += $matran1[$i][$k] * $matran2[$k][$j];
            }
        }
    }
    return $res;
}
?>
