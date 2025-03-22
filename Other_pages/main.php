<?php
session_start();
require_once "../DataBase/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

$sql = "SELECT * FROM music";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista piosenek</title>
    <link rel="stylesheet" href="main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Judson&display=swap" rel="stylesheet">
</head>
<body>

<header>
        <input type="checkbox" id="list">
        <h1>MelodyBox</h1>
        <div class="opened_menu">
            <a class="icon_active">
                <img src="../Untitled/Home_black.png">
                <p>Home</p>
            </a>
            <a class="icon" href="add_song.php">
                <img src="../Untitled/Add song.png">
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
            <a class="icon_active">
                <img src="../Untitled/Home_black.png">
                <p>Home</p>
            </a>
            <a class="icon" href="add_song.php">
                <img src="../Untitled/Add song.png">
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
    <h2><?php echo "Welcome, ".$_SESSION['user_id']."!" ;?></h2>
    <section>
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="song">
            <div class="song_info">
                <div class="icon_name">
                    <img src="../Untitled/Music.png">
                    <div class="names">
                        <p style="color: #000"><b><?php echo htmlspecialchars($row['name']); ?></b></p>
                        <p style="color: #444"><?php echo htmlspecialchars($row['artist']); ?></p>
                    </div>
                </div>
                <div class="else">
                    <p style="color: #000;"><?php echo htmlspecialchars($row['genre']); ?></p>
                    <p style="color: #444"><?php echo htmlspecialchars($row['duration']); ?></p>
                </div>
            </div>
            <form>
                <input type="checkbox" id="Favoriting">
            </form>
        </div>
        <?php endwhile; ?>
    </section>
    <br>
</body>
</html>
