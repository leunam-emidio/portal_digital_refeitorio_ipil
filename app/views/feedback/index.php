<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>feedback</title>
    <link rel="stylesheet" href="../../../public/css/feedback.css">
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
        <h1>Feedback</h1>

        <?php #if(empty($feedback)): ?>
        <p>There is not feedback</p>
       <?php #endif; ?>

       <?php #foreach($feedback as $item): ?>
       <div>
        <?php #echo $item['body']; ?>
        <p class="name">By <?php #echo $item['name']; ?> on <?php #echo $item['date'];?></p>
       </div>
       <?php #endforeach; ?>
    </main>
    <footer class="footer">
        Copyright &copy; 2022
    </footer>

</body>
</html>