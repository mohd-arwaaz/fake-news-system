<?php
// Database details
$servername = "localhost";
$dbusername = "root";
$dbpassword = "prince143"; 
$database = "books";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['name'];
    $gender   = $_POST['gender'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // SQL query
    $sql = "INSERT INTO fakenews (username, gender, email, password)
            VALUES ('$username', '$gender', '$email', '$password')";

  if ($conn->query($sql) === TRUE) {
        echo " ";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', Arial, Helvetica, sans-serif;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* ===== PAGE LAYOUT (CORRECT FLEX STRUCTURE) ===== */
body {
  background-image: url("bg.jpg"); /* change if needed */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  animation: fadeIn 1.5s ease-in-out;

  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ===== HEADER ===== */
header {
  background: linear-gradient(135deg,  rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 22px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  color: white;
  backdrop-filter: blur(5px);
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
  animation: slideDown 1s ease-out;
}

/* Header slide animation */
@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== MAIN CONTENT WRAPPER (THIS PUSHES FOOTER DOWN) ===== */
main {
  flex: 1;               /* 🔑 KEY FIX: THIS pushes footer down */
  display: flex;
  align-items: center;   /* centers vertically */
  justify-content: center; /* centers horizontally */
}

/* ===== CONTENT CARD ===== */
article {
  width: 55%;
  background: rgba(0, 0, 0, 0.6);
  padding: 30px;
  border-radius: 15px;
  backdrop-filter: blur(8px);
  box-shadow: 0px 6px 15px rgba(0,0,0,0.2);
  text-align: center;
  animation: zoomIn 1s ease-in-out;
}

/* Content animation */
@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

/* ===== SUCCESS FORM BOX ===== */
form {
  background: rgba(255, 255, 255, 0.95);
  width: 60%;
  margin: 0 auto;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
}

/* Success text */
form h1 {
  color:rgb(2, 136, 105);
  font-size: 28px;
  margin-bottom: 15px;
}

/* ===== LOGIN BUTTON ===== */
.login-btn {
  display: inline-block;
  padding: 10px 25px;
  background: linear-gradient(135deg, rgba(2, 136, 105, 0.9));
  color: white;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
  border-radius: 25px;
  transition: 0.3s;
  box-shadow: 0px 0px 10px rgba(2, 136, 105, 0.9);
}

.login-btn:hover {
  transform: scale(1.08);
  box-shadow: 0px 0px 18px rgba(2, 136, 105, 0.9);
}

/* ===== FOOTER (STAYS AT BOTTOM) ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  font-size: 18px;
  box-shadow: 0px -3px 8px rgba(0,0,0,0.3);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 600px) {
  article {
    width: 90%;
  }

  form {
    width: 90%;
  }
}

</style>
</head>

<body>

<header>
  <h1>FAKE NEWS DETECTION SYSTEM</h1>
</header>

<main>
  <article>
    <form>
      <h1>✅ Registration Successful!</h1>
      <a href="login.php" class="login-btn">Go to Login</a>
    </form>
  </article>
</main>

<footer>
  BE AWARE OF FAKE NEWS
</footer>

</body>
</html>

