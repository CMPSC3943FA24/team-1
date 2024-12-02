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
        <br><br>

        <div style="text-align:center; margin-bottom: 20px;">
            <a href="archive.php">
                <button style="padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Go to Archive
                </button>
            </a>
        </div>
        <div style="text-align:center; margin-bottom: 20px;">
            <a href="index.php">
                <button style="padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Go to Homepage
                </button>
            </a>
        </div>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Tickets</title>
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

// Function to archive and delete a maintenance ticket
function archiveMaintenanceTicket($ticketNumber) {
    global $pdo;
    try {
        // Fetch the ticket data from the maintenance table
        $stmt = $pdo->prepare("SELECT * FROM maintenance WHERE ticket_number = :ticket_number");
        $stmt->execute(['ticket_number' => $ticketNumber]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ticket) {
            // Copy to archive table
            $archiveStmt = $pdo->prepare("INSERT INTO archive (ticket_number, name, address, email, phone_number, meter_number, issue, comments, image, status) 
                                          VALUES (:ticket_number, :name, :address, :email, :phone_number, :meter_number, :issue, :comments, :image, :status)");
            $archiveStmt->execute([
                'ticket_number' => $ticket['ticket_number'],
                'name' => $ticket['name'],
                'address' => $ticket['address'],
                'email' => $ticket['email'],
                'phone_number' => $ticket['phone_number'],
                'meter_number' => $ticket['meter_number'],
                'issue' => $ticket['issue'],
                'comments' => $ticket['comments'],
                'image' => $ticket['image'],
                'status' => $ticket['status']
            ]);

            // Delete the original ticket from the maintenance table
            $deleteStmt = $pdo->prepare("DELETE FROM maintenance WHERE ticket_number = :ticket_number");
            $deleteStmt->execute(['ticket_number' => $ticketNumber]);

            // Redirect to the current page or to a specific page like linementickets.php
            header("Location: linementickets.php");
            exit;
        } else {
            echo "<script>alert('Maintenance Ticket not found.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to archive and delete an outage ticket
function archiveOutageTicket($ticketNumber) {
    global $pdo;
    try {
        // Fetch the ticket data from the tickets table
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE ticket_number = :ticket_number");
        $stmt->execute(['ticket_number' => $ticketNumber]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($ticket) {
            // Copy to archive table
            $archiveStmt = $pdo->prepare("INSERT INTO archive (ticket_number, name, address, email, phone_number, meter_number, issue, comments, image, status) 
                                          VALUES (:ticket_number, :name, :address, :email, :phone_number, :meter_number, :issue, :comments, :image, :status)");
            $archiveStmt->execute([
                'ticket_number' => $ticket['ticket_number'],
                'name' => $ticket['name'],
                'address' => $ticket['address'],
                'email' => $ticket['email'],
                'phone_number' => $ticket['phone_number'],
                'meter_number' => $ticket['meter_number'],
                'issue' => $ticket['issue'],
                'comments' => $ticket['comments'],
                'image' => $ticket['image'],
                'status' => $ticket['status']
            ]);
    
            // Delete the original ticket from the tickets table
            $deleteStmt = $pdo->prepare("DELETE FROM tickets WHERE ticket_number = :ticket_number");
            $deleteStmt->execute(['ticket_number' => $ticketNumber]);
    

            header("Location: linementickets.php");
            exit; 
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} 

// Function to set maintenance ticket to "In Progress"
function setMaintenanceTicketInProgress($ticketNumber) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE maintenance SET status = 'In Progress' WHERE ticket_number = :ticket_number");
        $stmt->execute(['ticket_number' => $ticketNumber]);
        header("Location: linementickets.php"); // Redirect after updating
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to set outage ticket to "In Progress"
function setOutageTicketInProgress($ticketNumber) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE tickets SET status = 'In Progress' WHERE ticket_number = :ticket_number");
        $stmt->execute(['ticket_number' => $ticketNumber]);
        header("Location: linementickets.php"); // Redirect after updating
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// If an archive action is triggered
if (isset($_GET['archive_maintenance_ticket_number'])) {
    $ticketNumber = $_GET['archive_maintenance_ticket_number'];
    archiveMaintenanceTicket($ticketNumber);
}

if (isset($_GET['archive_outage_ticket_number'])) {
    $ticketNumber = $_GET['archive_outage_ticket_number'];
    archiveOutageTicket($ticketNumber);
}

// If an action is triggered to set maintenance ticket to "In Progress"
if (isset($_GET['set_in_progress_maintenance_ticket_number'])) {
    $ticketNumber = $_GET['set_in_progress_maintenance_ticket_number'];
    setMaintenanceTicketInProgress($ticketNumber);
}

// If an action is triggered to set outage ticket to "In Progress"
if (isset($_GET['set_in_progress_outage_ticket_number'])) {
    $ticketNumber = $_GET['set_in_progress_outage_ticket_number'];
    setOutageTicketInProgress($ticketNumber);
}

// Fetch all maintenance tickets
try {
    $stmt = $pdo->prepare("SELECT * FROM maintenance");
    $stmt->execute();
    $maintenanceTickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($maintenanceTickets) {
        echo "<h2>Maintenance Tickets</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Meter Number</th><th>Issue</th><th>Comments</th><th>Image</th><th>Status</th><th>Complete Tickets</th><th>Change Status</th></tr>";
        foreach ($maintenanceTickets as $ticket) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($ticket['name']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['address']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['email']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['phone_number']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['meter_number']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['issue']) . "</td>";
            echo "<td><button onclick='openModal(\"" . htmlspecialchars(addslashes($ticket['comments'])) . "\")'>View Comments</button></td>";
            if ($ticket['image']) {
                $imageData = base64_encode($ticket['image']);
                echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Ticket Image' onclick='openFullscreen(this)'></td>";
            } else {
                echo "<td>No Image</td>";
            }
            echo "<td>" . htmlspecialchars($ticket['status']) . "</td>";
            echo "<td><a href='?archive_maintenance_ticket_number=" . $ticket['ticket_number'] . "&table=maintenance'>
            <button>Archive & Delete</button>
        </a>
      </td>";
            echo "<td>
            <a href='?set_in_progress_maintenance_ticket_number=" . $ticket['ticket_number'] . "'>
                <button>Set to In Progress</button>
            </a>
          </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No Maintenance Tickets Found</h2>";
    }
} catch (PDOException $e) {
    echo "Error fetching maintenance tickets: " . $e->getMessage();
}

// Fetch all outage tickets
try {
    $stmt = $pdo->prepare("SELECT * FROM tickets");
    $stmt->execute();
    $outageTickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($outageTickets) {
        echo "<h2>Outage Tickets</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Address</th><th>Email</th><th>Phone Number</th><th>Meter Number</th><th>Issue</th><th>Comments</th><th>Image</th><th>Status</th><th>Complete Tickets</th><th>Change Status</th></tr>";
        foreach ($outageTickets as $ticket) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($ticket['name']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['address']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['email']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['phone_number']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['meter_number']) . "</td>";
            echo "<td>" . htmlspecialchars($ticket['issue']) . "</td>";
            echo "<td><button onclick='openModal(\"" . htmlspecialchars(addslashes($ticket['comments'])) . "\")'>View Comments</button></td>";
            if ($ticket['image']) {
                $imageData = base64_encode($ticket['image']);
                echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Ticket Image' onclick='openFullscreen(this)'></td>";
            } else {
                echo "<td>No Image</td>";
            }
            echo "<td>" . htmlspecialchars($ticket['status']) . "</td>";
            echo "<td><a href='?archive_outage_ticket_number=" . $ticket['ticket_number'] .  "&table=maintenance'>
            <button>Archive & Delete</button>
        </a>
      </td>";
            echo "<td>
            <a href='?set_in_progress_outage_ticket_number=" . $ticket['ticket_number'] . "'>
                <button>Set to In Progress</button>
            </a>
          </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No Outage Tickets Found</h2>";
    }
} catch (PDOException $e) {
    echo "Error fetching outage tickets: " . $e->getMessage();
}
?>

<script>
function openFullscreen(img) {
    const fullImage = document.getElementById("fullImage");
    const fullscreenDiv = document.getElementById("fullscreenImage");
    fullImage.src = img.src;
    fullscreenDiv.style.display = "flex"; 
}

function closeFullscreen() {
    const fullscreenDiv = document.getElementById("fullscreenImage");
    fullscreenDiv.style.display = "none";
}

// Modal Functions
function openModal(comments) {
    const modal = document.getElementById("commentModal");
    const commentText = document.getElementById("commentText");
    commentText.textContent = comments;
    modal.style.display = "flex";
}

function closeModal() {
    const modal = document.getElementById("commentModal");
    modal.style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById("commentModal");
    if (event.target === modal) {
        closeModal();
    }
}
</script>

</body>
</html>
