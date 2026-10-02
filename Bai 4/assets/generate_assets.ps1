Add-Type -AssemblyName System.Drawing

$imgDir = "c:\Users\datpu\Desktop\Code\CNWAT\Bai 4\assets\images"

# 1. banner.jpg (720x150)
$bmp = [System.Drawing.Bitmap]::new(720, 150)
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias

$pt1 = [System.Drawing.Point]::new(0, 0)
$pt2 = [System.Drawing.Point]::new(720, 150)
$color1 = [System.Drawing.Color]::FromArgb(235, 70, 70)
$color2 = [System.Drawing.Color]::FromArgb(245, 140, 50)
$brush = [System.Drawing.Drawing2D.LinearGradientBrush]::new($pt1, $pt2, $color1, $color2)
$g.FillRectangle($brush, 0, 0, 720, 150)

# Star
$starBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(255, 235, 59))
$cx = 640; $cy = 55; $rOuter = 30; $rInner = 13
$pts = [System.Drawing.PointF[]]::new(10)
for ($i = 0; $i -lt 10; $i++) {
    $r = if ($i % 2 -eq 0) { $rOuter } else { $rInner }
    $angle = $i * [Math]::PI / 5 - [Math]::PI / 2
    $pts[$i] = [System.Drawing.PointF]::new(($cx + $r * [Math]::Cos($angle)), ($cy + $r * [Math]::Sin($angle)))
}
$g.FillPolygon($starBrush, $pts)

# Portrait Bac Ho
$pBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(255, 248, 240))
$g.FillEllipse($pBrush, 30, 15, 120, 120)
$goldPen = [System.Drawing.Pen]::new([System.Drawing.Color]::FromArgb(255, 215, 0), 3)
$g.DrawEllipse($goldPen, 30, 15, 120, 120)

$faceBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(230, 195, 165))
$g.FillEllipse($faceBrush, 65, 35, 50, 50)
$bodyBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(60, 90, 150))
$g.FillEllipse($bodyBrush, 45, 85, 90, 60)

# Banner Text
$fontBig = [System.Drawing.Font]::new("Arial", 12, [System.Drawing.FontStyle]::Bold)
$fontMed = [System.Drawing.Font]::new("Arial", 10, [System.Drawing.FontStyle]::Bold)
$fontSmall = [System.Drawing.Font]::new("Arial", 9, [System.Drawing.FontStyle]::Regular)
$whiteBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::White)
$goldBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(255, 245, 160))

$g.DrawString("KY NIEM 120 NAM NGAY SINH CHU TICH HO CHI MINH", $fontBig, $goldBrush, 170, 32)
$g.DrawString("BAI THUC HANH PHP & CO SO DU LIEU - PHIEN BAN 2.1", $fontMed, $whiteBrush, 170, 65)
$g.DrawString("Hoc Vien Ky Thuat Mat Ma - Khoa An Toan Thong Tin", $fontSmall, $whiteBrush, 170, 95)

$bmp.Save("$imgDir\banner.jpg", [System.Drawing.Imaging.ImageFormat]::Jpeg)
$g.Dispose()
$bmp.Dispose()

# 2. avatar.jpg (120x120)
$bmp2 = [System.Drawing.Bitmap]::new(120, 120)
$g2 = [System.Drawing.Graphics]::FromImage($bmp2)
$g2.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$bgBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(30, 58, 138))
$g2.FillRectangle($bgBrush, 0, 0, 120, 120)

$avCircle = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(59, 130, 246))
$g2.FillEllipse($avCircle, 10, 10, 100, 100)
$avPen = [System.Drawing.Pen]::new([System.Drawing.Color]::White, 2)
$g2.DrawEllipse($avPen, 10, 10, 100, 100)

$fBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(254, 215, 170))
$g2.FillEllipse($fBrush, 40, 25, 40, 40)
$shirtBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(241, 245, 249))
$g2.FillEllipse($shirtBrush, 25, 68, 70, 50)
$tieBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(220, 38, 38))
$tiePts = @(
    ([System.Drawing.PointF]::new(60, 68)),
    ([System.Drawing.PointF]::new(55, 95)),
    ([System.Drawing.PointF]::new(60, 105)),
    ([System.Drawing.PointF]::new(65, 95))
)
$g2.FillPolygon($tieBrush, $tiePts)

$bmp2.Save("$imgDir\avatar.jpg", [System.Drawing.Imaging.ImageFormat]::Jpeg)
$g2.Dispose()
$bmp2.Dispose()

# 3. Student avatar photos 1.jpg, 2.jpg, 3.jpg, 4.jpg
$colors = @(
    [System.Drawing.Color]::FromArgb(217, 70, 239),
    [System.Drawing.Color]::FromArgb(14, 165, 233),
    [System.Drawing.Color]::FromArgb(245, 158, 11),
    [System.Drawing.Color]::FromArgb(16, 185, 129)
)
for ($k = 0; $k -lt 4; $k++) {
    $b = [System.Drawing.Bitmap]::new(100, 100)
    $gb = [System.Drawing.Graphics]::FromImage($b)
    $gb.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $sbr = [System.Drawing.SolidBrush]::new($colors[$k])
    $gb.FillEllipse($sbr, 5, 5, 90, 90)
    $face = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(254, 215, 170))
    $gb.FillEllipse($face, 30, 20, 40, 40)
    $body = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(30, 41, 59))
    $gb.FillEllipse($body, 18, 60, 64, 40)
    $b.Save("$imgDir\$($k+1).jpg", [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gb.Dispose()
    $b.Dispose()
}

# 4. Laptop product images
$laptops = @("dell_vostro.jpg", "hp_compaq.jpg", "macbook_pro.jpg", "asus_zenbook.jpg", "lenovo_thinkpad.jpg", "acer_aspire.jpg")
$lapTitles = @("Dell Vostro", "HP Compaq", "MacBook Pro", "ASUS ZenBook", "Lenovo ThinkPad", "Acer Aspire")
$fLap = [System.Drawing.Font]::new("Arial", 12, [System.Drawing.FontStyle]::Bold)

for ($idx = 0; $idx -lt $laptops.Length; $idx++) {
    $lp = [System.Drawing.Bitmap]::new(300, 200)
    $gl = [System.Drawing.Graphics]::FromImage($lp)
    $gl.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $bgL = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(241, 245, 249))
    $gl.FillRectangle($bgL, 0, 0, 300, 200)
    # Screen
    $screen = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(15, 23, 42))
    $gl.FillRectangle($screen, 40, 25, 220, 120)
    # Bezel
    $penBezel = [System.Drawing.Pen]::new([System.Drawing.Color]::FromArgb(71, 85, 105), 4)
    $gl.DrawRectangle($penBezel, 40, 25, 220, 120)
    # Base / keyboard
    $baseBrush = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(148, 163, 184))
    $basePts = @(
        ([System.Drawing.PointF]::new(20, 150)),
        ([System.Drawing.PointF]::new(280, 150)),
        ([System.Drawing.PointF]::new(290, 175)),
        ([System.Drawing.PointF]::new(10, 175))
    )
    $gl.FillPolygon($baseBrush, $basePts)
    # Title
    $tb = [System.Drawing.SolidBrush]::new([System.Drawing.Color]::FromArgb(56, 189, 248))
    $gl.DrawString($lapTitles[$idx], $fLap, $tb, 60, 70)
    $lp.Save("$imgDir\$($laptops[$idx])", [System.Drawing.Imaging.ImageFormat]::Jpeg)
    $gl.Dispose()
    $lp.Dispose()
}

# Copy assets to each mission directory
$missions = @(
    "NhiemVu01_Template",
    "NhiemVu02_SuDungTemplate",
    "NhiemVu03_LayVaGuiDuLieu",
    "NhiemVu04_GetForm",
    "NhiemVu05_Session",
    "NhiemVu06_Cookie",
    "NhiemVu07_Function",
    "NhiemVu08_DocGhiFile",
    "NhiemVu09_QuanLyFile_QLSV",
    "NhiemVu10_DaNgonNgu",
    "NhiemVu11_CSDL_QuanLyHocSinh",
    "NhiemVu12_TruyVanDuLieu",
    "NhiemVu13_16_WebBanLaptop"
)

foreach ($m in $missions) {
    $targetImgDir = "c:\Users\datpu\Desktop\Code\CNWAT\Bai 4\$m\images"
    Copy-Item "$imgDir\*" -Destination $targetImgDir -Force
}

Write-Output "ALL ASSETS CREATED SUCCESSFULLY!"
