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
    $roundId = $_GET['delete'];
    // Zuerst Züge löschen
    $conn->delete('game_moves', ['round_id' => $roundId]);
    // Dann die Runde löschen
    $conn->delete('game_rounds', ['id' => $roundId]);
}

// Alle Runden + Spielerzüge laden
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

// Runden gruppieren
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

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Runden löschen</title>
    <style>
        .round { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 8px; }
        .delete { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<h1>Spielrunden verwalten</h1>

<?php foreach ($groupedRounds as $id => $round): ?>
    <div class="round">
        <div><strong>Datum:</strong> <?= htmlspecialchars($round['played_at']) ?></div>
        <?php foreach ($round['players'] as $player): ?>
            <div><?= htmlspecialchars($player['name']) ?> – <?= htmlspecialchars($player['move']) ?></div>
        <?php endforeach; ?>
        <a class="delete" href="?delete=<?= $id ?>" onclick="return confirm('Runde wirklich löschen?');">🗑️ Löschen</a>
    </div>
<?php endforeach; ?>

</body>
</html>
