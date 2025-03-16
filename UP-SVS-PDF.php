<?php
// **NID এবং DOB সেট করা**
$nid = $_GET['nid'] ?? '';  // ইউজারের NID
$dob = $_GET['dob'] ?? '';  // ইউজারের DOB

// **API URL তৈরি করা**
$api_url = "http://rakib-official.top/v.php?nid=" . urlencode($nid) . "&dob=" . urlencode($dob);

// **cURL দিয়ে API কল করা**
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

// **cURL ত্রুটি চেক করুন**
if (curl_errno($ch)) {
    die("cURL ত্রুটি: " . curl_error($ch));
}
curl_close($ch);

// **JSON ডাটা প্রসেস করা**
$data = json_decode($response, true);

// **JSON ডিকোডিং ত্রুটি চেক করুন**
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON ডাটা প্রসেসিং ত্রুটি: " . json_last_error_msg());
}

// **API রেসপন্স ঠিক আছে কি না চেক করুন**
if (!$data || !isset($data['status']) || $data['status'] !== "success") {
    die("API সার্ভারে সমস্যা হচ্ছে, অনুগ্রহ করে পরে চেষ্টা করুন।");
}

$apiResponse = $data['api_1_response'];

// **API কল সফল হলে ডাটা প্রসেস করুন**
$name = $apiResponse['name'] ?? 'N/A';
$nameEn = $apiResponse['nameEn'] ?? 'N/A';
$nid10 = $apiResponse['nationalId'] ?? 'N/A';
$nid17 = $apiResponse['presentAddress']['additionalVillageOrRoad'] ?? 'N/A';
$dob = $apiResponse['dateOfBirth'] ?? 'N/A';
$dobBn = $data['dobBn'] ?? 'N/A';
$old = $apiResponse['occupation'] ?? 'N/A';
$pin = $data['pin'] ?? 'N/A';
$gender = $data['gender'] ?? 'N/A';
$photo = $apiResponse['photo'] ?? '';
$father = $apiResponse['father'] ?? 'N/A';
$mother = $apiResponse['mother'] ?? 'N/A';
$spouse = $apiResponse['spouse'] ?? 'N/A';
$armo = $apiResponse['presentAddress']['postalCode'] ?? 'N/A';
$bloodGroup = $apiResponse['bloodGroup'] ?? 'N/A';
$occupation = $data['occupation'] ?? 'N/A';
$birthPlace = $apiResponse['permanentAddress']['district'] ?? 'N/A';

// **বর্তমান ঠিকানা সেট করুন**
$presentAddress = $data['presentAddressLine'] ?? 'N/A';
// **স্থায়ী ঠিকানা সেট করুন**
$permanentAddress = $data['permanentAddressLine'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nameEn ?></title>
    <link rel="icon" href="https://surokkha.gov.bd/favicon.png">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        @import url('https://fonts.maateen.me/solaiman-lipi/font.css');
        body {
            font-family: Solaimanlipi;
            text-align: center;
            margin: 0;
        }
        .background {
            background-color: lightgrey;
            position: relative;
            width: 875px;
            height: 1180px;
            margin: auto;
        }
        .crane {
            width: 100%;
            height: 100%;
        }
        #print {
            background: linear-gradient(45deg, #03a9f4, #1e88e5);
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: #fff;
            border: none;
            border-radius: 25px;
            margin: 20px;
            text-transform: uppercase;
        }
        #print:hover {
            background: linear-gradient(45deg, #1e88e5, #03a9f4);
        }
        .info-box {
            position: absolute;
            font-size: 14px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body onload="showprint()">
    <div class="background">
        <img class="crane" src="https://raw.githubusercontent.com/matherofsetuxyz/hfhtf/main/cbimage.png">
        
        <div style="position: absolute; left: 30%; top: 8%; width: auto; font-size: 16px; color: rgb(255 224 0);"><b>National Identity Registration Wing (NIDW)</b></div>
        <div style="position: absolute; left: 37%; top: 11%; width: auto; font-size: 14px; color: rgb(255, 47, 161);"><b>Select Your Search Category</b></div>
        <div style="position: absolute; left: 45%; top: 12.8%; width: auto; font-size: 12px; color: rgb(8, 121, 4);">Search By NID / Voter No.</div>
        <div style="position: absolute; left: 45%; top: 14.3%; width: auto; font-size: 12px; color: rgb(7, 119, 184);">Search By Form No.</div>
        <div style="position: absolute; left: 30%; top: 16.9%; width: auto; font-size: 12px; color: rgb(252, 0, 0);"><b>NID or Voter No*</b></div>
        <div style="position: absolute; left: 45%; top: 16.9%; width: auto; font-size: 12px; color: rgb(143, 143, 143);">NID</div>
        <div style="position: absolute; left: 62.9%; top: 17.1%; width: auto; font-size: 11px; color: rgb(255 255 255);">Submit</div>
        <div style="position: absolute; left: 89%; top: 11.55%; width: auto; font-size: 11px; color: #fff;">Home</div>

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
        <div class="info-box" style="left: 55%; top: 45.6%;"><?= $name ?></b></div>
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
        <div class="info-box" style="left: 55%; top: 70.5%;"><?= $old ?></div>

        <div class="info-box title" style="left: 37%; top: 73%;">বর্তমান ঠিকানা</div>
        <div class="info-box" style="left: 37%; top: 75.3%; width: 48%;"><?= $presentAddress ?></div>
        <div class="info-box title" style="left: 37%; top: 82%;">স্থায়ী ঠিকানা</div>
        <div class="info-box" style="left: 37%; top: 84.5%; width: 48%;"><?= $permanentAddress ?></div>
        
        <div style="position: absolute; top: 92%; width: 100%; font-size: 12px; text-align: center; color: rgb(255, 0, 0);">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</div>
        <div style="position: absolute; top: 93.5%; width: 100%; text-align: center; font-size: 12px; color: rgb(3, 3, 3);">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.</div>


        <div style="position: absolute; left: 16%; top: 25.7%;">
            <img src="<?= $photo ?>" height="140px" width="121px" style="border-radius: 10px;">
        </div>

        <div style="position: absolute; left: 15.5%; top: 44.0%;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($nameEn . ' ' . $nationalid . ' ' . $dob) ?>" height="100px" width="100px">
        </div>
        
        <button id="print" onclick="window.print()">SAVE</button>
    </div>

    <script>
        function showprint() {
            $("#print").show(500);
        }
    </script>
</body>
</html>