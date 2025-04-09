USE rps_game_dev;

-- Clear existing data
TRUNCATE TABLE game_rounds;

-- Insert test data
INSERT INTO game_rounds (player_name, move, round_datetime) VALUES
    ('Alice', 'rock', '2024-04-09 10:05:00'),
    ('Bob', 'paper', '2024-04-09 10:07:00'),
    ('Charlie', 'scissors', '2024-04-09 10:10:00'),
    ('Dana', 'paper', '2024-04-09 10:12:00'),
    ('Evan', 'rock', '2024-04-09 10:15:00'); 