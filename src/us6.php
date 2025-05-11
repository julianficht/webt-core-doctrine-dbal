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

// 🔁 Runde löschen
if (isset($_GET['delete'])) {
    $roundId = $_GET['delete'];
    $conn->delete('game_moves', ['round_id' => $roundId]);
    $conn->delete('game_rounds', ['id' => $roundId]);
}

// 📥 Daten abrufen
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

function getMoveEmoji(string $move): string {
    return match ($move) {
        'rock' => '🪨',
        'paper' => '📝',
        'scissors' => '✌',
        default => htmlspecialchars($move)
    };
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spielrunden verwalten</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .round {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .player {
            margin-left: 15px;
        }
        .delete {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Alle Spielrunden</h1>

<?php
// Durchlauf aller Runden
foreach ($groupedRounds as $roundId => $round) {
    echo '<div class="round">';
    echo '<div><strong>Datum:</strong> ' . htmlspecialchars($round['played_at']) . '</div>';

    // Durchlauf der Spieler in dieser Runde
    foreach ($round['players'] as $player) {
        $name = htmlspecialchars($player['name']);
        $move = htmlspecialchars(ucfirst($player['move']));
        $emoji = getMoveEmoji($player['move']);

        echo '<div class="player">';
        echo "<strong>Spieler:</strong> $name – <strong>Zug:</strong> $emoji $move";
        echo '</div>';
    }

    // Löschen-Link für die Runde
    echo '<br>';
    echo '<a class="delete" href="?delete=' . $roundId . '" onclick="return confirm(\'Runde wirklich löschen?\');"> Eintrag Löschen</a>';

    echo '</div>';
}
?>

}
</body>
</html>
