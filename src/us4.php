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

$sql = "
    SELECT 
        r.id AS round_id,
        r.played_at,
        m.player_name,
        m.move
    FROM game_rounds r
    JOIN game_moves m ON r.id = m.round_id
    ORDER BY r.played_at ASC, m.id ASC
";

$rows = $conn->fetchAllAssociative($sql);

$groupedRounds = [];
foreach ($rows as $row) {

    $roundId = $row['round_id'];

    if (!isset($groupedRounds[$roundId])) {
        $groupedRounds[$roundId] = [
            'played_at' => $row['played_at'],
            'players' => []
        ];
    }

    $player = [
        'name' => $row['player_name'],
        'move' => $row['move']
    ];

    $groupedRounds[$roundId]['players'][] = $player;

}

function getMoveEmoji($move) {
    switch ($move) {
        case 'rock':
            return '🪨'; // Emoji für Rock
        case 'paper':
            return '📝'; // Emoji für Paper
        case 'scissors':
            return '✌'; // Emoji für Scissors
        default:
            return ''; // Falls der Zug ungültig ist
    }
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>USARPS Championship – Ergebnisse</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .round { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 8px; }
        .player { margin-bottom: 5px; }
    </style>
</head>
<body>

<h1>USARPS Championship</h1>

<?php
foreach ($groupedRounds as $round) {
    echo '<div class="round">';
    echo '<div><strong>Datum:</strong> ' . htmlspecialchars($round['played_at']) . '</div>';

    foreach ($round['players'] as $player) {
        $name = htmlspecialchars($player['name']);
        $move = htmlspecialchars(ucfirst($player['move']));
        $emoji = getMoveEmoji($player['move']);

        echo '<div class="player">';
        echo "<strong>Spieler:</strong> $name – <strong>Zug:</strong> $emoji $move";
        echo '</div>';
    }

    echo '</div>';
}
?>

</body>
</html>
