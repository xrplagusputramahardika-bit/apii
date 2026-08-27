<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, DELETE");

$file_json = 'local_user.json';

function readData($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function saveData($file, $data) {
    return file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
}

// Validasi input: Menghapus pengecekan 'website' & mendukung format nomor telepon internasional/luar negeri
function validateInput($input) {
    $required_fields = ['name', 'username', 'email'];
    
    foreach ($required_fields as $field) {
        if (!isset($input[$field]) || trim($input[$field]) === '') {
            return "Field '" . ucfirst($field) . "' wajib diisi dan tidak boleh kosong.";
        }
    }

    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid (contoh: user@example.com).";
    }

    // Mendukung tanda +, spasi, titik, strip, kurung, dan ekstensi 'x' serta batas panjang s.d 40 karakter
    if (!empty($input['phone']) && !preg_match('/^[0-9+\-\s().xX]{5,40}$/', $input['phone'])) {
        return "Format nomor telepon tidak valid.";
    }

    return null;
}

$method = $_SERVER['REQUEST_METHOD'];
$users = readData($file_json);
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'POST':
        $validationError = validateInput($input);
        if ($validationError !== null) {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => $validationError]);
            exit;
        }

        $maxId = 0;
        foreach ($users as $u) {
            if ($u['id'] > $maxId) $maxId = $u['id'];
        }
        
        $newUser = [
            "id" => $maxId + 1,
            "name" => trim($input['name']),
            "username" => trim($input['username']),
            "email" => trim($input['email']),
            "address" => [
                "street" => trim($input['street'] ?? ''),
                "suite" => trim($input['suite'] ?? ''),
                "city" => trim($input['city'] ?? ''),
                "zipcode" => trim($input['zipcode'] ?? ''),
                "geo" => ["lat" => "0", "lng" => "0"]
            ],
            "phone" => trim($input['phone'] ?? ''),
            "website" => "",
            "company" => ["name" => "", "catchPhrase" => "", "bs" => ""]
        ];

        $users[] = $newUser;
        saveData($file_json, $users);

        http_response_code(201);
        echo json_encode(["status" => true, "message" => "User berhasil ditambahkan"]);
        break;

    case 'PUT':
        if (empty($input['id'])) {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "ID User wajib disertakan"]);
            exit;
        }

        $validationError = validateInput($input);
        if ($validationError !== null) {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => $validationError]);
            exit;
        }

        $id = intval($input['id']);
        $updated = false;

        foreach ($users as &$user) {
            if ($user['id'] === $id) {
                $user['name'] = trim($input['name']);
                $user['username'] = trim($input['username']);
                $user['email'] = trim($input['email']);
                if (!isset($user['address']) || !is_array($user['address'])) {
                    $user['address'] = [];
                }
                $user['address']['city'] = trim($input['city'] ?? '');
                $user['address']['street'] = trim($input['street'] ?? '');
                $user['address']['suite'] = trim($input['suite'] ?? '');
                $user['address']['zipcode'] = trim($input['zipcode'] ?? '');
                $user['phone'] = trim($input['phone'] ?? '');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            saveData($file_json, $users);
            echo json_encode(["status" => true, "message" => "Data user berhasil diperbarui"]);
        } else {
            http_response_code(404);
            echo json_encode(["status" => false, "message" => "User tidak ditemukan"]);
        }
        break;

    case 'DELETE':
        if (!empty($input['id'])) {
            $id = intval($input['id']);
            $initialCount = count($users);
            
            $users = array_filter($users, function($user) use ($id) {
                return $user['id'] !== $id;
            });

            if (count($users) < $initialCount) {
                saveData($file_json, $users);
                echo json_encode(["status" => true, "message" => "User berhasil dihapus"]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "User tidak ditemukan"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => "ID tidak valid"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["status" => false, "message" => "Method tidak diizinkan"]);
        break;
}
?>