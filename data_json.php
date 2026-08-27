<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$file_json = 'local_user.json';

if (!file_exists($file_json)) {
    file_put_contents($file_json, json_encode([], JSON_PRETTY_PRINT));
}

$content = file_get_contents($file_json);
$users = json_decode($content, true) ?? [];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $found = null;
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            $found = $user;
            break;
        }
    }
    
    if ($found) {
        echo json_encode(["status" => true, "data" => $found]);
    } else {
        http_response_code(404);
        echo json_encode(["status" => false, "message" => "User tidak ditemukan"]);
    }
} else {
    echo json_encode($users);
}
?>