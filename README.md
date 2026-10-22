# 🗑️ Waste Management System

## Project Overview

The Waste Management System is a web-based application designed to improve waste collection and management by connecting clients with waste collection services. It provides separate interfaces for clients and administrators to support efficient service requests, complaint handling, and system management.

The project was developed using PHP, MySQL, HTML, CSS, JavaScript, and XAMPP.

## Features

### Client Side
- User registration and login.
- Client dashboard.
- View available waste collection services.
- Submit waste collection requests.
- Track collection request status.
- Submit complaints and view their status.
- View administrator responses to complaints.

### Administrator Side
- Administrator login and dashboard.
- View system statistics.
- View and manage waste collection requests.
- Approve or reject collection requests.
- Support for managing users, services, and complaints as the system is extended.

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript, Bootstrap (if used in the project).
- **Backend:** PHP.
- **Database:** MySQL.
- **Local Development Environment:** XAMPP.
- **Database Management:** phpMyAdmin.
- **Code Editor:** Visual Studio Code.
- **Version Control:** Git and GitHub.

## Project Structure

```text
waste_management/
├── admin/
│   ├── dashboard.php
│   └── requests.php
├── client/
│   ├── dashboard.php
│   ├── requests.php
│   └── complaints.php
├── includes/
│   └── db.php
├── assets/
│   └── css/
│       └── style.css
├── index.php
├── login.php
├── register.php
├── logout.php
└── README.md
```

*Note: Update this structure if your actual project contains additional or differently named files.*

## Installation and Setup

### Prerequisites
- XAMPP with Apache and MySQL.
- Visual Studio Code or another code editor.
- A web browser.

### Steps

1. Clone or download this repository.
2. Place the project folder inside the XAMPP `htdocs` directory.
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. Create a database named `waste_management`.
6. Create the required database tables using your SQL script or the table definitions provided with the project.
7. Open `includes/db.php` and configure the database connection details for your local environment.
8. Open the project in your browser at:

   `http://localhost/waste_management/`

9. Register a client account and log in to test the client features. Configure an administrator account securely for administrator features.

## Database

The application uses MySQL to store user accounts, waste collection services, collection requests, and complaints.

Include a database setup file, such as `database.sql`, in this repository if you want other developers to recreate the database easily. Do not upload real users' personal information or passwords.

## Project Objectives

- Make waste collection requests easier to manage.
- Provide clients with a convenient way to request waste collection services.
- Improve communication through complaint submission and administrator responses.
- Help administrators monitor and manage collection requests.
- Encourage more organized waste management practices.

## Future Improvements

- Online payment integration.
- Notifications for request status updates.
- Waste collection scheduling and tracking.
- Reports and analytics for administrators.
- Improved mobile responsiveness.

## Author

Developed as a web development project to demonstrate practical skills in PHP, MySQL, database management, and web application development.
