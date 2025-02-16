CREATE DATABASE employee_auth;
USE employee_auth;

-- Employees Table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Admins Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Password Reset Table
CREATE TABLE password_reset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp VARCHAR(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (email) REFERENCES employees(email) ON DELETE CASCADE
);

-- Insert an Admin (Replace 'admin123' with a secure password)
INSERT INTO admins (username, email, password) 
VALUES ('admin', 'admin@example.com', 'admin123');
