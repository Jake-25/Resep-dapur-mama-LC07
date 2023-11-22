CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    session_id VARCHAR(255),
    UNIQUE KEY unique_username (username),
    UNIQUE KEY unique_email (email)
);
