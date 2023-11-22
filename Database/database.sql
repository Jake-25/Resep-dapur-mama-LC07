CREATE TABLE users (
    id VARCHAR(255) primary key NOT NULL CHECK (`id` regexp '^CU[0-9][0-9][0-9]$') ,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    session_id VARCHAR(255),
    UNIQUE KEY unique_username (username),
    UNIQUE KEY unique_email (email)
);


USE resep_dapur_mama;

CREATE TABLE IF NOT EXISTS resep (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    daerah_asal VARCHAR(100) NOT NULL,
    rasa VARCHAR(100) NOT NULL,
    halal BOOLEAN NOT NULL,
    vegetarian BOOLEAN NOT NULL
);