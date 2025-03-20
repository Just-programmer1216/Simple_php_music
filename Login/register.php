<?php
require_once "../DataBase/config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Wprowadź nazwę użytkownika.";
    } else {
        $sql = "SELECT user_id FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "Ta nazwa użytkownika jest już zajęta.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Błąd zapytania.";
            }
        }
        $stmt->close();
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Wprowadź hasło.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Hasło musi mieć co najmniej 6 znaków.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Potwierdź hasło.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Hasła nie pasują do siebie.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
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
    <link rel="stylesheet" href="../Style/style.css">
</head>
    <div class="container">
        <h2>Rejestracja</h2>
        <p>Wypełnij poniższy formularz, aby utworzyć konto.</p>
            <form action="register.php" method="post">
                <label>Nazwa użytkownika:</label>
                <input type="text" name="username">
                <span><?php echo $username_err; ?></span>

                <label>Email:</label>
                <input type="email" name="email">
                
                <label>Hasło:</label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>

                <label>Potwierdź hasło:</label>
                <input type="password" name="confirm_password">
                <span><?php echo $confirm_password_err; ?></span>

                <input type="submit" value="Zarejestruj się">
            </form>
        <p>Masz już konto? <a href="../login.php">Zaloguj się tutaj</a>.</p>
    </div>
</body>
</html>