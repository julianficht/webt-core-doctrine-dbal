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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->insert('game_rounds', [
        'player_name' => $_POST['player_name'],
        'move' => $_POST['move'],
        'played_at' => $_POST['played_at']
    ]);
    header("location:us6.php");
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Spielzug Hinzufügen:</title>

</head>
<body>

  <h1>Neue Runde:</h1>

  <form method="post">
    <label>Spieler:
      <input type="text" name="player_name" required>
    </label>

    <label>Zug:
      <select name="move" required>
        <option value="rock">🪨 Rock</option>
        <option value="paper">📝 Paper</option>
        <option value="scissors"> ✌ Scissors</option>
      </select>
    </label>

    <label>Datum & Zeit:
      <input type="datetime-local" name="played_at" required>
    </label>

    <button type="submit">Eintragen</button>
  </form>

</body>
</html>
