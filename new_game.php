<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Database;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = Database::getConnection();
        
        $conn->insert('game_rounds', [
            'player_name' => $_POST['player_name'],
            'move' => $_POST['move'],
            'round_datetime' => (new DateTime())->format('Y-m-d H:i:s')
        ]);

        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>New Game Round - RPS Tournament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Add New Game Round</h1>
        </div>
        <div class="col text-end">
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="player_name" class="form-label">Player Name</label>
                    <input type="text" class="form-control" id="player_name" name="player_name" required>
                </div>

                <div class="mb-3">
                    <label for="move" class="form-label">Move</label>
                    <select class="form-select" id="move" name="move" required>
                        <option value="">Select a move...</option>
                        <option value="rock">Rock 🪨</option>
                        <option value="paper">Paper 📄</option>
                        <option value="scissors">Scissors ✂️</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Game Round</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 