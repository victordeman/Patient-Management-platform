# Patient Management Platform

A pure PHP web application for managing patients, medicines, and their intake schedules, developed for the TIB Open Source Software Developer position (Nr. 16/2025).

## Setup Instructions

**1**. **Prerequisites**:
   - PHP 7.4+ (8.x recommended)
   - MySQL
   - Apache or PHP built-in server
   - recommendation => use Xampp for both windows and linux platform.

**2**. **Features**
- Auto-creates database and tables (`patients`, `medicines`, `intakes`).
- Checks for existing tables/data to prevent duplicates.
- Displays required patient/medication lists with infant-safe validation.
- Secure PDO-based queries.

**3**. Notes
- Schema and data defined in `sql/init.php`.
- Built with pure PHP, per task flexibility.

**4**. API Testing Instructions

- To run test the API, you can use either Postman or your browser

-Make this changes in the Open C:\xampp\apache\conf\httpd.conf file

-change this:
   DocumentRoot "C:/xampp/htdocs"
   <Directory "C:/xampp/htdocs">

   to this:
   DocumentRoot "C:/xampp/htdocs/task/public"
   <Directory "C:/xampp/htdocs/task/public">
   DirectoryIndex index.php


