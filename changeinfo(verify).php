<?php

// Verifies email and password entered exists in the database
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    // If user and password matches, then the user goes to the main page
    if ($user) {
        
        if (($_POST["password"] == $user["password"])) {
            $email = htmlspecialchars($user["email"]); 
            
            header("Location: changeinfo.php?email=" . urlencode($email));
            exit(); 
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Login Information</title>
    <meta charset="UTF-8">
</head>
<header>

        <a href="javascript:history.back()" class="back-button">
            <img src="icons8-back-arrow-50.png" alt="Back Button" />
        </a>
    </header>


<body>
    
    <h1>Verify Login Information</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login Information </em>
    <?php endif; ?>
    
    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Submit Login Information</button>
    </form>
    
</body>
</html>
