# listmanager
Simple PHP to-do list

This is a project created for class.  It's pretty straight-forward, so not overly commented.

Technology used: PHP, MySQL, JavaScript, jQuery, HTML, CSS, Bootstrap

You can review the individual files or download the .zip.  Feel free to make any mods you wish.

# Installation instructions
1. Import listmanager.sql to create database back-end.  It contains two tables: users and todo_list.

2. Upload the remaining files to a directory of your choice, maintaining the data structure.

3. The database connection file is in the includes directory.  Modify the host, username, and password as necessary, but do not change the database name.  You can place this file outside of the web root for security purposes.  Just be sure to modify the require_once function in the following files to point to the correct location: add.php, login.php, register.php, remove.php, and view-list.php. 

4. Navigate to the index.php file and start using listmanager.  The first step is to create a user, of course.  Note that passwords are hashed using MD5 and stored encrypted.  Email addresses are compared to addresses already in the database to make sure users don't enter duplicates.  

5. After creating an account, you can log in as you wish, add and remove items to/from the list.
