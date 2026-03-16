<?php
session_start();

// message variables
$message = "";
$msgType = "";

// Database details
$conn = new mysqli("localhost", "root", "prince143", "books");
if ($conn->connect_error) {
    die("Connection failed");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['admin_name'];
    $password = $_POST['admin_password'];

    $stmt = $conn->prepare("SELECT admin_password FROM dashboard WHERE admin_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['admin_password']) {

            // ✅ LOGIN SUCCESS
            $_SESSION['user'] = $username;

            header("Location: dash.php");
            exit();

        } else {
            $message = "Wrong password";
            $msgType = "error";
        }

    } else {
        $message = "admin not found";
        $msgType = "error";
    }
}

$conn->close();
?>

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

/* ===== PAGE LAYOUT ===== */
body {
  background-image: url("bg.jpg"); 
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

/* ===== HEADER (MATCHED) ===== */
header {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 22px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  color: white;
  backdrop-filter: blur(5px);
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
  animation: slideDown 1s ease-out;
}

/* Header animation */
@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== TOP BAR ===== */
.top-bar {
  width: 100%;
  padding: 8px 20px;
  background: rgba(2, 136, 105, 0.9);
  text-align: right;
}

.login-btn {
  padding: 7px 16px;
  background: white;
  color: rgb(15, 196, 154);
  text-decoration: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
  box-shadow: 0px 0px 8px rgba(15,196,154,0.7);
}

.login-btn:hover {
  background: rgb(15, 196, 154);
  color: black;
  transform: scale(1.05);
}

/* ===== MAIN CONTENT AREA ===== */
main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== GLASS CARD (MATCHED) ===== */
article {
  width: 50%;
  background: rgba(0, 0, 0, 0.6);
  padding: 30px;
  border-radius: 15px;
  backdrop-filter: blur(8px);
  box-shadow: 0px 6px 15px rgba(0,0,0,0.2);
  text-align: center;
  color: white;
  animation: zoomIn 1s ease-in-out;
}

/* Card animation */
@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

/* ===== LOGIN FORM ===== */
form {
  background: rgba(255, 255, 255, 0.95);
  width: 60%;
  margin: 0 auto;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
  text-align: left;
  color: black;
}

/* Form heading */
form h2 {
  color: rgb(15, 196, 154);
  margin-bottom: 15px;
  text-align: center;
}

/* Inputs */
input[type="text"], 
input[type="password"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #aaa;
  border-radius: 6px;
}

/* Remember Me Row */
.remember-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 10px 0;
  font-size: 14px;
}

.remember-row a {
  color: rgb(15, 196, 154);
  text-decoration: none;
}

.remember-row a:hover {
  text-decoration: underline;
}

/* Submit button */
input[type="submit"] {
  width: 100%;
  padding: 10px;
  background: linear-gradient(135deg, rgb(15, 196, 154), rgb(8, 108, 90));
  color: white;
  border: none;
  border-radius: 20px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

input[type="submit"]:hover {
  transform: scale(1.02);
  box-shadow: 0px 0px 10px rgba(15,196,154,0.8);
}

/* Register link */
.register-link {
  text-align: center;
  margin-top: 12px;
  font-size: 14px;
}

.register-link a {
  color: rgb(15, 196, 154);
  font-weight: bold;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}

/* ===== MESSAGE BOX (UNCHANGED) ===== */
.msg {
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 6px;
  font-weight: bold;
  text-align: center;
}

.msg.success {
  color: #155724;
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
}

.msg.error {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
}

/* ===== FOOTER (MATCHED) ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  font-size: 18px;
}

/* ===== RESPONSIVE ===== */
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

<body style="text-align:center; font-family:Arial;">
     <header>
    <h1>
       FAKE NEW'S DETECTON SYSTEM
    </h1>
  </header>


  <main>
<article>
<form action="" method="post">

  <h2>Admin Login Account</h2>

  <!-- MESSAGE DISPLAY -->
  <?php if (!empty($message)): ?>
    <div class="msg <?php echo $msgType; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <label>Username</label>
  <input type="text" name="admin_name" required placeholder="Enter your username">

  <label>Password</label>
  <input type="password" name="admin_password" required placeholder="Enter your password">


  <input type="submit" name="login" value="Login">


</form>
</article>
</main>

  <footer>
  © 2026 Fake News Detection System | Admin Panel
</footer>
</body>


</html>