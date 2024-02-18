<?php
spl_autoload_extensions(".php");
spl_autoload_register();

// composerの依存関係のオートロード
require_once 'vendor/autoload.php';

$mysqli = new \Database\MySQLWrapper();

$createTableQuery = "
    CREATE TABLE students (
      id INT PRIMARY KEY AUTO_INCREMENT,
      name VARCHAR(100),
      age INT,
      major VARCHAR(50)
    )
";

$mysqli->query($createTableQuery);