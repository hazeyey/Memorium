<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Classes for Email Handling
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer Library Files
require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {
    try {
        $mail = new PHPMailer(true);

        // SMTP Debugging (0 = off, 1 = client messages, 2 = client and server messages)
        $mail->SMTPDebug = 0;
        
        // SMTP Settings
        $mail->isSMTP();      
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'memorium478844@gmail.com'; 
        $mail->Password = 'bxjk hqhs ormw rewq';  // Consider using an App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;
        
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Email Configuration
        $mail->setFrom('memorium478844@gmail.com', 'Memorium');
        $mail->addAddress($_POST['email']); 
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body = $_POST['message'];

        // Send Email
        if ($mail->send()) {
            echo '<script>
                    alert("Sent Successfully");
                    window.history.back(); // Stay on the same page
                  </script>';
        } else {
            echo '<script>
                    alert("Mail not sent: ' . $mail->ErrorInfo . '");
                    window.history.back(); // Stay on the same page
                  </script>';
        }
    } catch (Exception $e) {
        echo '<script>
                alert("Error: ' . $e->getMessage() . '");
                window.history.back();
              </script>';
    }
}
?>