<?php
session_start();
require_once "../DataBase/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$music_id = $_POST["music_id"];
$is_checked = isset($_POST["favorite"]);

if ($is_checked) {
    $sql = "INSERT IGNORE INTO favorite_songs (user_id, music_id) VALUES (?, ?)";
} else {
    $sql = "DELETE FROM favorite_songs WHERE user_id = ? AND music_id = ?";
}

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ii", $user_id, $music_id);
    $stmt->execute();
    $stmt->close();
}

header("location: main.php");
exit;
?>
