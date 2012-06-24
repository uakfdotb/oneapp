CREATE TABLE baseapp (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(1024), vardesc VARCHAR(1024), vartype VARCHAR(1024));
CREATE TABLE basecat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), orderId INT);

CREATE TABLE custom (id INT PRIMARY KEY AUTO_INCREMENT, category INT, orderId INT, varname VARCHAR(1024), vardesc VARCHAR(1024), vartype VARCHAR(1024));
CREATE TABLE custom_instance (id INT PRIMARY KEY AUTO_INCREMENT, category INT, user_id INT, status TEXT);
CREATE TABLE custom_response (id INT PRIMARY KEY AUTO_INCREMENT, instance_id INT, var_id INT, val TEXT);
CREATE TABLE custom_cat (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32));
CREATE TABLE user_custom (user_id INT, category INT);

CREATE TABLE users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(64), password VARCHAR(128), salt VARCHAR(40), name VARCHAR(128), email VARCHAR(256), register_time INT, accessed INT);
CREATE TABLE profiles (user_id INT, var_id INT, val VARCHAR(256));

CREATE TABLE clubs (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), description TEXT, view_time INT, open_time INT, close_time INT, num_recommend INT);
CREATE TABLE user_groups (user_id INT, `group` INT);

CREATE TABLE reset (user_id INT PRIMARY KEY, time INT, auth VARCHAR(64));
CREATE TABLE supplements (id INT PRIMARY KEY AUTO_INCREMENT, club_id INT, orderId INT, varname VARCHAR(1024), vardesc TEXT, vartype VARCHAR(1024));
CREATE TABLE subscriptions (user_id INT, club_id INT);
CREATE TABLE applications (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, club_id INT, submitted VARCHAR(512));
CREATE TABLE answers (id INT PRIMARY KEY AUTO_INCREMENT, application_id INT, var_id INT, val TEXT);
CREATE TABLE recommendations (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, instance_id INT, author VARCHAR(64), email VARCHAR(256), auth VARCHAR(64), status INT, filename VARCHAR(32));
CREATE TABLE pages (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(32), text TEXT);
CREATE TABLE club_notes (application_id INT, user_id INT, box TEXT, category VARCHAR(16), rank INT, comments TEXT);
CREATE TABLE club_notes_categories (club_id INT, name VARCHAR(16));
CREATE TABLE admin_notes_settings (user_id INT, box_enabled INT, cat_enabled INT, comment_enabled INT);
CREATE TABLE locks (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ip VARCHAR(16), time INT, action VARCHAR(16), num INT);
CREATE TABLE messages (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, sender_id INT, receiver_id INT, subject VARCHAR(256), body TEXT, time INT);
CREATE TABLE message_boxes (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, user_id INT, box_name VARCHAR(32));
CREATE TABLE message_boxes_contents (box_id INT, message_id INT);
CREATE TABLE message_prefs (user_id INT PRIMARY KEY, notify_email INT, save_inbox INT, save_trash INT, save_sent INT);
