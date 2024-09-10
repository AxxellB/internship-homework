USE sports;

CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    username VARCHAR(150) NOT NULL,
    password VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE IF NOT EXISTS teams(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    city VARCHAR(150) NOT NULL
    );

CREATE TABLE IF NOT EXISTS players(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    age INT NOT NULL,
    position ENUM('striker', 'midfielder', 'defender', 'goalkeeper'),
    team_id INT,
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE IF NOT EXISTS matches(
    id INT AUTO_INCREMENT PRIMARY KEY,
    team1_id INT,
    team2_id INT,
    score1 INT,
    score2 INT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (team1_id) REFERENCES teams(id) on DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (team2_id) REFERENCES teams(id) on DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users (name, username, password)
VALUES
    ('John Doe', 'johnd', 'password123'),
    ('Jane Smith', 'janes', 'pass456'),
    ('Mike Johnson', 'mikej', 'qwerty789'),
    ('Alice Williams', 'alicew', 'alicepass'),
    ('Bob Brown', 'bobb', 'brownpass');

INSERT INTO teams (name, city)
VALUES
    ('Team A', 'New York'),
    ('Team B', 'Los Angeles'),
    ('Team C', 'Chicago'),
    ('Team D', 'Miami'),
    ('Team E', 'Dallas');

INSERT INTO players (name, age, position, team_id)
VALUES
    ('David Beckham', 35, 'midfielder', 1),
    ('Lionel Messi', 33, 'striker', 1),
    ('Cristiano Ronaldo', 36, 'striker', 2),
    ('Manuel Neuer', 34, 'goalkeeper', 3),
    ('Virgil van Dijk', 29, 'defender', 4),
    ('Sergio Ramos', 34, 'defender', 4),
    ('Gianluigi Buffon', 43, 'goalkeeper', 5);

INSERT INTO matches (team1_id, team2_id, score1, score2)
VALUES
    (1, 2, 2, 1),
    (3, 4, 1, 1),
    (5, 1, 0, 3),
    (2, 4, 2, 2),
    (3, 5, 1, 0);
