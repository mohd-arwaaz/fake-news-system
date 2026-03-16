<?php 
include "authadmin.php"; 

/* DATABASE CONNECTION */
$conn = new mysqli("localhost", "root", "prince143", "books");
if ($conn->connect_error) {
    die("Connection failed");
}

/* TOTAL USERS */
$totalUsers = $conn->query(
    "SELECT COUNT(*) AS total FROM fakenews"
)->fetch_assoc()['total'];

/* TOTAL DETECTIONS */
$totalDetections = $conn->query(
    "SELECT COUNT(*) AS total FROM news_result"
)->fetch_assoc()['total'];

/* FAKE NEWS */
$fakeCount = $conn->query(
    "SELECT COUNT(*) AS total FROM news_result WHERE status='fake'"
)->fetch_assoc()['total'];

/* REAL NEWS */
$realCount = $conn->query(
    "SELECT COUNT(*) AS total FROM news_result WHERE status='real'"
)->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<style>
/* ---------- RESET ---------- */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', Arial, Helvetica, sans-serif;
}

/* ---------- BODY ---------- */
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

/* Fade animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ---------- TOP BAR ---------- */
.top-bar {
  width: 100%;
  padding: 8px 20px;
  background: rgba(2, 136, 105, 0.9);
  display: flex;
  justify-content: flex-end;
  align-items: center;
  height: 40px;
  backdrop-filter: blur(5px);
}

.login-btn {
  padding: 6px 14px;
  background: white;
  color: rgb(15, 196, 154);
  text-decoration: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
  box-shadow: 0 0 8px rgba(15,196,154,0.7);
}

.login-btn:hover {
  background: rgb(15, 196, 154);
  color: black;
  transform: scale(1.05);
}

/* ---------- HEADER ---------- */
header {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 22px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  color: white;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
}

/* ---------- NAVBAR ---------- */
nav {
  background: linear-gradient(90deg, rgb(17, 164, 137), rgb(17,164,137));
  position: sticky;
  top: 0;
  z-index: 1000;
}

nav ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 5px 0;
}

nav ul li {
  margin: 0 8px;
}

nav ul li a {
  display: block;
  color: white;
  text-align: center;
  padding: 12px 22px;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  transition: 0.3s ease-in-out;
}

nav ul li a:hover {
  background: white;
  color: rgb(15, 196, 154);
  transform: scale(1.05);
}

/* ---------- MAIN ARTICLE ---------- */
article {
  padding: 30px;
}

/* ---------- DASHBOARD ---------- */
.dashboard {
  width: 90%;
  margin: auto;
}

.dashboard h2 {
  text-align: center;
  margin-bottom: 30px;
  color: white;
}

/* ---------- CARDS ---------- */
.cards {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin-bottom: 30px;
}

.card {
  width: 23%;
  padding: 20px;
  text-align: center;
  border-radius: 15px;
  font-weight: bold;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  color: white;
}

.card span {
  display: block;
  font-size: 14px;
  margin-bottom: 8px;
}

.card strong {
  font-size: 32px;
}

/* ---------- CARD COLORS (MATCHED THEME) ---------- */
.blue {
  background: linear-gradient(135deg, #0ea539, #09e640);
}

.purple {
  background: linear-gradient(135deg, rgb(17,164,137), rgb(15,196,154));
}

.red {
  background: linear-gradient(135deg, #ff7675, #d63031);
}

.green {
  background: linear-gradient(135deg, #55efc4, #00b894);
}

/* ---------- SECTIONS ---------- */
.section {
  background: rgba(0, 0, 0, 0.6);
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 12px;
  backdrop-filter: blur(5px);
  box-shadow: 0 0 6px rgba(0,0,0,0.4);
  color: white;
}

.section h3 {
  margin-bottom: 10px;
  color: rgb(15, 196, 154);
}

/* ---------- BUTTON ---------- */
button {
  padding: 10px 30px;
  background: linear-gradient(135deg, rgba(2, 136, 105, 0.9));
  color: white;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  font-size: 15px;
  box-shadow: 0px 0px 10px rgba(15,196,154,0.7);
  transition: 0.3s;
}

button:hover {
  transform: scale(1.05);
}

/* ---------- FOOTER ---------- */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  font-size: 18px;
  margin-top: auto;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
  .cards {
    flex-direction: column;
  }
  .card {
    width: 100%;
  }
  nav ul {
    flex-direction: column;
  }
}
</style>
</head>

<body>

<header>
  <h1>FAKE NEWS DETECTION SYSTEM</h1>
</header>

<div class="top-bar">
  <a href="adminlogout.php" class="login-btn">Logout</a>
</div>

<nav>
  <ul>
    <li><a href="admin.php">Admin Login</a></li>
    <li><a href="dash.php" class="active">Dashboard</a></li>
  </ul>
</nav>

<article>

<div class="dashboard">

  <h2>Admin Dashboard</h2>

  <div class="cards">
    <div class="card blue">
        <span>Total Users</span>
        <strong><?php echo $totalUsers; ?></strong>
    </div>

    <div class="card purple">
        <span>Total Detections</span>
        <strong><?php echo $totalDetections; ?></strong>
    </div>

    <div class="card red">
        <span>Fake News</span>
        <strong><?php echo $fakeCount; ?></strong>
    </div>

    <div class="card green">
        <span>Real News</span>
        <strong><?php echo $realCount; ?></strong>
    </div>
  </div>

  <div class="section">
    <h3>Manage Users</h3>
    <p>View, activate, deactivate or delete registered users.</p><br>
    <button onclick="location.href='users.php'">View Users</button>
  </div>

  <div class="section">
    <h3>Detection Statistics</h3>
    <p>View graphical reports of fake vs real news.</p><br>
    <button onclick="location.href='status.php'">View Statistics</button>
  </div>

  <div class="section">
    <h3>Dataset Management</h3>
    <p>User searched news Real or Fake datasets.</p><br>
    <button onclick="location.href='data.php'">Manage Dataset</button>
  </div>

  <div class="section">
    <h3>Model Performance Report</h3>
    <p>Check accuracy, precision, recall and model details.</p><br>
    <button onclick="location.href='report.php'">View Report</button>
  </div>

</div>

</article>

<footer>
  © 2026 Fake News Detection System | Admin Panel
</footer>

</body>
</html>
