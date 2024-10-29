<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoElectric</title>
    <link rel="stylesheet" type="text/css" href="ExoElectricStyles.css">
    <div align="right">
        <a href="ProfilePage.html"> 
            <img src="Profile.png" alt="Default User Profile" width="10%" height="auto"> 
        </a>
    </div>
</head>
<body>

<?php
$host = 'localhost'; 
$db = 'userdata';   
$user = 'root'; 
$pass = ''; 

// Get input from the previous page
$email = $_GET['email'] ?? '';
// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Prepare a statement to pull data from user
$stmt = $pdo->prepare("SELECT name, address, phone_number, meter_number, id FROM user WHERE email = :email");
$stmt->execute(['email' => $email]);

// Fetch the user data
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user data is found
if (!$userData) {
    echo "No user found with that email.";
    exit();
}
?>

<div>
    <h1>User Information</h1>
    <?php 
    echo "Name: " . htmlspecialchars($userData['name']) . "<br>";
    echo "Address: " . htmlspecialchars($userData['address']) . "<br>";
    echo "Meter Number: " . htmlspecialchars($userData['meter_number']) . "<br>";
    echo "Phone Number: " . htmlspecialchars($userData['phone_number']) . "<br>";
    echo "Email: " . htmlspecialchars($_GET['email']) . "<br>";
    $id = $userData['id'];
    ?>
    
    <form action="processinfo.php" method="post" id="signup" novalidate>
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
        </div>
        
        <div>
            <label for="email">New Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userData['address']); ?>" required>
        </div>
        
        <div>
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($userData['phone_number']); ?>" required>
        </div>
        
        <div>
            <label for="meter_number">Meter Number</label>
            <input type="text" id="meter_number" name="meter_number" value="<?php echo htmlspecialchars($userData['meter_number']); ?>" required>
        </div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <button type="submit">Change Info</button>
    </form>
</div>

</body>
</html>
