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
  username VARCHAR(64) NOT NULL,
  user_password varchar(128) NOT NULL
);

CREATE TABLE job_posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  poster_id INT NOT NULL,
  job_title VARCHAR(256) NOT NULL,
  job_desc VARCHAR(4096),
  date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE applications (
  application_id INT AUTO_INCREMENT PRIMARY KEY,
  applicant_id INT NOT NULL,
  post_id INT NOT NULL,
  cover_letter VARCHAR(2048) NOT NULL,
  attachment VARCHAR(512) NOT NULL,
  application_status ENUM('Pending', 'Accepted', 'Rejected') NOT NULL,
  date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT NOT NULL,
  sender_id INT NOT NULL,
  message_content VARCHAR(2048) NOT NULL,
  date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);