<!DOCTYPE html>
<html lang="en">
<head>
<h1>Please click <a href="index.html">here</a>.</p> to return to home screen.
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets for Email</title>
    <style>
        h1 {text-align: center;}
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>


<?php
$host = 'localhost'; 
$db = 'userdata';   
$user = 'root'; 
$pass = ''; 

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email input
    $email = $_POST['email'] ?? '';

    // Fetch data from the tickets table based on the email
    try {
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tickets) {
            // Display tickets in a table
            echo "<table>";
            echo "<tr><th>Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Meter Number</th><th>Issue</th><th>Comments</th></tr>";
            foreach ($tickets as $ticket) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($ticket['name']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['address']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['email']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['phone_number']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['meter_number']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['issue']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['comments']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            header("Location: notickets.html");   

        }
    } catch (PDOException $e) {
        echo "Error fetching tickets: " . $e->getMessage();
       // echo "Please click <a href=index.html>here</a>.</p> to return to the main page".
    
    }
}
?>

</body>
</html>
