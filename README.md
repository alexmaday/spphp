# Notes for Sitepoint's PHP and MySQL: Novice to Ninja 5th Edition

## SQL
**Case sensitivity:** Only database and table names are case sensitive. Capitalizing SQL commands is just a human convention.

**Strings:** The single and double quote delimiters are used to surround most data values in SQL. Of course text strings require these, but so too do date values, e.g.: `"YYYY-MM-DD"`. 

The basic wildcard matching character is the percent sign (%). Using SQL's `WHERE` *clause*
with its' `LIKE` *operator*, we might do:
```sql
// The percent sign is case *insensitive*
SELECT * FROM joke WHERE joketext LIKE "%chicken%"; # CHICKEN,ChicKEN, and chicken all match
```

* What is a clause? What is an operator? [1]
  
See [here](https://dev.mysql.com/doc/refman/8.0/en/string-literals.html) for much more.

### Comments in SQL

```sql
mysql> SELECT 1+1;     # This comment continues to the end of line
mysql> SELECT 1+1;     -- This comment continues to the end of line
mysql> SELECT 1 /* this is an in-line comment */ + 1;
mysql> SELECT 1+
/*
this is a
multiple-line comment
*/
1;
```
**Modifying existing data:** SQL has `UPDATE` to change exiting values. Paired with a `WHERE` clause, and we might get something like:

```SQL
UPDATE joke SET jokedate = "1999-01-12"
WHERE id = 2
```
You can also delete data, but not with update!
```sql
// Be *very* careful to provide a WHERE clause. 
// Without one, it will delete all records in the table
DELETE FROM joke WHERE condition
```

## Using SQL with PHP

SQL queries can be executed in php using something like:

```php
// The sql query is a string to be sent to an execution method/function
$sql = 'CREATE TABLE joke (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        joketext TEXT,
        jokedate DATE NOT NULL,
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci';

$pdo->exec($sql);
```

> [DEFAULT CHARACTER SET utf8mb4](https://dev.mysql.com/doc/refman/8.0/en/charset-unicode-sets.html) tells MySQL that you’ll be using up to four bytes per character to encode text in this table. UTF-8 is the most common encoding used for web content, so you should employ it in all your database tables that you intend to use on the Web. -- ch2 Introducing MySQL p39

The COLLATE clause defines the rules for sort order. This can be overridden, but setting it here just makes it the default.

### **Native SQL code (in the shell or phpMyAdmin) vs SQL code sent via PHP**
---

Regular SQL statements are terminated with a semi-colon, while in php, SQL statements aren't complete statements in and of themselves, but are string arguments to be used by database execution methods/functions.

```SQL
# SQL statement with its terminator
SELECT joketext FROM joke;
```

```php
// Preparing an sql string for execution. Here, the semi-colon terminates the PHP statement and *not* the sql query
$mySQLStatement = 'SELECT joketext FROM joke';
```

## PHP

A PHP repl: https://repl.it/

### Making connections to MySQL via PHP's PDO (PHP Data Objects)
---
These days, instead of using `mysqli_*` methods, **PDO** is the new recommended way

1. From the docs
>"Connections are established by creating instances of the PDO base class. It doesn't matter which driver you want to use; you always use the PDO class name. The constructor accepts parameters for specifying the database source (known as the *DSN*, or *Data Source Name*) and optionally for the username and password (if any) ... In general, a **DSN** consists of the PDO driver name, followed by a colon, followed by the PDO driver-specific connection syntax. [more info here ...](https://php.net/manual/en/pdo.construct.php#refsect1-pdo.construct-parameters)


```sql
$pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'ijdbuser', 'mypassword', 'utf8mb4');
```
    
2. Now that We now have a PDO object called `$pdo`,  we configure the connection. 
```php
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // php versions prior to 5.3.6 ignored the charset argument on instantiation, and so required the following ...
    $pdo->exec('SET NAMES "utf8mb4"');
```
4. Ready to rock and roll. PDO's *exec* method runs any string of SQL, e.g.:

```php
$affectedRows = $pdo->exec('SELECT * FROM joke');
// $affectedRows contains the number of rows affected
```

**Additional Reading**

---

* [The Only Proper PDO Tutorial](https://phpdelusions.net/pdo#dsn)
* [Why You Should Be Using PHP's PDO for Database Access](https://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059)
* [PDO Connections from the PHP Docs](https://secure.php.net/manual/en/pdo.connections.php)

### Object Orientation Basics in PHP
---
>*"First of all, an object behaves a lot like an array in that it acts as a container for
other values. ... you can access a value inside an array by
specifying its index (for example, birthdays['Kevin']). When it comes to objects,
the concepts are similar but the names and code are different. Rather than accessing
the value stored in an array index, we say that we’re accessing a **property** of the
object. Instead of using square brackets to specify the name of the property we want
to access, we use **arrow notation**; for instance:"*

**`$myObject->someProperty`**

```php
$myObject = new SomeClass();   // create an object
// The php -> != to JavaScript's =>, aka fat arrow notation
$myObject->someProperty = 123; // set a property's value
echo $myObject->someProperty;  // get a property's value
$myObject->someMethod();
```

### Variables in PHP
---
all variable names in PHP begin with a dollar sign

```php
$foo = 1;
$bar = 33;
$baz = 42;
```

All variables are loosely typed meaning that a single variable may contain any type of data, be it a number, a string of text, or some other kind of value, and may change types over its lifetime.

Variables may be used almost anywhere that you use a literal value. Consider this series of statements:

```php
$var1 = 'PHP';          // Assigns a value of 'PHP' to $var1  
$var2 = 5;              // Assigns a value of 5 to $var2  
$var3 = $var2 + 1;      // Assigns a value of 6 to $var3  
$var2 = $var1;          // Reassigns a value of 'PHP' to $var2  
echo $var1;             // Outputs 'PHP'  
echo $var2;             // Outputs 'PHP'  
echo $var3;             // Outputs '6'  
echo $var1 . ' rules!'; // Outputs 'PHP rules!'  DOT CONCATENATION
echo "$var1 rules!";    // Outputs 'PHP rules!' - variable interpolation requires enclosure in double quotes
echo '$var1 rules!';    // Outputs '$var1 rules!'
```

**IF YOU WANT VARIABLE INTERPOLATION - USE DOUBLE QUOTES!!!**

You can include the name of a variable right inside a text string, and have the value inserted in its place if you surround the string with double quotes instead of single quotes. This process of converting variable names to their values is known as variable interpolation. However, as the last line demonstrates, a string surrounded with single quotes will not interpolate the variable names it contains.

## Arrays
The simplest (preferred) way to create an ***array*** in PHP is to use the built-in `array()` function:

`$myarray = array('one', 2, '3');`

You could also just create an array with empty brackets:

`$anotherArray[] = 'the answer';`

You can add elements to the end of an array using the assignment operator as usual, but leaving empty the square brackets that follow the variable name:
```php
$myarray[] = 'the fifth element';  
echo $myarray[4];       // Outputs 'the fifth element'
```

You can also use strings as indices to create what’s called an **associative array**. This type of array is called associative because it associates values with meaningful indices. In this example, we associate a date (in the form of a string) with each of three names:

```php
$birthdays['Kevin'] = '1978-04-12';  
$birthdays['Stephanie'] = '1980-05-16';  
$birthdays['David'] = '1983-09-09';
```

The array function also lets you create *associative arrays*, if you prefer that method. Here’s how we’d use it to create the `$birthdays` array:

```php
$birthdays = array('Kevin' => '1978-04-12',  
    'Stephanie' => '1980-05-16', 
    'David' => '1983-09-09');
```


Now, if we want to know Kevin’s birthday, we look it up using the name as the index:

`echo 'My birthday is: ' . $birthdays['Kevin'];`

### Looping and iteration

The `for` loop;
```php
for ($i = 0; $i < $max; $i++) {
    // do something $i times
}
```

The `while` loop:
```php
while (condition) {
    // do something while the condition is true
}
```

The `foreach` loop is particularly helpful for processing arrays:

```php
foreach (array as $item)
{
    // process each $item
}
```
`foreach` has an alternative syntax which lends itself to interspersing html within. To begin, this is the new syntax in pure php:
```php
foreach (array as $item):
    // process each $item
endforeach
```
Within an HTML template, intersperse with PHP using the new syntax:
```html
<?php foreach (array as $item): ?>
    <!-- any html code you want -->
    <?php echo "<li>$item</li>"; ?>
<?php endforeach; ?>
```

## PHP and HTML
Because `echo` is used so often, there is a shorthand:
```html
<?php echo 'Hello'; ?>
<!-- OR -->
<?= 'Goodbye'; ?>
```
### URL Query Strings
---

PHP can use query strings to share data

```html
<!-- filename: name.html -->
<p><a href="name.php?name=Alex">Hi, I’m Alex!</a></p>`
```
Note the basic format for a query string includes a question mark separator followed by name=value pairs.

```php
// filename: name.php
<?php  
    $name = $_GET['name'];  // PHP puts the query string inside the superglobal $_GET
    echo 'Welcome to our web site, ' . $name . '!';  
?>
```

To send multiple variables using query strings:

`<p><a href="firstlast.php?firstname=Kevin&lastname=Yank">Hi,  
 I’m Kevin Yank!</a></p>`

> This time, our link passes two variables: `firstname` and `lastname`. The variables are separated in the query string by an ***ampersand*** . You can pass even more variables by separating each name=value pair from the next with additional ampersands. -- See this [StackOverflow post](https://stackoverflow.com/questions/724526/how-to-pass-multiple-parameters-in-a-querystring#724530) for much more 

### A note on malicious code - XSS or cross-site scripting:
----------------
Malicious code can try to take advantage of code the browser intrinsically trusts; query strings in this case. Attackers can manipulate the string to include any html code including javascript, as part of the query string. This is a problem if the server has trust in the query string.

Because of this problem, PHP provides the [`htmlspecialchars()`](http://php.net/manual/en/function.htmlspecialchars.php) function to *sanitize* query strings so that any code present inside a query string, is rendered as text and not evaluated as code. 

```php
$sanitized_string = htmlspecialchars($query_string, ENT_QUOTES, 'utf8mb4');
```

## Logical operators

Logical operators include:

* and, &&
* or, ||
* not, !

 
***Tip for prettier URLs***
Instead of having your URL point to something dot php, make a folder for that file, called whatever you like, and move/copy that php file to this folder *renaming* it to index.php. Now when a user goes to url subfolder, your php runs automatically and looks slightly nicer from the url perspective.

***CONTROLLER***
A PHP script that responds to a browser request by selecting one of several PHP templates to fill in and send back is commonly called a *controller*. A controller contains the logic that controls which template is sent to the browser.

***VIEWS***


### Miscellany
---
* To get a nice formatted presentation of a value use [`var_dump()`](https://secure.php.net/manual/en/function.var-dump.php)
* To get a human-readable representation of a type for debugging, use the [`gettype()`](https://secure.php.net/manual/en/function.gettype.php) function

[1]: https://en.wikipedia.org/wiki/SQL_syntax#Language_elements
