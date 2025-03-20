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
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
    <div class="container">
        <h2>Twoje ulubione piosenki</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Nazwa</th>
                    <th>Wykonawca</th>
                    <th>Gatunek</th>
                    <th>Czas trwania</th>
                    <th>Usuń</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['artist']); ?></td>
                        <td><?php echo htmlspecialchars($row['genre']); ?></td>
                        <td><?php echo htmlspecialchars($row['duration']); ?></td>
                        <td>
                            <form action="remove_favorite.php" method="post">
                                <input type="hidden" name="music_id" value="<?php echo $row['music_id']; ?>">
                                <button type="submit">❌</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nie masz jeszcze ulubionych piosenek.</p>
        <?php endif; ?>

        <a href="main.php" class="btn">Powrót do listy piosenek</a>
    </div>
</body>
</html>
