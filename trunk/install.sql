CREATE TABLE baseapp (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(64), vardesc VARCHAR(256), vartype VARCHAR(32));
CREATE TABLE basecat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32));
CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(64), password VARCHAR(128), email VARCHAR(256));
CREATE TABLE profiles (user_id INT, var_id INT, val VARCHAR(256));
CREATE TABLE clubs (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), description TEXT);
CREATE TABLE admins (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, username VARCHAR(64), password VARCHAR(128), email VARCHAR(256));
CREATE TABLE supplements (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, orderId INT, varname VARCHAR(64), vardesc TEXT, vartype VARCHAR(32));
CREATE TABLE applications (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, club_id INT, submitted INT);
CREATE TABLE answers (application_id INT, var_id INT, val TEXT);
CREATE TABLE locks (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ip VARCHAR(16), time INT, action VARCHAR(16), num INT);
