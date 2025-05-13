<?php

require_once '../vendor/autoload.php';

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
        'played_at' => $_POST['played_at']
    ]);
    $roundId = $conn->lastInsertId();

    $conn->insert('game_moves', [
        'round_id' => $roundId,
        'player_name' => $_POST['player1_name'],
        'move' => $_POST['player1_move']
    ]);
    $conn->insert('game_moves', [
        'round_id' => $roundId,
        'player_name' => $_POST['player2_name'],
        'move' => $_POST['player2_move']
    ]);

    header("Location: us4.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Neue Runde erfassen</title>
</head>
<body>

<h1>Neue Spielrunde eintragen</h1>

<form method="post">
    <fieldset>
        <legend>Spieler 1</legend>
        <label>Name:
            <input type="text" name="player1_name" required>
        </label><br>
        <label>Zug:
            <select name="player1_move" required>
                <option value="rock">🪨 Rock</option>
                <option value="paper">📝 Paper</option>
                <option value="scissors">✌ Scissors</option>
            </select>
        </label>
    </fieldset>

    <fieldset>
        <legend>Spieler 2</legend>
        <label>Name:
            <input type="text" name="player2_name" required>
        </label><br>
        <label>Zug:
            <select name="player2_move" required>
                <option value="rock">🪨 Rock</option>
                <option value="paper">📝 Paper</option>
                <option value="scissors">✌ Scissors</option>
            </select>
        </label>
    </fieldset>

    <label>Datum & Zeit der Runde:
        <input type="datetime-local" name="played_at" required>
    </label><br><br>

    <button type="submit">Runde speichern</button>
</form>

</body>
</html>
