<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, DELETE");

require_once 'koneksi.php';

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

    if (!empty($input['phone']) && !preg_match('/^[0-9+\-\s().xX]{5,40}$/', $input['phone'])) {
        return "Format nomor telepon tidak valid.";
    }

    return null;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'POST':
        $validationError = validateInput($input);
        if ($validationError !== null) {
            http_response_code(400);
            echo json_encode(["status" => false, "message" => $validationError]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO users (name, username, email, city, street, suite, zipcode, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $name = trim($input['name']);
        $username = trim($input['username']);
        $email = trim($input['email']);
        $city = trim($input['city'] ?? '');
        $street = trim($input['street'] ?? '');
        $suite = trim($input['suite'] ?? '');
        $zipcode = trim($input['zipcode'] ?? '');
        $phone = trim($input['phone'] ?? '');

        $stmt->bind_param("ssssssss", $name, $username, $email, $city, $street, $suite, $zipcode, $phone);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["status" => true, "message" => "User berhasil ditambahkan ke database SQL"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => false, "message" => "Gagal menyimpan data ke database"]);
        }
        $stmt->close();
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
        $stmt = $conn->prepare("UPDATE users SET name=?, username=?, email=?, city=?, street=?, suite=?, zipcode=?, phone=? WHERE id=?");
        
        $name = trim($input['name']);
        $username = trim($input['username']);
        $email = trim($input['email']);
        $city = trim($input['city'] ?? '');
        $street = trim($input['street'] ?? '');
        $suite = trim($input['suite'] ?? '');
        $zipcode = trim($input['zipcode'] ?? '');
        $phone = trim($input['phone'] ?? '');

        $stmt->bind_param("ssssssssi", $name, $username, $email, $city, $street, $suite, $zipcode, $phone, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => true, "message" => "Data user berhasil diperbarui di database"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => false, "message" => "Gagal memperbarui data"]);
        }
        $stmt->close();
        break;

    case 'DELETE':
        if (!empty($input['id'])) {
            $id = intval($input['id']);
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                echo json_encode(["status" => true, "message" => "User berhasil dihapus dari database"]);
            } else {
                http_response_code(404);
                echo json_encode(["status" => false, "message" => "User tidak ditemukan"]);
            }
            $stmt->close();
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

$conn->close();
?>