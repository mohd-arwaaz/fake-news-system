<?php
$conn = new mysqli("localhost", "root", "prince143", "books");

$stmt = $conn->prepare("UPDATE fakenews SET password = ? WHERE username = ?");
$stmt->bind_param("si",$password, $username);



if ($stmt->execute()) {
    echo "Updated successfully";
} else {
    echo "Error";
}

$stmt->close();
$conn->close();
?>