/**
* CLEANUP
*/


CREATE DATABASE IF NOT EXISTS ds;

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'abc123';

GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost'; /* TODO: Assess privileges */

FLUSH PRIVILEGES;