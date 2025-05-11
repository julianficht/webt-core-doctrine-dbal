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

// 🧮 Gruppieren nach Runden
$groupedRounds = [];
foreach ($rows as $row) {
    $id = $row['round_id'];
    if (!isset($groupedRounds[$id])) {
        $groupedRounds[$id] = [
            'played_at' => $row['played_at'],
            'players' => []
        ];
    }
    $groupedRounds[$id]['players'][] = [
        'name' => $row['player_name'],
        'move' => $row['move']
    ];
}

// 🎨 Emojis anzeigen
function getMoveEmoji(string $move): string {
    return match ($move) {
        'rock' => '🪨 Rock',
        'paper' => '📝 Paper',
        'scissors' => '✌ Scissors',
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

<?php foreach ($groupedRounds as $id => $round): ?>
    <div class="round">
        <div><strong>Datum:</strong> <?= htmlspecialchars($round['played_at']) ?></div>
        <?php foreach ($round['players'] as $player): ?>
            <div class="player">
                <strong>Spieler:</strong> <?= htmlspecialchars($player['name']) ?> – <?= getMoveEmoji($player['move']) ?>
            </div>
        <?php endforeach; ?>
        <br>
        <a class="delete" href="?delete=<?= $id ?>" onclick="return confirm('Runde wirklich löschen?');">🗑️ Löschen</a>
    </div>
<?php endforeach; ?>

</body>
</html>
