CREATE TABLE game_rounds (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             played_at DATETIME NOT NULL
);

CREATE TABLE game_moves (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            round_id INT NOT NULL,
                            player_name VARCHAR(255) NOT NULL,
                            move ENUM('rock', 'paper', 'scissors') NOT NULL,
                            FOREIGN KEY (round_id) REFERENCES game_rounds(id) ON DELETE CASCADE
);
