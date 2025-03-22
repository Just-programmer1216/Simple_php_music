<?php
session_start();
require_once "../DataBase/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT music.music_id, music.name, music.artist, music.genre, music.duration 
        FROM favorite_songs 
        JOIN music ON favorite_songs.music_id = music.music_id 
        WHERE favorite_songs.user_id = ?";
        
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulubione piosenki</title>
    <link rel="stylesheet" href="favorites_style.css">
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
            <a class="icon" href="add_song.php">
                <img src="../Untitled/Add song.png">
                <p>Add song</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/Heart_black.png">
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
            <a class="icon" href="add_song.php">
                <img src="../Untitled/Add song.png">
                <p>Add song</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/Heart_black.png">
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
<h2>Your favorite songs</h2>
<section>
    <?php if ($result->num_rows > 0): ?>
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
            <form action="remove_favorite.php" method="post">
                <input type="hidden" name="music_id" value="<?php echo htmlspecialchars($row['music_id']); ?>">
                <input type="checkbox" id="Deleting" onchange="this.form.submit()">
            </form>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nie masz jeszcze ulubionych piosenek.</p>
    <?php endif; ?>
    </section>
    <br>
</body>
</html>
