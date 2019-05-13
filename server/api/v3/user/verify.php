<?php

require __DIR__ . "/../../../lib/errors.php";
require __DIR__ . "/../../../lib/connect.php";
header("Content-type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (Database::connect()) {
            try {
                if (isset($_GET["email"]) && isset($_GET["hash"])) {
                    $email_verified = Database::$query->query("SELECT `email_verified` from `users` where `email`='{$_GET["email"]}'")->fetchColumn();
                    if ($email_verified !== "Y") {
                        if ($_GET["hash"] === $email_verified) {
                            Database::$query->prepare("UPDATE `users` SET `email_verified`='Y' WHERE `email`='{$_GET["email"]}'")->execute();
                            echo json_encode(array(
                                "ok" => true,
                            ));
                            exit;
                        } else {
                            echo Errors::incorrectHash();
                            exit;
                        }
                    } else {
                        echo Errors::emailVerified();
                        exit;
                    }
                } else {
                    echo Errors::incompleteParams(["email", "hash"], []);
                    exit;
                }
            } catch (PDOException $e) {
                echo Errors::PDOException($e);
                exit;
            }
        }
    default:
        echo Errors::requestMethod(["GET"], $_SERVER["REQUEST_METHOD"]);
        exit;
}
