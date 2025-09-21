CREATE TABLE users(
    Id int PRIMARY KEY AUTO_INCREMENT,
    Username varchar(200),
    Email varchar(200),
    Age int,
    Password varchar(200)
);

-- Stores each quiz attempt per user
CREATE TABLE IF NOT EXISTS scores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    game_mode VARCHAR(50) NOT NULL,
    difficulty VARCHAR(10) NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_scores_user
        FOREIGN KEY (user_id) REFERENCES users(Id)
        ON DELETE CASCADE
);