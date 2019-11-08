# madlibs
A little game that runs on a LAMP stack

Platform Requirements:

Mysql version:
mysql  Ver 14.14 Distrib 5.7.27, for Linux (x86_64) using  EditLine wrapper

Apache version:
Apache/2.4.29 

PHP version:
PHP 7.2.24-0ubuntu0.18.04.1

To deploy:

1 - Change the auth strategy for mysql.
Start mysql with just 'mysql' and no other options. The changes we're about to make will make a password mandatory.
Run the following command in mysql: ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '<YOUR PASSWORD>';
The password value used will be the root password of mysql, and will be required for logins from this point forward.

2 - Run dbcreate.sql
Using mysql, run this with the following command: source database.sql
Note - you may have to include the path to this file depending on where it is located.

3 - Place the following files into /var/www/html/ (details incoming).

4 - Edit dbconfig.php to use the password set in step 1.

Once these steps are complete, you should be able to start generating madlibs and saving the result.
