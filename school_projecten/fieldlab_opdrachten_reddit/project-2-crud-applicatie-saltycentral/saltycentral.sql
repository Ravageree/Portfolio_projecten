-- Drop the database if it exists
DROP DATABASE IF EXISTS saltycentral;

-- Create the database
CREATE DATABASE saltycentral;

-- Switch to the created database
USE saltycentral;

-- Create the users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(16) UNIQUE NOT NULL,
    token VARCHAR(128),
    password VARCHAR(32) NOT NULL
);


-- Create the threads table
CREATE TABLE threads (
    thread_id INT AUTO_INCREMENT PRIMARY KEY,
    sub ENUM('Battlefied', 'CS2', 'Cod', 'R6', 'Admin'),
    username VARCHAR(16) NOT NULL,
    title VARCHAR(100) NOT NULL,
    content VARCHAR(600) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users (username)
);

-- Create the posts table
CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    username VARCHAR(16) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users (username),
    FOREIGN KEY (thread_id) REFERENCES threads (thread_id)
);

-- Insert a sample user
INSERT INTO users (token, username, password) VALUES ('sample_token', 'axi', 'password');
INSERT INTO threads (username, title, content) 
VALUES ('axi', 'Welcome to SaltyCentral', 'this is an example message');

-- Create bug report table
CREATE TABLE bugs (
    reporter VARCHAR(50) NOT NULL,
    meaning_of_report VARCHAR(100) NOT NULL,
    bug_report VARCHAR(600) NOT NULL,
    what_happend_report VARCHAR(600)
);
