<?php
$responseData = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $khotian_no = $_POST['khotian_no'];

    $url = "https://api.ldtax.gov.bd/api/v1/verifyKhotianWithPorcha";

    $payload = [
        "division_id" => 7,
        "district_id" => 61,
        "upazila_id" => 502,
        "mouja_id" => 104514,
        "survey" => "SA-8",
        "khotian_no" => $khotian_no,
        "holding" => "",
        "attachment" => "",
        "owner_type" => null,
        "is_warish" => true
    ];

    $headers = [
        "Accept: application/json",
        "Content-Type: application/json",
        "Origin: https://portal.ldtax.gov.bd",
        "Referer: https://portal.ldtax.gov.bd/",
        "User-Agent: Mozilla/5.0"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_ENCODING, "");

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
    } else {
        $responseData = json_decode($response, true);
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Khotian Verify</title>
    <style>
        body {
            background: #e8f5e9;
            font-family: Arial, sans-serif;
        }
        .box {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 2px solid #4caf50;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #4caf50;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #388e3c;
        }
        pre {
            background: #f1f8e9;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            color: #1b5e20;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Khotian Verification</h2>

    <form method="post">
        <input type="text" name="khotian_no" placeholder="Enter Khotian Number" required>
        <button type="submit">Verify</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($responseData): ?>
        <h3 style="color:#2e7d32;">API Response:</h3>
        <pre><?= json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
    <?php endif; ?>
</div>

</body>
</html>
