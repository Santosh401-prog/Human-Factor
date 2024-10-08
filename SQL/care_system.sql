-- Create the database
CREATE DATABASE IF NOT EXISTS care_system;

-- Use the database
USE care_system;

-- Create the table to store patient demographic details
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    height INT NOT NULL,
    weight INT NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL
);

-- Create the table to store patient goals
CREATE TABLE IF NOT EXISTS patient_goals (
    patient_id INT PRIMARY KEY,
    exerciseGoal INT,
    sleepGoal INT,
    eatingGoal ENUM('healthy', 'balanced', 'unhealthy'),
    journalGoal INT,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

-- Create the table to store scheduled appointments
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);
