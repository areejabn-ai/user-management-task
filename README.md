# User Management System

A simple web application developed using HTML, CSS, JavaScript, PHP, and MySQL.

## Project Description

This project allows users to enter their name and age through a web form. The submitted information is stored in a MySQL database and displayed in a table.

Each user has a status value of either 0 or 1. The Toggle button changes the status between 0 and 1 without refreshing the webpage.

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- MySQL
- AJAX
- InfinityFree Hosting

## How It Works

1. The user enters a name and age.
2. The user clicks the Submit button.
3. PHP stores the information in the MySQL database.
4. The stored users are displayed in a table.
5. Each user has a Toggle button.
6. Clicking Toggle sends an AJAX request to `toggle.php`.
7. The status changes between 0 and 1.
8. The new status appears immediately without refreshing the page.

## Files

### index.php
Contains the webpage, form, database insertion, data display, CSS, and JavaScript/AJAX.

### toggle.php
Updates the user's status in the MySQL database and returns the new status.

### db.php
Contains the database connection configuration.

For security, the database credentials shown in this public GitHub repository are placeholders and the real credentials are stored only on the hosting server.

## Database Table

Table name: `users`

Columns:

- `id` - Primary Key and Auto Increment
- `name` - User name
- `age` - User age
- `status` - User status (0 or 1)

## Hosting

The project was deployed and tested using InfinityFree web hosting.
