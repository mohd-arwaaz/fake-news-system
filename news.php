<?php include "auth.php"; ?>
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

/* ===== PAGE BACKGROUND ===== */
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

/* ===== HEADER ===== */
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

@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== TOP BAR (LOGOUT) ===== */
.top-bar {
  width: 100%;
  padding: 8px 20px;
  background: linear-gradient(135deg, rgba(2, 136, 105, 0.9));
  text-align: right;
}

.logout-btn {
  padding: 7px 16px;
  background: linear-gradient(135deg, rgb(15, 196, 154), rgb(10, 140, 110));
  color: black;
  text-decoration: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
  box-shadow: 0px 0px 8px rgb(15, 196, 154);
}

.logout-btn:hover {
  transform: scale(1.05);
}

/* ===== NAVIGATION BAR ===== */
nav {
  background: linear-gradient(135deg, rgb(15, 196, 154), rgb(10, 140, 110));
}

nav ul {
  list-style-type: none;
  display: flex;
  justify-content: center;
}

nav ul li a {
  display: block;
  color: white;
  padding: 14px 20px;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
  transition: 0.3s;
}

nav ul li a:hover {
  background: rgba(255,255,255,0.2);
  border-radius: 8px;
}

/* ===== MAIN CONTENT ===== */
main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== GLASS CONTAINER ===== */
.container {
  width: 55%;
  margin: 50px auto;
  background: rgba(0, 0, 0, 0.6);
  padding: 30px;
  border-radius: 18px;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  box-shadow: 0px 8px 18px rgba(0,0,0,0.25);
  border: 1px solid rgba(255,255,255,0.3);
  text-align: center;
  color: white;
  animation: zoomIn 1s ease-in-out;
}

@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

/* ===== FORM STYLING ===== */
form {
  background: rgba(255, 255, 255, 0.95);
  width: 80%;
  margin: 20px auto;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
  text-align: left;
  color: black;
}

/* Labels */
label {
  font-weight: bold;
  display: block;
  margin-top: 10px;
}

/* Text Area */
textarea {
  width: 100%;
  height: 180px;
  padding: 10px;
  margin-top: 8px;
  border-radius: 8px;
  border: 1px solid #aaa;
  resize: none;
}

/* File Upload */
input[type="file"] {
  margin-top: 8px;
}

/* ===== BUTTON ===== */
.btn {
  display: block;
  margin: 25px auto 0;
  padding: 12px 30px;
  background: linear-gradient(135deg, rgb(15, 196, 154), rgb(10, 140, 110));
  color: white;
  border: none;
  border-radius: 25px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0px 0px 10px rgb(15, 196, 154);
}

.btn:hover {
  transform: scale(1.05);
}

/* ===== LOADER ===== */
.loader {
  display: none;
  text-align: center;
  margin-top: 15px;
  color: rgb(15, 196, 154);
  font-weight: bold;
}

/* ===== FOOTER ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(10, 130, 110, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  font-size: 18px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
  .container {
    width: 90%;
  }

  form {
    width: 95%;
  }

  nav ul {
    flex-direction: column;
    text-align: center;
  }
}

</style>
</head>

<body>

<header>
  FAKE NEWS DETECTION SYSTEM
</header>

<div class="top-bar">
  <a href="logout.php" class="logout-btn">Logout</a>
</div>

<nav>
<ul>
  <li><a href="home.php">HOME</a></li>
  <li><a href="register.php">REGISTER</a></li>
  <li><a href="news.php">DETECT NEWS</a></li>
</ul>
</nav>

<main>
<div class="container">
  <h2>Fake News Detection</h2>

  <form action="pridiction.php" method="POST" enctype="multipart/form-data" onsubmit="showLoader()">

  <label>Select Search Type:</label>
<br><br>


<input type="radio" name="search_type" value="national" checked onclick="toggleSelect()"> National
  <select name="national">
    <option>India</option>
</select>

<input type="radio" name="search_type" value="state" onclick="toggleSelect()"> State-wise
<select name="state">

  <option>Andhra Pradesh</option>
  <option>Arunachal Pradesh</option>
  <option>Assam</option>
  <option>Bihar</option>
  <option>Chhattisgarh</option>
  <option>Delhi</option>
  <option>Goa</option>
  <option>Gujarat</option>
  <option>Haryana</option>
  <option>Himachal Pradesh</option>
  <option>Jharkhand</option>
  <option>Karnataka</option>
  <option>Kerala</option>
  <option>Madhya Pradesh</option>
  <option>Maharashtra</option>
  <option>Manipur</option>
  <option>Meghalaya</option>
  <option>Mizoram</option>
  <option>Nagaland</option>
  <option>Odisha</option>
  <option>Punjab</option>
  <option>Rajasthan</option>
  <option>Sikkim</option>
  <option>Tamil Nadu</option>
  <option>Telangana</option>
  <option>Tripura</option>
  <option>Uttar Pradesh</option>
  <option>Uttarakhand</option>
  <option>West Bengal</option>
</select>


<script>
function toggleSelect() {
  const national = document.querySelector('input[value="national"]').checked;

  document.getElementById("nationalSelect").style.display =
      national ? "block" : "none";

  document.getElementById("stateSelect").style.display =
      national ? "none" : "block";
}
</script>


    <label>Paste News Content:</label>
    <textarea name="news_text" placeholder="Paste news article here..." required></textarea>

    <label>Upload News File (Optional):</label>
    <input type="file" name="news_file">

    <button type="submit" class="btn">Detect News</button>

  </form>

  <div class="loader" id="loader">
    Processing... Please wait ⏳
  </div>
</div>
</main>

<footer>
  BE AWARE OF FAKE NEWS
</footer>

<script>
function showLoader() {
  document.getElementById("loader").style.display = "block";
}
</script>

</body>
</html>
