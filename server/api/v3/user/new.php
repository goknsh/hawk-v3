<?php

require __DIR__ . "/../../../lib/errors.php";
require __DIR__ . "/../../../lib/connect.php";
require __DIR__ . "/../../../lib/mail.php";
header("Content-Type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (Database::connect()) {
            try {
                if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["name"])) {
                    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                    $email_hash = base64_encode(random_bytes(32));
                    if (!Database::$query->query("SELECT `email` from `users` where `email`='{$_POST["email"]}'")->fetchColumn()) {
                        if (Mail::verifyUser($_POST["email"], $_POST["name"], $email_hash)) {
                            Database::$query->prepare("INSERT into `users`(`email`, `password`, `name`, `email_verified`) values ('{$_POST["email"]}', '$password', '{$_POST["name"]}', '{$email_hash}')")->execute();
                            echo json_encode(array(
                                "ok" => true,
                            ));
                            exit;
                        } else {
                            echo Errors::unsendableEmail($_POST["email"]);
                            exit;
                        }
                    } else {
                        echo Errors::userExists($_POST["email"]);
                        exit;
                    }
                } else {
                    echo Errors::incompleteHeaders(["email", "password", "name"], []);
                    exit;
                }
            } catch (PDOException $e) {
                if ($e->getCode() === "23000") {
                    echo Errors::userExists($_POST["email"]);
                    exit;
                } else {
                    echo Errors::PDOException($e);
                    exit;
                }
            }
        }
    default:
        echo Errors::requestMethod(["POST"], $_SERVER["REQUEST_METHOD"]);
        exit;
}
