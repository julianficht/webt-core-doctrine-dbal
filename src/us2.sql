CREATE TABLE game_rounds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(255) NOT NULL,
    move ENUM('rock', 'paper', 'scissors') NOT NULL,
    played_at DATETIME NOT NULL
);
