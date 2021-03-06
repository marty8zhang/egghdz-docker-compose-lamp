<?php
/* @noinspection SqlNoDataSourceInspection | SqlResolve */
$dsn = 'mysql:dbname=Egghdz_Database;host=mariadb;charset=UTF8';
$user = 'egghdz_user';
$password = 'egghdzpassword';

try {
    $pdoDatabase = new PDO($dsn, $user, $password);
    $pdoDatabase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connected to the database.<br>';

    $pdoStatement = $pdoDatabase->query(<<<QUERY
            CREATE TABLE IF NOT EXISTS test (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            QUERY);

    echo 'Created the `test` database table.<br>';

    $uniqueId = uniqid();
    $pdoStatement = $pdoDatabase->query(<<<QUERY
            INSERT INTO test VALUES
            (NULL, "Test Title {$uniqueId}", "Test description {$uniqueId}.");
            QUERY);

    echo 'Inserted '.$pdoStatement->rowCount(). ' record(s).<br>';

    $pdoStatement = $pdoDatabase->query(<<<QUERY
            SELECT * FROM test;
            QUERY);

    echo '<pre>'.print_r($pdoStatement->fetchAll(PDO::FETCH_ASSOC),true).'</pre>';
} catch (Throwable $e) {
    echo 'Exception/Error: ' . $e->getMessage();
}
