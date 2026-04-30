-- SQL Script to set up the Inventory Database
-- Create the database
CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

-- Create the items table
CREATE TABLE IF NOT EXISTS items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    quantity INT(11) NOT NULL,
    status VARCHAR(50) NOT NULL
);

-- Insert dummy data for immediate testing
INSERT INTO items (item_name, quantity, status) VALUES ('ThinkPad T480', 5, 'Available');
