<?php

require __DIR__ . "/../vendor/autoload.php";
use \Firebase\JWT\JWT;

class Auth
{
    public static function verify($token)
    {
        try {
            $env = json_decode(file_get_contents(__DIR__ . "/../api/v3/.env.json"), true);
            preg_match_all("/[\S]+/", $token, $matches);
            $token = $matches[0][1];
            return JWT::decode($token, $env["jwt"]["key"], array('HS256'));
        } catch (Firebase\JWT\UnexpectedValueException $e) {
            echo Errors::JWT($e);
            exit;
        } catch (Firebase\JWT\SignatureInvalidException $e) {
            echo Errors::JWT($e);
            exit;
        } catch (Firebase\JWT\BeforeValidException $e) {
            echo Errors::JWT($e);
            exit;
        } catch (Firebase\JWT\ExpiredException $e) {
            echo Errors::JWT($e);
            exit;
        } catch (Firebase\JWT\DomainException $e) {
            echo Errors::JWT($e);
            exit;
        }
    }
}
