<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = [
    "status" => 200,
    "time" => microtime(true) * 1000,
    "data" => "PHP is Working! Your server supports PHP perfectly."
];

echo json_encode($data);
?>
