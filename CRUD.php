<?php
//create db
$servername = "127.0.0.1";
$username = "root";
$password = "example";

// creating a connection
$connection = new mysqli("127.0.0.1", $username, $password);
// checking connection
if ($connection->connect_error)
{
    die("Connection failed:" . $connection->connect_error);
}

//look through sql docs to only do something if it doesn't exist
//actual creation of db
$sql = "CREATE DATABASE IF NOT EXISTS myDB";
if ($connection->query($sql) === TRUE)
{
    echo "Database created successfully\n";
} else
{
    echo "Error creating database:" . $connection->error;
}

//$connection->close();

//create table
$mysql = "CREATE TABLE IF NOT EXISTS myDB . myTable(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name TINYTEXT,
    email TINYTEXT UNIQUE,
    join_date datetime
)";
try
{
    $connection->query($mysql);
        echo "Table created successfully\n";
} catch (mysqli_sql_exception $e)
{
        echo "Error creating table:" . $e->getMessage();
}
//create crud for table
//create
$data = array(
    array('Alpha', 'alpha@email.com'),
    array('Bravo','bravo@email.com'),
    array('Charlie', 'charlie@email.com'),
    array('Delta', 'delta@email.com'),
    array('Echo', 'echo@email.com'),
);
$statement = $connection->prepare( "INSERT INTO myDB . myTable(name,email) VALUES (?,?)");
$statement->bind_param("ss", $name, $email);

foreach ($data as $row)
{
    $name = $row[0];
    $email = $row[1];
    try
    {
        $statement->execute();
        echo "Data inputted successfully\n";
    } catch (mysqli_sql_exception $e) {
        echo "Data not inputted " . $e->getMessage() . "\n";
    }
}

//read
$result = $connection->query("SELECT * FROM myDB . myTable");
printf("Select returned %d rows.\n", $result->num_rows);

//update
$update = $connection->query("UPDATE myDB . myTable SET name = 'Smith' WHERE name = 'Charlie'");

//delete
$remove = $connection->query("DELETE FROM myDB . myTable WHERE name = 'charlie'");

//show step for what we are doing