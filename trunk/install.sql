CREATE TABLE baseapp (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(256), vardesc VARCHAR(256), vartype VARCHAR(256));
CREATE TABLE basecat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32));
CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(64), password VARCHAR(128), email VARCHAR(256));
CREATE TABLE reset (user_id INT PRIMARY KEY, time INT, auth VARCHAR(64));
CREATE TABLE profiles (user_id INT, var_id INT, val VARCHAR(256));
CREATE TABLE clubs (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), description TEXT, view_time INT, open_time INT, close_time INT, num_recommend INT);
CREATE TABLE admins (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, username VARCHAR(64), password VARCHAR(128), email VARCHAR(256));
CREATE TABLE supplements (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, orderId INT, varname VARCHAR(256), vardesc TEXT, vartype VARCHAR(256));
CREATE TABLE applications (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, club_id INT, submitted VARCHAR(512));
CREATE TABLE answers (id INT PRIMARY KEY AUTO_INCREMENT, application_id INT, var_id INT, val TEXT);
CREATE TABLE recommendations (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, author VARCHAR(64), email VARCHAR(256), auth VARCHAR(64), status INT, filename VARCHAR(32));
CREATE TABLE recommender_answers (id INT PRIMARY KEY AUTO_INCREMENT, recommend_id INT, var_id INT, val TEXT);
CREATE TABLE pages (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), text TEXT);
CREATE TABLE locks (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ip VARCHAR(16), time INT, action VARCHAR(16), num INT);
