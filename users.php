<?php
include "authadmin.php";   // protect page

$conn = new mysqli("localhost", "root", "prince143", "books");
if ($conn->connect_error) {
    die("Connection failed");
}


/* ---- HANDLE ACTIONS ---- */
if (isset($_GET['action']) && isset($_GET['username'])) {

    $username = $_GET['username'];

    if ($_GET['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM fakenews WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    if ($_GET['action'] == 'activate') {
        $stmt = $conn->prepare("UPDATE fakenews SET status='active' WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    if ($_GET['action'] == 'deactivate') {
        $stmt = $conn->prepare("UPDATE fakenews SET status='inactive' WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    header("Location: users.php");
    exit();
}

$result = $conn->query("SELECT * FROM fakenews");
?>
<!DOCTYPE html>
<html>
<head>
<title>All Users</title>
<style>
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
  color: white;
  line-height: 1.6;
  animation: fadeIn 1.5s ease-in-out;
}

/* Fade animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ---------- HEADER ---------- */
header {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 20px;
  text-align: center;
  font-size: 30px;
  color: white;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
}

/* ---------- TABLE ---------- */
table {
    width: 80%;
    margin: 30px auto;
    border-collapse: collapse;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    border-radius: 10px;
    overflow: hidden;
    color:black;
}

th, td {
    padding: 12px;
    border: 1px solid #aaa;
    text-align: center;
}

th {
    background: rgb(8, 108, 90);
    color: black;
    font-size: 16px;
}

tr:nth-child(even) {
    background: #f2f2f2;
}

/* ---------- BUTTONS ---------- */
button {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

button:hover {
    opacity: 0.85;
}

/* Activate button */
a button {
    background: linear-gradient(135deg, #0ea539, #09e640);
    color: white;
}

/* Deactivate button */
a:nth-child(2) button {
    background: linear-gradient(135deg, #ffb703, #fb8500);
    color: white;
}

/* Delete button */
.delete {
    background: linear-gradient(135deg, #ff7675, #d63031);
    color: white;
}

/* ---------- FOOTER ---------- */
footer {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 15px;
  text-align: center;
  color: white;
  margin-top: 30px;
  font-size: 18px;
}
</style>
</head>

<body>

<header>
    <h1>FAKE NEWS DETECTION SYSTEM</h1>
</header>

<br>
<h2 style="text-align:center; color:white;">Registered Users</h2>

<table>
<tr>
    <th>ID Number</th>
    <th>Username</th>
    <th>Email</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?=$row['serial']?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['status'] ?></td>
        <td>

            <?php if ($row['status'] == 'inactive'): ?>
                <a href="users.php?action=activate&username=<?= $row['username'] ?>">
                    <button>Activate</button>
                </a>
            <?php else: ?>
                <a href="users.php?action=deactivate&username=<?= $row['username'] ?>">
                    <button>Deactivate</button>
                </a>
            <?php endif; ?>

            <a href="users.php?action=delete&username=<?= $row['username'] ?>"
               onclick="return confirm('Are you sure?');">
                <button class="delete">Delete</button>
            </a>

        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="4">No users found</td>
</tr>
<?php endif; ?>

</table>

<footer>
  © 2026 Fake News Detection System | Admin Panel
</footer>

</body>
</html>

