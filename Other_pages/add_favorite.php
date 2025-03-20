<?php
session_start();
require_once "../DataBase/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["music_id"])) {
    $user_id = $_SESSION["user_id"];
    $music_id = $_POST["music_id"];
    $sql = "INSERT IGNORE INTO favorite_songs (user_id, music_id) VALUES (?, ?)";
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ii", $user_id, $music_id);
        $stmt->execute();
        $stmt->close();
    }
}

header("location: main.php");
exit;
?>
