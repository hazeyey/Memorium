<?php
session_start();
include 'db/admin-db-connect.php'; 

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM adminlogin WHERE username = ? AND role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
       
        if ($password == $row['password']) { 
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_logged_in'] = true;

            header("Location: admin.php"); 
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Unauthorized access. Admins only.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-login-style.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="login-container">
        <div class="box form-box">
            <h2>Admin Login</h2>
            <?php if (!empty($error_message)) : ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter admin username" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="field">
                    <button type="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
