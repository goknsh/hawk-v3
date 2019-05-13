<?php

class Errors
{
    public static function PDOException($e)
    {
        http_response_code(500);
        return json_encode(array(
            "ok" => false,
            "response" => "serverError",
            "error" => array(
                "type" => "database",
                "message" => $e->getMessage(),
                "code" => $e->getCode(),
            ),
            "trace" => array(
                "file" => $e->getFile(),
                "line" => $e->getLine(),
            ),
        ));
    }
    public static function unsendableEmail($email)
    {
        http_response_code(500);
        return json_encode(array(
            "ok" => false,
            "response" => "serverError",
            "error" => array(
                "type" => "emailError",
                "message" => "We could not send an email to {$email}",
            ),
        ));
    }
    public static function emailVerified()
    {
        return json_encode(array(
            "ok" => false,
            "response" => "clientError",
            "error" => array(
                "type" => "emailError",
                "message" => "Your account has already been verified",
            ),
        ));
    }
    public static function incorrectHash()
    {
        return json_encode(array(
            "ok" => false,
            "response" => "clientError",
            "error" => array(
                "type" => "emailError",
                "message" => "The given hash does not match the required hash",
            ),
        ));
    }
    public static function incompleteHeaders($required, $optional)
    {
        http_response_code(400);
        return json_encode(array(
            "ok" => false,
            "response" => "clientError",
            "error" => array(
                "type" => "incompleteHeaders",
                "message" => "The required headers are not present",
                "headers" => array(
                    "required" => $required,
                    "optional" => $optional,
                ),
            ),
        ));
    }
    public static function incompleteParams($required, $optional)
    {
        http_response_code(400);
        return json_encode(array(
            "ok" => false,
            "response" => "clientError",
            "error" => array(
                "type" => "incompleteParams",
                "message" => "The required params are not present",
                "params" => array(
                    "required" => $required,
                    "optional" => $optional,
                ),
            ),
        ));
    }
    public static function requestMethod($accepted, $method)
    {
        http_response_code(405);
        return json_encode(array(
            "ok" => false,
            "response" => "clientError",
            "error" => array(
                "type" => "requestMethod",
                "message" => "The {$method} method is an invalid method of accessing this page",
                "acceptedMethods" => $accepted,
            ),
        ));
    }
    public static function JWT($e)
    {
        http_response_code(401);
        return json_encode(array(
            "ok" => false,
            "response" => "userError",
            "error" => array(
                "type" => "tokenError",
                "message" => $e->getMessage(),
                "code" => $e->getCode(),
            ),
            "trace" => array(
                "file" => $e->getFile(),
                "line" => $e->getLine(),
            ),
        ));
    }
    public static function userExists($email)
    {
        http_response_code(401);
        return json_encode(array(
            "ok" => false,
            "response" => "userError",
            "error" => array(
                "type" => "userExists",
                "message" => "The user with an email of {$email} exists",
            ),
        ));
    }
    public static function unverifiedEmail()
    {
        http_response_code(401);
        return json_encode(array(
            "ok" => false,
            "response" => "userError",
            "error" => array(
                "type" => "unverifiedEmail",
                "message" => "This account's email address has not been verified",
            ),
        ));
    }
    public static function incorrectPassword()
    {
        http_response_code(401);
        return json_encode(array(
            "ok" => false,
            "response" => "userError",
            "error" => array(
                "type" => "incorrectPassword",
                "message" => "The given password is incorrect",
            ),
        ));
    }
}
