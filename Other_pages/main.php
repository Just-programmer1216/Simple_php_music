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
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
    <div class="container">
        <h2>Lista wszystkich piosenek</h2>
        
        <table>
            <tr>
                <th>Nazwa</th>
                <th>Wykonawca</th>
                <th>Gatunek</th>
                <th>Czas trwania</th>
                <th>Dodaj do ulubionych</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['artist']); ?></td>
                    <td><?php echo htmlspecialchars($row['genre']); ?></td>
                    <td><?php echo htmlspecialchars($row['duration']); ?></td>
                    <td>
                        <form action="add_favorite.php" method="post">
                            <input type="hidden" name="music_id" value="<?php echo $row['music_id']; ?>">
                            <button type="submit">❤</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="buttons">
            <a href="add_song.php" class="btn">Dodaj piosenkę</a>
            <a href="favorites.php" class="btn">Przejdź do ulubionych</a>
        </div>

        <form action="../Login/logout.php" method="post">
            <button type="submit" class="logout-btn">Wyloguj się</button>
        </form>
    </div>
</body>
</html>
