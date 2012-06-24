CREATE TABLE IF NOT EXISTS baseapp (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(1024), vardesc VARCHAR(1024), vartype VARCHAR(1024));
CREATE TABLE IF NOT EXISTS basecat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), orderId INT);

CREATE TABLE IF NOT EXISTS custom (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(1024), vardesc VARCHAR(1024), vartype VARCHAR(1024));
CREATE TABLE IF NOT EXISTS custom_instance (id INT PRIMARY KEY AUTO_INCREMENT, category INT, user_id INT, status TEXT);
CREATE TABLE IF NOT EXISTS custom_response (id INT PRIMARY KEY AUTO_INCREMENT, instance_id INT, var_id INT, val TEXT);
CREATE TABLE IF NOT EXISTS custom_cat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32));
CREATE TABLE IF NOT EXISTS user_custom (user_id INT, category INT);

CREATE TABLE IF NOT EXISTS users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(64), password VARCHAR(128), salt VARCHAR(40), name VARCHAR(128), email VARCHAR(256), register_time INT, accessed INT);
CREATE TABLE IF NOT EXISTS profiles (user_id INT, var_id INT, val VARCHAR(256));
CREATE TABLE IF NOT EXISTS reset (user_id INT PRIMARY KEY, time INT, auth VARCHAR(64));

CREATE TABLE IF NOT EXISTS clubs (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), description TEXT, view_time INT, open_time INT, close_time INT, num_recommend INT);
CREATE TABLE IF NOT EXISTS user_groups (user_id INT, `group` INT);

CREATE TABLE IF NOT EXISTS club_notes (application_id INT, user_id INT, box TEXT, category VARCHAR(16), rank INT, comments TEXT);
CREATE TABLE IF NOT EXISTS club_notes_categories (club_id INT, name VARCHAR(16));
CREATE TABLE IF NOT EXISTS admin_notes_settings (user_id INT, box_enabled INT, cat_enabled INT, comment_enabled INT);

CREATE TABLE IF NOT EXISTS applications (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, club_id INT, submitted VARCHAR(512));
CREATE TABLE IF NOT EXISTS supplements (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, orderId INT, varname VARCHAR(1024), vardesc TEXT, vartype VARCHAR(1024));
CREATE TABLE IF NOT EXISTS answers (id INT PRIMARY KEY AUTO_INCREMENT, application_id INT, var_id INT, val TEXT);
CREATE TABLE IF NOT EXISTS recommendations (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, instance_id INT, author VARCHAR(64), email VARCHAR(256), auth VARCHAR(64), status INT, filename VARCHAR(32));

CREATE TABLE IF NOT EXISTS messages (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, sender_id INT, receiver_id INT, subject VARCHAR(256), body TEXT, time INT);
CREATE TABLE IF NOT EXISTS message_boxes (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, user_id INT, box_name VARCHAR(32));
CREATE TABLE IF NOT EXISTS message_boxes_contents (box_id INT, message_id INT);
CREATE TABLE IF NOT EXISTS message_prefs (user_id INT PRIMARY KEY, notify_email INT, save_inbox INT, save_trash INT, save_sent INT);

CREATE TABLE IF NOT EXISTS subscriptions (user_id INT, club_id INT);

CREATE TABLE IF NOT EXISTS pages (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), text TEXT);
CREATE TABLE IF NOT EXISTS locks (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ip VARCHAR(16), time INT, action VARCHAR(16), num INT);
