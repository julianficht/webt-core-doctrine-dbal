<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Database;

$conn = Database::getConnection();
$rounds = $conn->fetchAllAssociative('SELECT * FROM game_rounds ORDER BY round_datetime DESC');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>RPS Tournament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>RPS Championship</h1>
            <div class="text-muted">Live Results</div>
        </div>
        <div class="col text-end">
            <a href="new_game.php" class="btn btn-primary">Add New Game</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Move</th>
                    <th>Date & Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rounds as $round): ?>
                    <tr>
                        <td><?= htmlspecialchars($round['player_name']) ?></td>
                        <td>
                            <?php
                            $symbols = [
                                'rock' => '🪨',
                                'paper' => '📄',
                                'scissors' => '✂️'
                            ];
                            echo $symbols[$round['move']] . ' ' . ucfirst($round['move']);
                            ?>
                        </td>
                        <td><?= (new DateTime($round['round_datetime']))->format('M j, Y g:i A') ?></td>
                        <td>
                            <form method="post" action="delete.php" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $round['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 