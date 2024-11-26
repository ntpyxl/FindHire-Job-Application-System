CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(128) NOT NULL,
  last_name VARCHAR(128) NOT NULL,
  age INT NOT NULL,
  birthdate DATE NOT NULL,
  email_address VARCHAR(256) NOT NULL,
  phone_number VARCHAR(32),
  home_address VARCHAR(512) NOT NULL,
  user_role ENUM('Applicant', 'HR') NOT NULL,
  date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE user_accounts (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(64),
  user_password varchar(128)
);

CREATE TABLE job_posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  poster_id INT,
  job_desc VARCHAR(4096)
);

CREATE TABLE applications (
  application_id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT,
  cover_letter VARCHAR(2048),
  attachment VARCHAR(512)
);

CREATE TABLE messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT,
  sender_id INT,
  message_content VARCHAR(2048)
);