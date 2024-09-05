<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$secret_key = 'cT4F!v9Bx8@jKlM2p3sT5q7#r8Vx1Z*5';
$method = $_SERVER["REQUEST_METHOD"];
header("Content-type: application/json");

function handleAuth()
{
    global $secret_key;
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $jwt = $matches[1];
            try {
                $key = new Key($secret_key, 'HS256');
                $decoded = JWT::decode($jwt, $key);
                if ($decoded) {
                    return 1;
                }
            } catch (Exception $e) {
                return 0;
            }
        }
    }
}

if ($method == "GET") {
    $teachers = json_decode(file_get_contents("teachers.json"), true);
    if (!$teachers) {
        http_response_code(404);
        echo json_encode(["message" => "Teachers not found"]);
        return;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $current_teacher = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });

        if (!$current_teacher) {
            http_response_code(404);
            echo json_encode(["message" => "Teacher not found"]);
            return;
        }
        http_response_code(200);
        echo json_encode($current_teacher);
        return;
    }

    http_response_code(200);
    print_r(json_encode($teachers));
} else if ($method == "POST") {
    $isAuthorized = handleAuth();
    if (!$isAuthorized) {
        http_response_code(403);
        echo json_encode(["message" => "Unauthorized"]);
        return;
    }


    $requestBody = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestBody["firstName"]) || !isset($requestBody["lastName"]) || !isset($requestBody["username"]) || !isset($requestBody["password"])) {
        http_response_code(400);
        echo json_encode(["message" => "Please fill all required fields!"]);
        return;
    }

    $firstName = $requestBody["firstName"];
    $lastName = $requestBody["lastName"];
    $username = $requestBody["username"];
    $password = $requestBody["password"];

    $teachers = json_decode(file_get_contents("teachers.json"), true);
    $newTeacherId = end($teachers)["id"] + 1;
    $newTeacher = [
        "id" => $newTeacherId,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "username" => $username,
        "password" => $password
    ];

    array_push($teachers, $newTeacher);
    file_put_contents("teachers.json", json_encode($teachers));
    http_response_code(200);
    echo json_encode(["message" => "Teacher created successfully"]);
} else if ($method == "PATCH") {
    $isAuthorized = handleAuth();
    if (!$isAuthorized) {
        http_response_code(403);
        echo json_encode(["message" => "Unauthorized"]);
        return;
    }

    $teachers = json_decode(file_get_contents("teachers.json"), true);
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $current_teacher = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });
    } else {
        http_response_code(400);
        echo json_encode(["message" => "No ID provided!"]);
        return;
    }

    if (!$current_teacher) {
        http_response_code(404);
        echo json_encode(["message" => "Teacher not found"]);
        return;
    }

    if (!isset($requestBody["firstName"]) && !isset($requestBody["lastName"]) && isset($requestBody["username"]) && isset($requestBody["password"])) {
        http_response_code(400);
        echo json_encode(["message" => "Please fill in at least one field!"]);
        return;
    }

    $requestBody = json_decode(file_get_contents('php://input'), true);
    $current_teacher = reset($current_teacher);
    $key = array_search($current_teacher, $teachers);

    foreach ($requestBody as $k => $v) {
        if (array_key_exists($k, $teachers[$key])) {
            $teachers[$key][$k] = $v;
        }
    }

    file_put_contents("teachers.json", json_encode($teachers));
    http_response_code(200);
    echo json_encode(["message" => "Teacher updated successfully"]);
} else if ($method == "DELETE") {
    $isAuthorized = handleAuth();
    if (!$isAuthorized) {
        http_response_code(403);
        echo json_encode(["message" => "Unauthorized"]);
        return;
    }

    $teachers = json_decode(file_get_contents("teachers.json"), true);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $filtered_teachers = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });

        $current_teacher = reset($filtered_teachers);

        if ($current_teacher) {

            $key = array_search($current_teacher, $teachers);
            if ($key !== false) {
                unset($teachers[$key]);

                $teachers = array_values($teachers);

                file_put_contents("teachers.json", json_encode($teachers));

                echo json_encode(["message" => "Teacher deleted successfully"]);
            } else {
                echo json_encode(["message" => "Teacher not found"]);
            }
        } else {
            echo json_encode(["message" => "Teacher not found"]);
        }
    } else {
        echo json_encode(["message" => "No ID provided"]);
    }
} else if ($method == "PUT") {
    $isAuthorized = handleAuth();
    if (!$isAuthorized) {
        http_response_code(403);
        echo json_encode(["message" => "Unauthorized"]);
        return;
    }

    $teachers = json_decode(file_get_contents("teachers.json"), true);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $filtered_teachers = array_filter($teachers, function ($teacher) use ($id) {
            return $teacher['id'] == $id;
        });

        $current_teacher = reset($filtered_teachers);
        $requestBody = json_decode(file_get_contents('php://input'), true);

        if (!isset($requestBody["firstName"]) || !isset($requestBody["lastName"]) || !isset($requestBody["username"]) || !isset($requestBody["password"])) {
            http_response_code(400);
            echo json_encode(["message" => "Please provide all required fields"]);
            return;
        }

        $firstName = $requestBody["firstName"];
        $lastName = $requestBody["lastName"];
        $username = $requestBody["username"];
        $password = $requestBody["password"];

        if ($current_teacher) {
            $key = array_search($current_teacher, $teachers);
            $teachers[$key]["firstName"] = $firstName;
            $teachers[$key]["lastName"] = $lastName;
            $teachers[$key]["username"] = $username;
            $teachers[$key]["password"] = $password;

            file_put_contents("teachers.json", json_encode($teachers));
            echo json_encode(["message" => "Teacher updated successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Teacher not found"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "No ID provided"]);
    }
}

