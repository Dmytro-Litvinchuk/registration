<h1>Registration and authorization(in secure way)</h1>
<h3>Table structure in DB</h3>
<pre>
CREATE TABLE reg (
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fname VARCHAR(30) NOT NULL,
    lname VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL
);
</pre>
<ul>
<h3>PHP files:</h3>
  <li>Index.php - file for registration and authorization.</li>
  <li>Validator.php - index.php use the class for validation his forms (sign up and log in).</li>
  <li>Welcome.php - user personal page.</li>
<h3>jQuery files:</h3>
  <li>validation.js - simple validation both form.</li>
<h3>CSS files:</h3>
  <li>style.css - the forms style.</li>
  <li>welcome.css - personal page style.</li>
<h3>HTML files:</h3>
  <li>template.html - the forms template.</li>
  <li>welcome.html - personal page template.</li>
</ul>
<p>I used <a href="https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php">this</a> tutorial.</p>
