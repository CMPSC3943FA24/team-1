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

// Get input from the form
$email = $_POST['email'] ?? '';
$image = $_FILES['profilePic'] ?? null;

if (!empty($email)) {
    try {
        // Prepare a statement to pull data from user
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Fetch the user data
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Handle the image upload with validation
            $imageData = null;
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $fileType = mime_content_type($image['tmp_name']);
                $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                
                if (in_array($fileType, $allowedTypes)) {
                    $imageData = file_get_contents($image['tmp_name']);
                } else {
                    echo "Invalid file type. Only PNG and JPG files are allowed.";
                    exit;
                }
            } else {
                echo "Image upload error.";
                exit;
            }

            // Prepare statement to update user data
            $updateStmt = $pdo->prepare("UPDATE user SET image = :image WHERE email = :email");

            // Bind parameters and execute the update statement
            $updateStmt->execute([
                'image' => $imageData,
                'email' => $email,
            ]);

            echo "User profile picture updated successfully.";
            header("Refresh: 5; url=index.html");
            exit();
        } else {
            echo "No user found with that email.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Email is required.";
}
?>
