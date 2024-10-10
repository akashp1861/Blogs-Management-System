# Blogs-Management-System

## Introduction 
The Blog Management System is a web application built using PHP, HTML, CSS, and Bootstrap that allows users to create, manage, and display blog posts. Users can sign up, log in, and update their profiles, while admins can manage all blog content.

## Features
- User registration and login system
- Password hashing for secure storage
- Profile update functionality
- Ability to create, edit, and delete blog posts
- View blog posts by each user
- Responsive design with Bootstrap
- Error handling for better user experience
- Admins can manage all user and their blog content.

 ## User Interface
 
### Signup-page
![image](https://github.com/user-attachments/assets/4487f249-b345-4a6b-8a21-70247478f6cf)


### Login-Page
![image](https://github.com/user-attachments/assets/23686ac6-3331-4994-adbc-c1c895dd678d)

### admin-dashboard 
![image](https://github.com/user-attachments/assets/56fc2bce-6f86-42f9-b1e4-003eac9ed240)

### update profile
![image](https://github.com/user-attachments/assets/e2b834e0-6b60-40c1-9bcc-7f957d6a92ce)


### manage user and blogs
![image](https://github.com/user-attachments/assets/a05cfe37-2804-4891-844e-35871c47fc06)

### update-role by admin
![image](https://github.com/user-attachments/assets/ce3925c8-5b2e-4195-ac9b-f3753cb7c323)


### blogs-feed
![image](https://github.com/user-attachments/assets/8ffa1ce9-3b53-4e10-b15d-91a70abd5e09)

### edit-blog
![image](https://github.com/user-attachments/assets/0fbfc35a-bb90-42f8-9983-e1978604d9f2)

### user-dashboard 
![image](https://github.com/user-attachments/assets/059018fb-6a8d-4338-ad70-6fc1766fb4b6)

### view your blogs
![image](https://github.com/user-attachments/assets/9671185d-2517-4ff0-94fb-6caea3dea041)


## Technologies Used
- PHP
- MySQL
- HTML
- CSS
- Bootstrap

## Prerequisites
- XAMPP (to run Apache and MySQL servers)
- Git (to clone the repository)

## Setup Instructions
1. Clone the repository: 
- git clone https://github.com/akashp1861/Blogs-Management-System.git

2. Move the Project to the htdocs Directory:

- Navigate to your XAMPP installation directory (usually C:\xampp on Windows).
- Copy or move the cloned project folder to the htdocs directory.

## Set Up the Database:

- Start XAMPP Control Panel and ensure that both Apache and MySQL services are running.
- Open your web browser and go to http://localhost/phpmyadmin.
- Create a new database for the project
- Database: `blogsmanagement`

### Create table user:
  
CREATE TABLE `user` (

  `sno` int(4) NOT NULL,
  
  `username` text NOT NULL,
  
  `password` varchar(300) NOT NULL,
  
  `role` varchar(10) NOT NULL DEFAULT 'user'
  
)

### create table blog_post :

CREATE TABLE `blog_posts` (

  `id` int(11) NOT NULL,

  `title` varchar(255) NOT NULL,

  `content` text NOT NULL,

  `author` varchar(100) NOT NULL,

  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),

  `user_id` int(11) DEFAULT NULL
  
)


### Update Database Configuration:

- Open the partials/-dbconnect.php file.
- Update the database connection details as follows:

![image](https://github.com/user-attachments/assets/dcdceaf1-dd0c-40a5-98d9-a72e3f962370)


## Access the Application:

- In your web browser, go to http://localhost/LoginSystem  to access the application.
- For specific pages, use the query parameters, e.g., http://localhost/LoginSystem/?page=-login for the login page.

## Usage
- Sign Up: Create a new account using the signup page.
- Login: Access your account using the login page.
- Update Profile: Users can update their username and password in the profile section.
- Manage Blogs: Users can create, edit, and delete their blog posts.
- Manage user and Blog : Admin can update the role of user and edit their blogs.
