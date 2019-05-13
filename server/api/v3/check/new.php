<?php

require __DIR__ . "/../../../lib/errors.php";
require __DIR__ . "/../../../lib/connect.php";
require __DIR__ . "/../../../lib/auth.php";
header("Content-Type: application/json");

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (Database::connect()) {
            try {
                if (isset($_POST["url"]) && isset($_POST["name"])) {
                    $user = Auth::verify($_SERVER["HTTP_AUTHORIZATION"]);
                    if ($user) {
                        echo "Can add checks";
                        exit;
                    }
                } else {
                    echo Errors::incompleteHeaders(["url", "name"], ["interval", "threshold"]);
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

// if ($request->isGet()) {
//     $authHeader = $request->getHeader('authorization');

//     /*
//      * Look for the 'authorization' header
//      */
//     if ($authHeader) {
//         /*
//          * Extract the jwt from the Bearer
//          */
//         list($jwt) = sscanf($authHeader->toString(), 'Authorization: Bearer %s');

//         if ($jwt) {
//             try {
//                 $config = Factory::fromFile('config/config.php', true);

//                 /*
//                  * decode the jwt using the key from config
//                  */
//                 $secretKey = base64_decode($config->get('jwtKey'));

//                 $token = JWT::decode($jwt, $secretKey, array('HS512'));

//                 $asset = base64_encode(file_get_contents('http://lorempixel.com/200/300/cats/'));

//                 /*
//                  * return protected asset
//                  */
//                 header('Content-type: application/json');
//                 echo json_encode([
//                     'img' => $asset,
//                 ]);

//             } catch (Exception $e) {
//                 /*
//                  * the token was not able to be decoded.
//                  * this is likely because the signature was not able to be verified (tampered token)
//                  */
//                 header('HTTP/1.0 401 Unauthorized');
//             }
//         } else {
//             /*
//              * No token was able to be extracted from the authorization header
//              */
//             header('HTTP/1.0 400 Bad Request');
//         }
//     } else {
//         /*
//          * The request lacks the authorization token
//          */
//         header('HTTP/1.0 400 Bad Request');
//         echo 'Token not found in request';
//     }
// } else {
//     header('HTTP/1.0 405 Method Not Allowed');
// }
