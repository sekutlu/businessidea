-- Business Idea Platform Database Setup
-- Run this file to create all tables

CREATE DATABASE IF NOT EXISTS businessidea;
USE businessidea;

-- Drop tables if they exist (for clean install)
DROP TABLE IF EXISTS milestones;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS activity_log;
DROP TABLE IF EXISTS media;
DROP TABLE IF EXISTS collaborators;
DROP TABLE IF EXISTS ideas;
DROP TABLE IF EXISTS users;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('entrepreneur', 'mentor', 'investor') DEFAULT 'entrepreneur',
    credibility_points INT DEFAULT 0,
    subscription_type ENUM('free', 'monthly', 'quarterly', 'annual') DEFAULT 'free',
    subscription_expires DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Ideas table
CREATE TABLE ideas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    industry ENUM('technology', 'agriculture', 'services', 'retail', 'healthcare', 'education', 'other') NOT NULL,
    description TEXT,
    problem_statement TEXT,
    solution TEXT,
    target_market TEXT,
    revenue_model TEXT,
    competitive_advantage TEXT,
    execution_plan TEXT,
    verification_score INT DEFAULT 0,
    progress_percentage INT DEFAULT 0,
    status ENUM('concept', 'validation', 'planning', 'execution', 'completed') DEFAULT 'concept',
    is_reverse_mode BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Collaborators table
CREATE TABLE collaborators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idea_id INT NOT NULL,
    user_id INT NOT NULL,
    role ENUM('owner', 'collaborator', 'mentor', 'investor') DEFAULT 'collaborator',
    permissions ENUM('view', 'edit', 'admin') DEFAULT 'view',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idea_id) REFERENCES ideas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_collaboration (idea_id, user_id)
);

-- Media table
CREATE TABLE media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idea_id INT NOT NULL,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type ENUM('image', 'video', 'document') NOT NULL,
    file_size INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idea_id) REFERENCES ideas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activity log table
CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    idea_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (idea_id) REFERENCES ideas(id) ON DELETE CASCADE
);

-- Comments table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idea_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idea_id) REFERENCES ideas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Milestones table
CREATE TABLE milestones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idea_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    is_completed BOOLEAN DEFAULT FALSE,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idea_id) REFERENCES ideas(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (name, email, password, role, credibility_points) 
VALUES ('Admin User', 'admin@ideatehub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'entrepreneur', 100);
