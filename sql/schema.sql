CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin', 'librarian', 'instructor', 'student')
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  department VARCHAR(50),
  objectives TEXT
);

CREATE TABLE resources (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  type ENUM('pdf', 'link', 'video'),
  path TEXT,
  tags TEXT
);

CREATE TABLE course_resource_map (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  resource_id INT,
  FOREIGN KEY(course_id) REFERENCES courses(id),
  FOREIGN KEY(resource_id) REFERENCES resources(id)
);

CREATE TABLE user_activity (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  resource_id INT,
  course_id INT,
  access_time DATETIME DEFAULT CURRENT_TIMESTAMP
);
