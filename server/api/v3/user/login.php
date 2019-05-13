<?php

require __DIR__ . "/../../../lib/errors.php";
require __DIR__ . "/../../../lib/connect.php";
require __DIR__ . "/../../../vendor/autoload.php";
header("Content-Type: application/json");
use \Firebase\JWT\JWT;
$env = json_decode(file_get_contents(__DIR__ . "/../.env.json"), true);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (Database::connect()) {
            try {
                if (isset($_POST["email"]) && isset($_POST["password"])) {
                    if (password_verify($_POST["password"], Database::$query->query("SELECT `password` from `users` where `email`='{$_POST["email"]}'")->fetchColumn())) {
                        if (Database::$query->query("SELECT `email_verified` from `users` where `email`='{$_POST["email"]}'")->fetchColumn() === "Y") {
                            $user = Database::$query->query("SELECT * from `users` where `email`='{$_POST["email"]}'")->fetch(PDO::FETCH_ASSOC);
                            echo json_encode(array(
                                "ok" => true,
                                "token" => JWT::encode(array(
                                    "iss" => "https://hawk.atanos.ga/",
                                    "aud" => "https://hawk.atanos.ga/",
                                    "iat" => time(),
                                    "nbf" => time(),
                                    "exp" => time() + 21600,
                                    "jti" => base64_encode(random_bytes(22)),
                                    "data" => array(
                                        "email" => $user["email"],
                                        "name" => $user["name"],
                                    ),
                                ), $env["jwt"]["key"]),
                            ));
                            exit;
                        } else {
                            echo Errors::unverifiedEmail();
                            exit;
                        }
                    } else {
                        echo Errors::incorrectPassword();
                        exit;
                    }
                } else {
                    echo Errors::incompleteHeaders(["email", "password"], []);
                    exit;
                }
            } catch (PDOException $e) {
                echo Errors::PDOException($e);
                exit;
            }
        }
    default:
        echo Errors::requestMethod(["POST"], $_SERVER["REQUEST_METHOD"]);
        exit;
}
