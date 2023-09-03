<?php
$start_time = microtime(true);
$x = $_POST['x'];
$y = $_POST['y'];
$R = $_POST['R'];

$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = true;
    if ($x > 0 && $y > 0) {
        if ($x <= $R && ($y <= $R)) {
            $flag = true;
        } else {
            $flag = false;
        }
    } elseif ($x < 0 && $y < 0) {
        if ($x >= (-$R / 2) && $y >= (-$R / 2)) {
            $flag = true;
        } else {
            $flag = false;
        }
    } elseif ($x < 0 && $y > 0) {
        $flag = false;
    } elseif ($x > 0 && $y < 0) {
        if ($x <= ($R / 2) && $y >= (-$R)) {
            $flag = true;
        } else {
            $flag = false;
        }
    } elseif ($x === 0 && $y !== 0) {
        if ($y >= -$R && $y <= $R) {
            $flag = true;
        } else {
            $flag = false;
        }

    } elseif ($y === 0 && $x !== 0) {
        if ($y >= -$R / 2 && $y <= $R / 2) {
            $flag = true;
        } else {
            $flag = false;
        }
    } elseif ($x === 0 && $y === 0) {
        $flag = true;
    }

    if ($flag) {
        $answer = "true";
    } else {
        $answer = "false";
    }

    $response .= "<tr><td>";
    $response .= $x;
    $response .= "</td>";
    $response .= "<td>";
    $response .= $y;
    $response .= "</td>";
    $response .= "<td>";
    $response .= $R;
    $response .= "</td>";
    $response .= "<td>";
    $response .= $answer;
    $response .= "</td>";
    $response .= "<td>";
    date_default_timezone_set("Europe/Moscow");
    $response .= date('m/d/Y h:i:s a', time());
    $response .= "</td>";

    $response .= "<td>";
    $response .= microtime(true) - $start_time;
    $response .= "</td></tr>";


    echo $response;
}

?>