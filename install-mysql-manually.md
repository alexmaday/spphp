# Installing MySQL for Windows: The Manual Way

1.	Download the MySQL Community Edition zip file (32bit or 64bit depending on your OS)
2.	Unzip contents to `c:\mysql`
3.	Open a command prompt and change directories to `c:\mysql\bin` and type `mysqld --initialize --console` 
4.	This will build a data directory that will hold the databases. You will be given a temporary (and expired – more on this in step 8), root password.
5.	Now that mysql is initialized, type `mysqld --console` which will start the server process
6.	In a second command window, login using the `c:\mysql\bin\mysql` program using the following syntax: `mysql -u root -p`
7.	Press enter and now type the temporary password that was given in step 4
8.	Ok, we are now connected to the mysql database server as root - *sort of*. Because our password is both temporary and expired, we can't really interact with the server until we change our password.
9. Use the SQL command: `ALTER USER ‘root’@’localhost’ IDENTIFIED BY ‘aNewPassword’;`
10. Cool. We have the power and can run any and all SQL commands we could wish.

>Base installation is complete

## Basic configuration tasks
Create a test database:
```sql
CREATE DATABASE 'nameOfDatabase';
```
Create a user and give them priveleges:
```SQL
CREATE USER 'user'@'host' IDENTIFIED BY 'password';
GRANT ALL ON aDatabase.tableOrGlob TO 'user'@'host';
```

3. Login as this new user and create a dummy table to verify user account creation and priveleges work correctly:
```sql
shell> mysql -u user -p
mysql> SHOW DATABASES;

```

>We have a database server that runs as expected