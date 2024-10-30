<?php
$mysqli = require __DIR__ . "/database.php";

$newPassword = $_POST['new-password'];
$confirmPassword = $_POST['confirm-password'];

if ($newPassword === $confirmPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $_POST['email']); //

    if ($stmt->execute()) {
        echo "Your password has been reset successfully.";
    } else {
        echo "Error updating password. Please try again.";
    }
} else {
    echo "Passwords do not match. Please try again.";
}
?>
