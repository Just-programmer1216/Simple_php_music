<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Judson&display=swap" rel="stylesheet">

      
    <title>Login</title>
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
            <a class="icon" href="favorites.php">
                <img src="../Untitled/Heart-1.png">
                <p>Favorites</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/User_black.png">
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
            <a class="icon" href="favorites.php">
                <img src="../Untitled/Heart-1.png">
                <p>Favorites</p>
            </a>
            <a class="icon_active">
                <img src="../Untitled/User_black.png">
                <p>Account</p>
            </a>
            <a class="icon" href="../Login/logout.php">
                <img src="../Untitled/Log out.png">
                <p>Log out</p>
            </a>
        </div>
    </header>
    <form>
        <h2>Personal info</h2>
        <div class="inputs">
            <div class="block">
                <label>Name</label>
                <input type="text" name="name" readonly>
            </div>
            <div class="block">
                <label>E-mail</label>
                <input type="text" name="mail" readonly>
            </div>
        </div>
        
    </form>
</body>
</html>