<?php
session_start();
require_once "../DataBase/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

$name = $artist = $genre = $duration = "";
$name_err = $artist_err = $genre_err = $duration_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "Wprowadź nazwę piosenki.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["artist"]))) {
        $artist_err = "Wprowadź wykonawcę.";
    } else {
        $artist = trim($_POST["artist"]);
    }

    if (empty(trim($_POST["genre"]))) {
        $genre_err = "Wprowadź gatunek.";
    } else {
        $genre = trim($_POST["genre"]);
    }

    if (empty(trim($_POST["duration"]))) {
        $duration_err = "Wprowadź czas trwania (format HH:MM:SS).";
    } else {
        $duration = trim($_POST["duration"]);
    }

    if (empty($name_err) && empty($artist_err) && empty($genre_err) && empty($duration_err)) {
        $sql = "INSERT INTO music (name, artist, genre, duration) VALUES (?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $name, $artist, $genre, $duration);
            if ($stmt->execute()) {
                header("location: main.php");
                exit;
            } else {
                echo "Błąd dodawania piosenki.";
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
    <title>Dodaj piosenkę</title>
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
    <div class="container">
        <h2>Dodaj nową piosenkę</h2>
        <form action="add_song.php" method="post">
            <label>Nazwa:</label>
            <input type="text" name="name" required>
            <span><?php echo $name_err; ?></span>

            <label>Wykonawca:</label>
            <input type="text" name="artist" required>
            <span><?php echo $artist_err; ?></span>

            <label>Gatunek:</label>
            <input type="text" name="genre" required>
            <span><?php echo $genre_err; ?></span>

            <label>Czas trwania (HH:MM:SS):</label>
            <input type="text" name="duration" required>
            <span><?php echo $duration_err; ?></span>

            <button type="submit">Dodaj piosenkę</button>
        </form>
        <a href="main.php" class="btn">Powrót do listy piosenek</a>
    </div>
</body>
</html>
