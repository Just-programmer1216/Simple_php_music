<?php
session_start();
require_once "DataBase/config.php";

$username_email = $password = "";
$username_email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username_email"]))) {
        $username_email_err = "Wprowadź nazwę użytkownika lub e-mail!";
    } else {
        $username_email = trim($_POST["username_email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Wprowadź hasło!";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_email_err) && empty($password_err)) {
        $sql = "SELECT user_id, username, password FROM users WHERE username = ? OR email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $param_username_email, $param_username_email);
            $param_username_email = $username_email;

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($user_id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;
                            header("location: Other_pages/main.php");
                            exit;
                        } else {
                            $password_err = "Nieprawidłowe hasło!";
                        }
                    }
                } else {
                    $username_email_err = "Nie znaleziono użytkownika!";
                }
            } else {
                echo "Błąd logowania!";
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
    <link rel="stylesheet" type="text/css" href="login_style.css">
    <title>Logowanie</title>
    <link rel="stylesheet" href="login_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Judson&display=swap" rel="stylesheet">
</head>
<body>
    <h1>MelodyBox</h1>
    <form action="login.php" method="post">
        <div>
            <h2>Log in</h2>
        </div>
        <label>Username or e-mail:</label>
        <input type="text" name="username_email">
        <span><?php echo $username_email_err; ?></span>

        <label>Password:</label>
        <input type="password" name="password">
        <span><?php echo $password_err; ?></span>

        <input type="submit" value="Log in"></input>
        <p>Haven't an account? <a href="Login/register.php">Sign up</a>.</p>
    </form>

</body>
</html>