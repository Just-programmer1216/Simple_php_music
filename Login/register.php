<?php
require_once "../DataBase/config.php";

$email = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Wprowadź nazwę użytkownika!";
    } else {
        $sql = "SELECT user_id FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "Ta nazwa użytkownika jest już zajęta!";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Błąd zapytania.";
            }
        }
        $stmt->close();
    }

    
    if (empty(trim($_POST["email"]))) {
        $email_err = "Wprowadź adres e-mail.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Nieprawidłowy adres e-mail.";
        } else {
            $sql = "SELECT user_id FROM users WHERE email = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $param_email);
                $param_email = $email;
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $email_err = "Ten adres e-mail jest już używany.";
                    }
                } else {
                    echo "Błąd zapytania do bazy danych (email).";
                }
                $stmt->close();
            }
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Wprowadź hasło!";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Hasło musi mieć co najmniej 6 znaków!";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Potwierdź hasło!";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Hasła nie pasują do siebie!";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_password, $param_email);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
                header("location: ../login.php");
            } else {
                echo "Błąd rejestracji.";
            }
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="register_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Judson&display=swap" rel="stylesheet">
</head>
<body>
    <h1>MelodyBox</h1>
    <form action="register.php" method="post">
        <div>
            <h2>Registration</h2>
        </div>
        <label>Username:</label>
        <input type="text" name="username">
        <span><?php echo $username_err; ?></span>

        <label>Email:</label>
        <input type="email" name="email">
        <span><?php echo $email_err; ?></span>
                
        <label>Password:</label>
        <input type="password" name="password">
        <span><?php echo $password_err; ?></span>

        <label>Confirm password:</label>
        <input type="password" name="confirm_password">
        <span><?php echo $confirm_password_err; ?></span>

        <input type="submit" value="Sign up">
        <p>Already registered? <a href="../login.php">Log in</a>.</p>
    </form>
        
    </div>
</body>
</html>