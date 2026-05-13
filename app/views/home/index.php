<?php

?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Usuário</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
<div class="logo">Portal Refeitório IPIL</div>
</header>

<div class="container">

<div class="dashboard">

<div class="box">
<h2>Pratos Disponíveis</h2>
<h1>12</h1>
</div>

<div class="box">
<h2>Cardápios</h2>
<h1>5</h1>
</div>

<div class="box">
<h2>Feedbacks</h2>
<h1>24</h1>
</div>

</div>

<div class="pratos">

<div class="prato">
<img src="imagens/prato1.jpg">
<div class="prato-info">
<h2>Frango Grelhado</h2>
<p>Arroz, feijão e salada.</p>
<textarea id="feedback" placeholder="Digite seu feedback"></textarea>
<button onclick="enviarFeedback()">Enviar Feedback</button>
</div>
</div>

<div class="prato">
<img src="imagens/prato2.jpg">
<div class="prato-info">
<h2>Massa Italiana</h2>
<p>Massa com molho especial.</p>
<textarea placeholder="Digite seu feedback"></textarea>
<button>Enviar Feedback</button>
</div>
</div>

</div>

</div>

<script src="script.js"></script>
</body>
</html>
