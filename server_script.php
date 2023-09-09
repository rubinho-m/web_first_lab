<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['x']) && isset($_POST['y']) && isset($_POST['R'])) {
    $start_time = microtime(true);
    $x = $_POST['x'];
    $y = $_POST['y'];
    $R = $_POST['R'];

    $response = "";

    if (is_numeric($x) && is_numeric($y) && is_numeric($R)) {
        $x_ok = false;
        $y_ok = false;
        $R_ok = false;
        $error = false;

        $x_values = [-2, -1.5, -1, -0.5, 0, 0.5, 1, 1.5, 2];
        $R_values = [1, 1.5, 2, 2.5, 3];

        if (in_array($x, $x_values) && in_array($R, $R_values) && $y >= -3 && $y <= 5) {

            if (check($x, $y, $R)) {
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
            $response .= number_format(microtime(true) - $start_time, 5, ".", "");
            $response .= "</td></tr>";
        } else {
            $response .= "The numbers are not in the range";
            $error = true;
            header("HTTP/1.1 400 Bad Request");
            require("bad_request.html");

        }
    } else {
        $error = true;
        $response .= "Only numbers are allowed";
        header("HTTP/1.1 400 Bad Request");
        require("bad_request.html");

    }
    if (!$error) {
        echo $response;
    }


}


function check($x, $y, $R): bool
{
    $flag = false;

    if (($x >= 0) && ($y >= 0)) {
        if (($x <= $R) && ($y <= $R)) {
            $flag = true;
        }
    } else if (($x <= 0) && ($y <= 0)) {
        if (($x >= -$R / 2) && ($y >= -$R / 2)){
            $flag = true;
        }
    } else if (($x >= 0) && ($y <= 0)) {
        if (($x <= $R/2) && ($y >= -$R)){
            $flag = true;
        }
    } else if ($x == 0){
        if (($y >= -$R) && ($y <= $R)){
            $flag = true;
        }
    } else if ($y == 0){
        if (($x >= -$R/2) && ($x <= $R)){
            $flag = true;
        }
    }

    return $flag;
}

?>