<?php

require_once 'C:\xampp\htdocs\Folkswagen\webt-core-doctrine-dbal\vendor\autoload.php';

use Doctrine\DBAL\DriverManager;

$connectionParams = [
    'dbname' => 'usarps',
    'user' => 'root',
    'password' => '',
    'host' => '127.0.0.1',
    'driver' => 'pdo_mysql',
];
$conn = DriverManager::getConnection($connectionParams);

$rounds = $conn->fetchAllAssociative('SELECT * FROM game_rounds ORDER BY played_at ASC');

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>USARPS Championship – die Ergebnise</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    .round { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 8px; }
  </style>
</head>
<body>

  <h1>USARPS Championship – 7. Mai 2025</h1>

  <?php foreach ($rounds as $round): ?>
    <div class="round">
      <strong>Spieler:</strong> <?= htmlspecialchars($round['player_name']) ?><br>
      <strong>Zug:</strong> <?= htmlspecialchars($round['move']) ?><br>
      <strong>Datum:</strong> <?= htmlspecialchars($round['played_at']) ?>
    </div>
  <?php endforeach; ?>

</body>
</html>
