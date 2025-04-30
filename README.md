# Patient-Management-platform
This application manages patients and their medication schedules. Created for the TIB Open Source Software Developer Task


To run test the API, you can use either Postman or your browser

Make this changes in the Open C:\xampp\apache\conf\httpd.conf file

change this:
DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">

to this:
DocumentRoot "C:/xampp/htdocs/task/public"
<Directory "C:/xampp/htdocs/task/public">
DirectoryIndex index.php


