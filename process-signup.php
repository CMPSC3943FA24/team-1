<?php

// This code assigns the inputs to variables and then inputs the variables in a table of the database in this case "user" and brings the user to another html file that lets them know the signup was successful
$mysqli = require __DIR__ . "/database.php";
$sql = "INSERT INTO user (name, address, email, phone_number, password)
       VALUES ( ?, ?, ?, ?, ? )";
   
   
   $stmt = $mysqli->stmt_init();

   if ( ! $stmt->prepare($sql)) {
       die("SQL error: " . $mysqli->error);
   }
   
   $stmt->bind_param("sssss",
                     $_POST["name"],
                     $_POST["address"],
                     $_POST["email"],
                     $_POST["phone_number"],
                     $_POST["password"]);
                     
                     if ($stmt->execute()) {
   
                        header("Location: signup-success.html");
                        exit;
                     }   