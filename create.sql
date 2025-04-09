-- Create the database (optional, depending on environment)
CREATE
DATABASE IF NOT EXISTS rps_game_dev;

-- Use the database
USE
rps_game_dev;

-- Drop the table if it already exists to allow for easy re-runs during dev
DROP TABLE IF EXISTS game_rounds;

-- Create the game_rounds table
CREATE TABLE game_rounds
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    player_name    VARCHAR(100) NOT NULL,
    move           ENUM('rock', 'paper', 'scissors') NOT NULL,
    round_datetime DATETIME     NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
