<?php
// =============================
// ম্যানুয়াল ইনপুট নেওয়া অংশ
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'] ?? 'N/A';
    $nameEn     = $_POST['nameEn'] ?? 'N/A';
    $nid10      = $_POST['nid10'] ?? 'N/A';
    $nid17      = $_POST['nid17'] ?? 'N/A';
    $dob        = $_POST['dob'] ?? 'N/A';
    $pin        = $_POST['pin'] ?? 'N/A';
    $gender     = $_POST['gender'] ?? 'N/A';
    $father     = $_POST['father'] ?? 'N/A';
    $mother     = $_POST['mother'] ?? 'N/A';
    $spouse     = $_POST['spouse'] ?? 'N/A';
    $armo       = $_POST['armo'] ?? 'N/A';
    $bloodGroup = $_POST['bloodGroup'] ?? 'N/A';
    $occupation = $_POST['occupation'] ?? 'N/A';
    $birthPlace = $_POST['birthPlace'] ?? 'N/A';
    $presentAddress   = $_POST['presentAddress'] ?? 'N/A';
    $permanentAddress = $_POST['permanentAddress'] ?? 'N/A';

    // ছবি আপলোড প্রসেস
    $photo = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES["photo"]["name"]);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "gif"];

        if (in_array($fileType, $allowed)) {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);
            $photo = $targetFile;
        } else {
            $photo = "";
        }
    }
} else {
    // ফর্ম সাবমিট না হলে ফাঁকা রাখবে
    $name = $nameEn = $nid10 = $nid17 = $dob = $pin = $gender = $photo = "";
    $father = $mother = $spouse = $armo = $bloodGroup = $occupation = $birthPlace = "";
    $presentAddress = $permanentAddress = "";
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $nameEn ?: "Manual NID Entry" ?></title>
<link rel="icon" href="https://surokkha.gov.bd/favicon.png">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
<style>
@import url('https://fonts.maateen.me/solaiman-lipi/font.css');
body { font-family: SolaimanLipi; margin: 0; text-align: center; background: #f0f0f0; }
.container { width: 900px; margin: 20px auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px #aaa; }
input[type=text], input[type=url], input[type=file], textarea {
    width: 95%; padding: 8px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px; font-family: SolaimanLipi;
}
label { font-weight: bold; }
button {
    background: linear-gradient(45deg,#03a9f4,#1e88e5);
    border:none;color:white;padding:10px 20px;border-radius:25px;
    font-size:16px;font-weight:bold;cursor:pointer;
}
button:hover { background: linear-gradient(45deg,#1e88e5,#03a9f4); }
hr { margin: 15px 0; border: 0; border-top: 1px solid #ddd; }
.background { background-color: lightgrey; position: relative; width: 875px; height: 1180px; margin: auto; }
.crane { width: 100%; height: 100%; }
.info-box { position: absolute; font-size: 14px; }
.title { font-size: 16px; font-weight: bold; }
</style>
</head>
<body>

<?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>

<div class="container">
    <h2>ম্যানুয়াল NID তথ্য ইনপুট দিন</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>নাম (বাংলা):</label><input type="text" name="name" required>
        <label>নাম (ইংরেজি):</label><input type="text" name="nameEn" required>
        <label>NID নম্বর:</label><input type="text" name="nid10" required>
        <label>গ্রাম/রাস্তা:</label><input type="text" name="nid17">
        <label>জন্ম তারিখ:</label><input type="text" name="dob" placeholder="YYYY-MM-DD">
        <label>পিন নম্বর:</label><input type="text" name="pin">
        <label>ভোটার এলাকা নম্বর:</label><input type="text" name="armo">
        <label>বাবার নাম:</label><input type="text" name="father">
        <label>মায়ের নাম:</label><input type="text" name="mother">
        <label>স্বামী/স্ত্রী:</label><input type="text" name="spouse">
        <label>লিঙ্গ:</label><input type="text" name="gender">
        <label>জন্মস্থান:</label><input type="text" name="birthPlace">
        <label>রক্তের গ্রুপ:</label><input type="text" name="bloodGroup">
        <label>পেশা:</label><input type="text" name="occupation">
        <label>বর্তমান ঠিকানা:</label><textarea name="presentAddress" rows="2"></textarea>
        <label>স্থায়ী ঠিকানা:</label><textarea name="permanentAddress" rows="2"></textarea>
        <label>ছবি আপলোড করুন:</label><input type="file" name="photo" accept="image/*">
        <button type="submit">তথ্য সংরক্ষণ ও রিপোর্ট দেখুন</button>
    </form>
</div>

<?php else: ?>

<div class="background">
    <img class="crane" src="https://raw.githubusercontent.com/matherofsetuxyz/hfhtf/main/cbimage.png">

    <div style="position: absolute; left: 30%; top: 8%; color: rgb(255 224 0); font-weight:bold;">National Identity Registration Wing (NIDW)</div>

    <div class="info-box title" style="left: 37%; top: 27%;">জাতীয় পরিচিতি তথ্য</div>
    <div class="info-box" style="left: 37%; top: 29.7%;">জাতীয় পরিচয় পত্র নম্বর:</div>
    <div class="info-box" style="left: 55%; top: 29.7%;"><?= $nid10 ?></div>
    <div class="info-box" style="left: 37%; top: 32.5%;">গ্রাম/রাস্তা:</div>
    <div class="info-box" style="left: 55%; top: 32.5%;"><?= $nid17 ?></div>
    <div class="info-box" style="left: 37%; top: 35.3%;">জন্ম তারিখ:</div>
    <div class="info-box" style="left: 55%; top: 35.3%;"><?= $dob ?></div>
    <div class="info-box" style="left: 37%; top: 38.0%;">পিন নম্বর:</div>
    <div class="info-box" style="left: 55%; top: 38.0%;"><?= $pin ?></div>
    <div class="info-box" style="left: 37%; top: 40.5%;">ভোটার এলাকা নম্বর:</div>
    <div class="info-box" style="left: 55%; top: 40.7%;"><?= $armo ?></div>

    <div class="info-box title" style="left: 37%; top: 43%;">ব্যক্তিগত তথ্য</div>
    <div class="info-box" style="left: 37%; top: 45.6%;">নাম (বাংলা):</div>
    <div class="info-box" style="left: 55%; top: 45.6%;"><?= $name ?></div>
    <div class="info-box" style="left: 37%; top: 48.5%;">নাম (ইংরেজি):</div>
    <div class="info-box" style="left: 55%; top: 48.5%;"><?= $nameEn ?></div>
    <div class="info-box" style="left: 37%; top: 51.4%;">বাবার নাম:</div>
    <div class="info-box" style="left: 55%; top: 51.4%;"><?= $father ?></div>
    <div class="info-box" style="left: 37%; top: 54%;">মায়ের নাম:</div>
    <div class="info-box" style="left: 55%; top: 54%;"><?= $mother ?></div>
    <div class="info-box" style="left: 37%; top: 56.5%;">স্বামী/স্ত্রী:</div>
    <div class="info-box" style="left: 55%; top: 56.5%;"><?= $spouse ?></div>

    <div class="info-box title" style="left: 37%; top: 59%;">অন্যান্য তথ্য</div>
    <div class="info-box" style="left: 37%; top: 62.2%;">লিঙ্গ:</div>
    <div class="info-box" style="left: 55%; top: 62.2%;"><?= $gender ?></div>
    <div class="info-box" style="left: 37%; top: 64.8%;">জন্মস্থান:</div>
    <div class="info-box" style="left: 55%; top: 64.8%;"><?= $birthPlace ?></div>
    <div class="info-box" style="left: 37%; top: 67.5%;">রক্তের গ্রুপ:</div>
    <div class="info-box" style="left: 55%; top: 67.5%;"><?= $bloodGroup ?></div>
    <div class="info-box" style="left: 37%; top: 70.1%;">পেশা:</div>
    <div class="info-box" style="left: 55%; top: 70.5%;"><?= $occupation ?></div>

    <div class="info-box title" style="left: 37%; top: 73%;">বর্তমান ঠিকানা</div>
    <div class="info-box" style="left: 37%; top: 75.3%; width: 48%;"><?= $presentAddress ?></div>
    <div class="info-box title" style="left: 37%; top: 82%;">স্থায়ী ঠিকানা</div>
    <div class="info-box" style="left: 37%; top: 84.5%; width: 48%;"><?= $permanentAddress ?></div>

    <div style="position: absolute; left: 16%; top: 25.7%;">
        <img src="<?= htmlspecialchars($photo) ?>" height="140px" width="121px" style="border-radius: 10px;">
    </div>

    <div style="position: absolute; left: 15.5%; top: 44.0%;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($nameEn.' '.$nid10.' '.$dob) ?>" height="100px" width="100px">
    </div>

    <div style="position: absolute; top: 92%; width: 100%; font-size: 12px; text-align: center; color: rgb(255, 0, 0);">
        উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।
    </div>
    <div style="position: absolute; top: 93.5%; width: 100%; text-align: center; font-size: 12px; color: rgb(3, 3, 3);">
        This is Software Generated Report From Bangladesh Election Commission, Signature & Seal Aren't Required.
    </div>

    <button id="print" onclick="window.print()" style="position:absolute;top:97%;left:43%;">SAVE</button>
</div>

<?php endif; ?>
</body>
</html>
