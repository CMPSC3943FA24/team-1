<?php 
$host = 'localhost'; 
$db = 'userdata';   
$user = 'root'; 
$pass = ''; 


$id = $_POST['id'] ?? '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Prepare a statement to pull data from user
$stmt = $pdo->prepare("SELECT name, address, phone_number, meter_number, email FROM user WHERE id = :id");
$stmt->execute(['id' => $id]);

// Fetch the user data
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

try {
  
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $address = isset($_POST['address']) ? trim($_POST['address']) : null;
        $meter_number = isset($_POST['meter_number']) ? trim($_POST['meter_number']) : null;
        $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; 
        if (empty($name)) {
          $name = $userData['name'];
        }
        if (empty($address)) {
           $address = $userData['address'];
        }
        if (empty($phone_number)) {
          $phone_number = $userData['phone_number'];
        }
        if (empty($meter_number)) {
            $meter_number = $userData['meter_number'];
        }
        if (empty($email)) {
            $email = $userData['email']; 
        }
     
        $sql = "UPDATE user SET 
                    name = :name, 
                    address = :address, 
                    meter_number = :meter_number, 
                    phone_number = :phone_number, 
                    email = :email 
                    WHERE id = :id"; 
        $stmt = $pdo->prepare($sql);

       
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':meter_number', $meter_number);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':email', $email); 
        $stmt->bindParam(':id', $id); 

      
        if ($stmt->execute()) {
            echo "User information updated successfully.";
            header("Refresh: 5; url=index.html");
            exit();
        } else {
            echo "Failed to update user information.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
