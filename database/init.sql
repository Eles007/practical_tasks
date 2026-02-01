CREATE TABLE IF NOT EXISTS users
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    login      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO users (login, password)
VALUES ('user',
        '$2y$10$YeyimnmFRr4uAWu1DQYtWem/T9FDwuXqGqfvI3JhizEf9nxjxqPX6');

CREATE TABLE feedback (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(255) NOT NULL,
                          topic ENUM('question', 'problem', 'proposal') NOT NULL,
                          contact ENUM('email', 'phone') NOT NULL DEFAULT 'email',
                          agree_news BOOLEAN DEFAULT FALSE,
                          agree_data BOOLEAN NOT NULL DEFAULT FALSE,
                          message TEXT NOT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);