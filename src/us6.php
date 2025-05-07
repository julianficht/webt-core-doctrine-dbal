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

if (isset($_GET['delete'])) {
    $conn->delete('game_rounds', ['id' => $_GET['delete']]);
}

$rounds = $conn->fetchAllAssociative('SELECT * FROM game_rounds ORDER BY played_at ASC');

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Spielrunde rauslöschen</title>
  <style>
    .round { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 8px; display: flex; justify-content: space-between; }
    a.delete { color: red; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>

  <h1>Aufzeichnung von den Runden</h1>

  <?php foreach ($rounds as $round): ?>
    <div class="round">
      <div>
        <strong><?= htmlspecialchars($round['player_name']) ?></strong> spielte <em><?= htmlspecialchars($round['move']) ?></em><br>
        <small><?= htmlspecialchars($round['played_at']) ?></small>
      </div>
      <div>
        <a class="delete" href="?delete=<?= $round['id'] ?>" onclick="return confirm('Diesen Eintrag wirklich löschen?');">Löschen</a>
      </div>
    </div>
  <?php endforeach; ?>

</body>
</html>
