<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>feedback</title>
    <link rel="stylesheet" href="../../../public/css/indexfeedback.css">
</head>
<body>
    <header class="header">
        <h1 class="logo">Refeitório IPIL</h1> 
        <nav class="navbar">
            <ul class="menu">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./create.php">Feedback</a></li>
            </ul>
        </nav>
    </header>
    <main class="main">
        <form action="" method="POST"   class="form">
            <div><img src="imgs/mascote.png" alt=""></div>
            <h1>Feedback</h1>
            <legend>Leave feedback for Refeitório IPIL</legend>
            <div>
                <label for="ifeedback">Feedback</label>
                <textarea name="body" id="ifeedback" placeholder="Enter your  feedback" required auto></textarea>
            </div>
            <input class="btn-submit" type="submit" name="submit" value="Send">
        </form>
    </main>
    <footer class="footer">
        Copyright &copy; 2022
    </footer>

</body>
</html>
