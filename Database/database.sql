CREATE TABLE users (
    id VARCHAR(255) primary key NOT NULL CHECK (`id` regexp '^CU[0-9][0-9][0-9]$') ,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    session_id VARCHAR(255),
    UNIQUE KEY unique_username (username),
    UNIQUE KEY unique_email (email)
);