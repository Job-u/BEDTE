CREATE TABLE users(
    Id int PRIMARY KEY AUTO_INCREMENT,
    Username varchar(200),
    Email varchar(200),
    Age int,
    Password varchar(200),
    Role ENUM('student', 'teacher') NOT NULL DEFAULT 'student'
);

CREATE TABLE scores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    game_mode VARCHAR(50) NOT NULL,
    difficulty VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    played_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(Id)
);

CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    game_mode VARCHAR(50) NOT NULL,
    difficulty VARCHAR(50) NOT NULL,
    question TEXT NOT NULL,
    correct_answer TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE question_options (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT NOT NULL,
    option_text TEXT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);