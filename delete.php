<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $conn = Database::getConnection();
        
        $conn->delete('game_rounds', ['id' => $_POST['id']]);
        
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit;
} 