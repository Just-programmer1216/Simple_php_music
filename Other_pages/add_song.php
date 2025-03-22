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
    <link rel="stylesheet" href="add_song_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Judson&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <input type="checkbox" id="list">
        <h1>MelodyBox</h1>
        <div class="opened_menu">
            <a class="icon" href="main.php">
                <img src="../Untitled/Home.png">
                <p>Home</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/Add song_black.png">
                <p>Add song</p>
            </a>
            <a class="icon" href="favorites.php">
                <img src="../Untitled/Heart-1.png">
                <p>Favorites</p>
            </a>
            <a class="icon" href="profile.php">
                <img src="../Untitled/User.png">
                <p>Account</p>
            </a>
            <a class="icon" href="../Login/logout.php">
                <img src="../Untitled/Log out.png">
                <p>Log out</p>
            </a>
        </div>
        
        <div class="menu">
            <a class="icon" href="main.php">
                <img src="../Untitled/Home.png">
                <p>Home</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/Add song_black.png">
                <p>Add song</p>
            </a>
            <a class="icon" href="favorites.php">
                <img src="../Untitled/Heart-1.png">
                <p>Favorites</p>
            </a>
            <a class="icon" href="profile.php">
                <img src="../Untitled/User.png">
                <p>Account</p>
            </a>
            <a class="icon" href="../Login/logout.php">
                <img src="../Untitled/Log out.png">
                <p>Log out</p>
            </a>
        </div>
    </header>
    <form action="add_song.php" method="post">
        <h2>Add new song</h2>
        <div class="inputs">
            <input type="text" name="artist" placeholder="Artist">
            <span><?php echo $artist_err; ?></span>

            <input type="text" name="name" placeholder="Song name">
            <span><?php echo $name_err; ?></span>

            <input type="text" name="duration" placeholder="Duration">
            <span><?php echo $duration_err; ?></span>

            <input type="text" name="genre" placeholder="Genre">
            <span><?php echo $genre_err; ?></span>
        </div>
        <div class="send">
            <div></div>
            <input type="submit" value="Submit">
        </div>
        
    </form>
</body>
</html>
