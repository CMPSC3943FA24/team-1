<!DOCTYPE html>
<html lang="en">
<head>
<header>
<style>
           /* Ensure the back button is smaller */
           .back-button img {
            width: 3%;  /* Make the back button image smaller */
            height: auto; /* Maintain aspect ratio */
        }

        /* Ensure the parent container is wide enough */
        .logo-container {
            width: 100%;  /* Make sure the container takes up full width */
            text-align: center; /* Center the logo */
        }

        /* Style for the logo image */
        .logo-container img {
            width: 70% !important;  /* Make the image 80% of the parent container's width */
            height: auto !important;  /* Maintain aspect ratio */
        }
    </style>
</head>
<body>

<header>
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button">
        <img src="icons8-back-arrow-50.png" alt="Back Button" width="20%" />
    </a>
</header>

<div class="logo-container">
    <!-- Logo Image with increased size -->
    <img src="LongLogo_Blk.png" alt="ExoElectric Logo">
</div>
      <br> <br>
      <div align="center">
    <p><h1>Click <a href="index.php">here</a> to return to the home screen.</h1></p><br>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.70">
    <title>Tickets for Email</title>
    <style>
        h1 { text-align: center; }
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
        img {
            width: 100px; /* Adjust size as needed */
            height: auto;
            cursor: pointer; /* Change cursor to pointer for clickable images */
        }
        .fullscreen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .fullscreen img {
            width: auto;
            height: 90%; /* Maintain aspect ratio and fit within the viewport */
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="fullscreen" id="fullscreenImage" onclick="closeFullscreen()">
    <img id="fullImage" src="" alt="Fullscreen Image">
</div>

<!-- Modal for Comments -->
<div id="commentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Comments</h2>
        <p id="commentText"></p>
    </div>
</div>

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
        $stmt = $pdo->prepare("SELECT * FROM maintenance WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $maintenance = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($maintenance) {
            // Display tickets in a table
            echo  "<h2>Your Preventative Maintenance Tickets<h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Meter Number</th><th>Issue</th><th>Comments</th><th>Image</th><th>Status</th></tr>";
            foreach ($maintenance as $maintenance) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($maintenance['name']) . "</td>";
                echo "<td>" . htmlspecialchars($maintenance['address']) . "</td>";
                echo "<td>" . htmlspecialchars($maintenance['email']) . "</td>";
                echo "<td>" . htmlspecialchars($maintenance['phone_number']) . "</td>";
                echo "<td>" . htmlspecialchars($maintenance['meter_number']) . "</td>";
                echo "<td>" . htmlspecialchars($maintenance['issue']) . "</td>";
                // Button to show comments
                echo "<td><button onclick='openModal(\"" . htmlspecialchars(addslashes($maintenance['comments'])) . "\")'>View Comments</button></td>";
                // Display the image if it exists
                if ($maintenance['image']) {
                    $imageData = base64_encode($maintenance['image']);
                    echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Ticket Image' onclick='openFullscreen(this)'></td>";
                } else {
                    echo "<td>No Image</td>";
                }
                echo "<td>" . htmlspecialchars($maintenance['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>You have no active maintenance tickets</h2> ";
        }
    } catch (PDOException $e) {
        echo "Error fetching tickets: " . $e->getMessage();
    }
}
echo  "<br> <br> <br>";
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
            echo  "<h2>Your Outage Tickets<h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Meter Number</th><th>Issue</th><th>Comments</th><th>Image</th><th>Status</th></tr>";
            foreach ($tickets as $ticket) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($ticket['name']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['address']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['email']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['phone_number']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['meter_number']) . "</td>";
                echo "<td>" . htmlspecialchars($ticket['issue']) . "</td>";
                // Button to show comments
                echo "<td><button onclick='openModal(\"" . htmlspecialchars(addslashes($ticket['comments'])) . "\")'>View Comments</button></td>";
                // Display the image if it exists
                if ($ticket['image']) {
                    $imageData = base64_encode($ticket['image']);
                    echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Ticket Image' onclick='openFullscreen(this)'></td>";
                } else {
                    echo "<td>No Image</td>";
                }
                echo "<td>" . htmlspecialchars($ticket['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>You have no active outage tickets</h2> ";
        }
    } catch (PDOException $e) {
        echo "Error fetching tickets: " . $e->getMessage();
    }
}
?>

<script>
function openFullscreen(img) {
    const fullImage = document.getElementById("fullImage");
    const fullscreenDiv = document.getElementById("fullscreenImage");
    fullImage.src = img.src; // Set the source of the fullscreen image to the clicked image
    fullscreenDiv.style.display = "flex"; // Show the fullscreen div
}

function closeFullscreen() {
    const fullscreenDiv = document.getElementById("fullscreenImage");
    fullscreenDiv.style.display = "none"; // Hide the fullscreen div
}

// Modal Functions
function openModal(comments) {
    const modal = document.getElementById("commentModal");
    const commentText = document.getElementById("commentText");
    commentText.textContent = comments; // Set the comments text
    modal.style.display = "flex"; // Show the modal
}

function closeModal() {
    const modal = document.getElementById("commentModal");
    modal.style.display = "none"; // Hide the modal
}

// Close modal when clicking outside of modal content
window.onclick = function(event) {
    const modal = document.getElementById("commentModal");
    if (event.target === modal) {
        closeModal();
    }
}
</script>

</body>
</html>