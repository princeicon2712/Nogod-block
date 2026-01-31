<?php
session_start();

function dms_to_deg($d, $m) {
    return $d + $m / 60;
}

function deg_to_dms($x) {
    $x = fmod($x, 360);
    if ($x < 0) $x += 360;
    $d = floor($x);
    $m = round(($x - $d) * 60);
    if ($m == 60) { $d += 1; $m = 0; }
    return $d . "°" . str_pad($m, 2, "0", STR_PAD_LEFT) . "'";
}

// Clear All
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['all_rows'] = [];
    header("Location: " . strtok($_SERVER["REQUEST_URI"],'?'));
    exit;
}

// Delete single row by line name
if (isset($_GET['delete']) && $_GET['delete'] !== '') {
    $del_line = $_GET['delete'];
    if (isset($_SESSION['all_rows'])) {
        $_SESSION['all_rows'] = array_filter($_SESSION['all_rows'], function($r) use ($del_line) {
            return $r['line'] !== $del_line;
        });
        $_SESSION['all_rows'] = array_values($_SESSION['all_rows']); // reindex
    }
    header("Location: " . strtok($_SERVER["REQUEST_URI"],'?'));
    exit;
}

// Initialize session
if (!isset($_SESSION['all_rows'])) $_SESSION['all_rows'] = [];

$rows = $_SESSION['all_rows'];

// Only add new lines to session if Generate Table pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lines = $_POST['line'] ?? [];
    $FB_deg = $_POST['FB_deg'] ?? [];
    $FB_min = $_POST['FB_min'] ?? [];
    $BB_deg = $_POST['BB_deg'] ?? [];
    $BB_min = $_POST['BB_min'] ?? [];

    $new_rows = [];
    for ($i = 0; $i < count($lines); $i++) {
        if (trim($lines[$i]) === '') continue;

        // Avoid duplicate lines
        $exists = false;
        foreach ($rows as $r) {
            if ($r['line'] === $lines[$i]) { $exists = true; break; }
        }
        if ($exists) continue;

        $FB = dms_to_deg($FB_deg[$i], $FB_min[$i]);
        $BB = dms_to_deg($BB_deg[$i], $BB_min[$i]);

        $d = $FB - $BB;
        if ($d > 0) $d -= 360;
        $E = $d + 180;
        $e = $E / 2;
        $corr_FB = $FB - $e;
        $corr_BB = $BB + $e;

        $new_rows[] = [
            'line' => $lines[$i],
            'FB' => deg_to_dms($FB),
            'BB' => deg_to_dms($BB),
            'd' => deg_to_dms($d),
            'E' => deg_to_dms($E),
            'e' => deg_to_dms($e),
            'corr_FB' => deg_to_dms($corr_FB),
            'corr_BB' => deg_to_dms($corr_BB)
        ];
    }

    // Add only new lines to session
    $_SESSION['all_rows'] = array_merge($rows, $new_rows);
    $rows = $_SESSION['all_rows']; // update current rows
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FB & BB Exam Table</title>
<style>
body { font-family: Arial, sans-serif; background-color: #e8f5e9; padding: 20px; }
h1 { color: #2e7d32; }
table { border-collapse: collapse; width: 100%; background-color: #ffffff; margin-top: 20px; }
th, td { border: 1px solid #2e7d32; padding: 6px; text-align: center; }
th { background-color: #a5d6a7; color: #1b5e20; }
tr:nth-child(even) { background-color: #c8e6c9; }
input { width: 60px; margin: 2px; }
button { padding: 6px 12px; margin: 2px; cursor: pointer; }
#addRowBtn { background-color: #43a047; color: white; border: none; }
#addRowBtn:hover { background-color: #2e7d32; }
#generateBtn { background-color: #1e88e5; color: white; border: none; }
#generateBtn:hover { background-color: #1565c0; }
#printButton { background-color: #2e7d32; color: white; border: none; }
#printButton:hover { background-color: #1b5e20; }
#clearButton { background-color: #e53935; color: white; border: none; }
#clearButton:hover { background-color: #b71c1c; }
.deleteBtn { background-color: #f44336; color: white; border: none; }
.deleteBtn:hover { background-color: #b71c1c; }
</style>
</head>
<body>

<h1>FB & BB Exam Table (Add Line One by One)</h1>

<form method="post" id="lineForm">
    <table id="inputTable">
        <tr>
            <th>Line</th>
            <th>FB (deg)</th>
            <th>FB (min)</th>
            <th>BB (deg)</th>
            <th>BB (min)</th>
        </tr>
        <?php
        if (!empty($_POST['line'])) {
            for ($i=0;$i<count($_POST['line']);$i++) {
                echo "<tr>
                    <td><input type='text' name='line[]' value='".htmlspecialchars($_POST['line'][$i])."' required></td>
                    <td><input type='number' name='FB_deg[]' value='".htmlspecialchars($_POST['FB_deg'][$i])."' required></td>
                    <td><input type='number' name='FB_min[]' value='".htmlspecialchars($_POST['FB_min'][$i])."' required></td>
                    <td><input type='number' name='BB_deg[]' value='".htmlspecialchars($_POST['BB_deg'][$i])."' required></td>
                    <td><input type='number' name='BB_min[]' value='".htmlspecialchars($_POST['BB_min'][$i])."' required></td>
                </tr>";
            }
        } else {
            echo "<tr>
                <td><input type='text' name='line[]' required></td>
                <td><input type='number' name='FB_deg[]' required></td>
                <td><input type='number' name='FB_min[]' required></td>
                <td><input type='number' name='BB_deg[]' required></td>
                <td><input type='number' name='BB_min[]' required></td>
            </tr>";
        }
        ?>
    </table>
    <button type="button" id="addRowBtn" onclick="addRow()">Add Line</button>
    <button type="submit" id="generateBtn">Generate Table</button>
</form>

<?php if (!empty($rows)) : ?>
    <button id="printButton" onclick="window.print()">SAVE / PRINT</button>
    <a href="?action=clear"><button id="clearButton" type="button">Clear All</button></a>
    <table>
        <tr>
            <th>Line</th>
            <th>FB (Obs)</th>
            <th>BB (Obs)</th>
            <th>d = FB-BB</th>
            <th>E</th>
            <th>e = E/2</th>
            <th>Corrected FB</th>
            <th>Corrected BB</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td><?= $r['line'] ?></td>
                <td><?= $r['FB'] ?></td>
                <td><?= $r['BB'] ?></td>
                <td><?= $r['d'] ?></td>
                <td><?= $r['E'] ?></td>
                <td><?= $r['e'] ?></td>
                <td><?= $r['corr_FB'] ?></td>
                <td><?= $r['corr_BB'] ?></td>
                <td>
                    <a href="?delete=<?= urlencode($r['line']) ?>"><button class="deleteBtn" type="button">Delete</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<script>
function addRow() {
    const table = document.getElementById("inputTable");
    const row = table.insertRow(-1);
    row.innerHTML = `
        <td><input type='text' name='line[]' required></td>
        <td><input type='number' name='FB_deg[]' required></td>
        <td><input type='number' name='FB_min[]' required></td>
        <td><input type='number' name='BB_deg[]' required></td>
        <td><input type='number' name='BB_min[]' required></td>
    `;
}
</script>

</body>
</html>
