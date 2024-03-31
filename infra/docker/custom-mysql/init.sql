CREATE DATABASE IF NOT EXISTS paravos;

CREATE USER 'paravosapp'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON paravos.* TO 'paravosapp'@'localhost';
FLUSH PRIVILEGES;

