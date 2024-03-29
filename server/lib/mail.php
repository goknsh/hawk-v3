<?php

require __DIR__ . "/../vendor/autoload.php";
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public static function verifyUser($to, $name, $hash)
    {
        $env = json_decode(file_get_contents(__DIR__ . "/../api/v3/.env.json"), true);
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = "mail.atanos.ga"; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = "_mainaccount@atanos.ga"; // SMTP username
            $mail->Password = "?#eCRPbK3I7f"; // SMTP password
            $mail->SMTPSecure = "ssl"; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465; // TCP port to connect to

            //Recipients
            $mail->setFrom("bot@hawk.atanos.ga", "Hawk Bot");
            $mail->addAddress($to, $name); // Add a recipient
            $mail->addReplyTo("support@hawk.atanos.ga", "Hawk Support");

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = "Verify your email for Hawk";
            $mail->Body = "
			<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml'>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
				<title>Verify your email for Hawk</title>
				<meta name='viewport' content='width=device-width, initial-scale=1.0' />
			</head>
			<body>
				<p>Hey {$name},<br>
				Thanks for signing up for an account with <a href='{$env["server"]["client"]}'>Hawk</a>. Please click the link below to verify your email.<br>
				<a href='{$env["server"]["client"]}/api/v3/user/verify?email={$to}&hash={$hash}'>Verify Email</a></p>
				<p>If you cannot click the link below, use the URL below to verify your email.<br>
				<a href='{$env["server"]["client"]}/api/v3/user/verify?email={$to}&hash={$hash}'>{$env["server"]["client"]}/api/v3/user/verify?email={$to}&hash={$hash}</a></p>
				<p>Thank you,<br>
				Hawk Development Team</p>
			</body>
			</html>
			";
            $mail->AltBody = "Hey {$name},
			Thanks for signing up for an account with Hawk. Please use this link below to verify your email: {$env["server"]["client"]}/api/v3/user/verify?email={$to}&hash={$hash}

			Thank you,
			Hawk Development Team";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // var_dump($e);
            // return $mail->ErrorInfo;
        }
    }
}
