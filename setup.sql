/**
* CLEANUP
*/


CREATE DATABASE IF NOT EXISTS ds;

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'abc123';

GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost'; /* TODO: Assess privileges */

FLUSH PRIVILEGES;


CREATE TABLE IF NOT EXISTS accounts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    fullName VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin TINYINT(1) DEFAULT 0,
    active VARCHAR(255) NOT NULL,
    resetToken VARCHAR(255) DEFAULT NULL,
    resetComplete VARCHAR(3) DEFAULT 'No',
    dor TIMESTAMP /* dor = Date of Registration */
);