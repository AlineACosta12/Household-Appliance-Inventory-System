Overview

This project is a server-side web application for managing a household appliance inventory. It supports full CRUD functionality (Create, Read, Update, Delete) using PHP and a MySQL database. It is a 2nd-year Server-Side Web Development project.

Features

Home/Index page with navigation menu to key actions

Add Appliance: submit an appliance + owner details via a form and store them in the database

Search Appliance: search by identifiers (e.g., Serial Number, Brand, Model Number) and display matching results

Update Appliance: find an appliance by serial number, edit details, and save updates to the database

Delete Appliance: delete an appliance by serial number with confirmation/feedback messages

Tech Stack

Front-end: HTML, CSS, Bootstrap

Back-end: PHP

Database: MySQL (managed and verified using phpMyAdmin)

Local environment: XAMPP (Apache + MySQL)

Project Structure (example)

index.html – Home page with navigation

Add/ – Add appliance page(s)

Search/ – Search appliance page(s)

Update/ – Update appliance page(s)

Delete/ – Delete appliance PHP page(s)

style.css – Custom styling

appliance_db.sql – MySQL database schema 

Setup Instructions (XAMPP)

Install XAMPP

Start Apache and MySQL in the XAMPP Control Panel

Copy the project folder into:

C:\xampp\htdocs\Projects\YOUR_PROJECT_FOLDER

Import the database:

Open http://localhost/phpmyadmin

Create a database (e.g., appliance_db)

Go to Import → select appliance_db.sql → Go

Check PHP database connection settings (in your PHP files/config):

Host: localhost

User: root

Password: (blank by default in XAMPP unless changed)

Database: appliance_db
