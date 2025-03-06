<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PHPMailer Classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer Library Files
require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    try {
        $mail = new PHPMailer(true);
        
        // 0 when not debugging
        $mail->SMTPDebug = 0; 

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'memorium478844@gmail.com';
        $mail->Password = 'yntp szof pwob kpml';  //App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Prevent SSL verification issues
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Sanitize & Validate Inputs
        $sender_name = htmlspecialchars(trim($_POST['name']));
        $recipient_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = nl2br(htmlspecialchars(trim($_POST['message'])));

        if (!filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid Email Address!");
        }

        // Email Configuration
        $mail->setFrom('memorium478844@gmail.com', 'Memorium');
        $mail->addAddress($recipient_email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<p><strong>Sender Name:</strong> {$sender_name}</p><p><strong>Message:</strong>{$message}</p>";

        // Send Email & Handle Response
        if ($mail->send()) {
            echo '<script>
                    alert("Email Sent Successfully!");
                    window.location.href = document.referrer;
                  </script>';
        } else {
            throw new Exception("Mail Sending Failed: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        echo '<script>
                alert("Error: ' . addslashes($e->getMessage()) . '");
                window.location.href = document.referrer;
              </script>';
    }
}
?>

