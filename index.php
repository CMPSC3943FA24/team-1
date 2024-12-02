<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Access user information from the session
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$image = $_SESSION['image'];
$authority = $_SESSION['authority'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ExoElectric Dashboard</title>
    <link rel="stylesheet" type="text/css" href="ExoElectricStyles.css">
</head>
<header>

<a href="javascript:history.back()" class="back-button">
    <img src="icons8-back-arrow-50.png" alt="Back Button" />
</a>
</header>
<body>
        <a href="logout.php"> <button class="button-1">Logout</button> </a>
<div align="right">
    <!-- User Profile Image -->
   
        <?php
        // Check if $image is not null and display the appropriate image
        if (!empty($image)) {
            // If $image is not null, display the user's image
            echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="User Profile" width="10%" height="auto">';
        } else {
            // If $image is null, display the default noimage.jpg
            echo '<img src="noimage.jpg" alt="No Profile Image" width="10%" height="auto">';
        }
        ?>
    </a>
</div>


  <div align="center">
    <img src="LongLogo_Blk.png" alt="ExoElectric Logo" width="50%" height="auto"> 
    <p>Hello, <?php echo htmlspecialchars($name); ?> </p> <!-- Display user name dynamically -->
    <br> <br>
  </div>

  
    <!-- Navigation Buttons -->
    <a href="MyRequests.html"> <button class="button-1">My Requests</button> </a>
    <br> <br>
    <a href="ticket.html"> <button class="button-1">Report an Outage</button> </a> 
    <br> <br>
    <a href="Preventative Maintenance.html"> <button class="button-1">Preventative Maintenance Request</button> </a>
    <br> <br>
    <a href="LocalMap.php"> <button class="button-1">Your Area Map</button> </a>
    <br> <br>
    <a href="changeinfo(verify).php"> <button class="button-1">Change User Information</button> </a>
    <br> <br>
    <a href="addphoto.php"> <button class="button-1">Profile Picture</button> </a>
    <br> <br>
    <!-- Show the "Active Tickets" button only if authority > 1 -->
    <?php if ($authority > 1): ?>
      
      <a href="linementickets.php">
        <button class="button-1">Active Tickets</button>
      </a>
      <br><br>
    <?php endif; ?>
    <?php if ($authority > 1): ?>
      
      <a href="signup.html">
        <button class="button-1">Signup Users</button>
      </a>
      <br><br>
    <?php endif; ?>
  </div>

</body>
</html>
