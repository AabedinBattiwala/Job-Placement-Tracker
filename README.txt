CAREERFLOW - PHP + MYSQL BACKEND PACKAGE

This package connects the existing CareerFlow frontend pages to the MySQL database.
The CSS/design is not included here because it is already in your existing css folder.

DATABASE EXPECTED:
Database: careerflow
Tables: users, applications, companies, profiles, settings

IMPORTANT:
1. Keep your existing css folder inside C:\xampp\htdocs\php_project\css
2. Replace the PHP files in php_project with the PHP files from this package.
3. Copy the includes and actions folders into php_project.
4. Keep db.php with your existing MySQL settings.
5. Start Apache and MySQL in XAMPP.
6. Open http://localhost/php_project/register.php

BACKEND FLOW:
register.php -> actions/register_process.php -> users table
login.php -> actions/login_process.php -> session -> dashboard.php
add_application.php -> actions/application_save.php -> applications table
edit_application.php -> actions/application_save.php -> applications table
applications.php -> reads applications table
application_delete.php -> deletes the logged-in user's application
profile.php -> reads users/profiles/applications
settings.php -> actions/settings_save.php -> users/profiles/settings
companies.php -> reads companies table
logout -> actions/logout.php

SECURITY:
- Passwords use password_hash/password_verify.
- Prepared statements are used for database queries.
- Logged-in pages are protected with includes/auth.php.
- Application records are restricted to the logged-in user's user_id.

NOTE:
The Google signup button, 2FA button, and password-change button remain UI-only because they require additional OAuth/security implementation and are not represented by the current database schema.
