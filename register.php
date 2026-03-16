<?php
$message = "";
$msgType = "";

if (isset($_POST['reset'])) {

    if (!isset($_POST['agreement'])) {
        $message = "⚠️ You must agree to the declaration before proceeding!";
        $msgType = "error";
    } else {
        // Your password update logic goes here
        $message = "✅ Declaration accepted. Processing your request...";
        $msgType = "success";
    }
}
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

/* Background */
body {
  background-image: url("bg.jpg"); /* change file name if needed */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  text-align: justify;
  animation: fadeIn 1.5s ease-in-out;
}


/* Page load fade animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ===== HEADER (Modern Gradient + Glass Effect) ===== */
header {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 20px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  color: white;
  backdrop-filter: blur(5px);
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
  animation: slideDown 1s ease-out;
}

header img {
  vertical-align: middle;
  margin-right: 10px;
}

/* Header slide animation */
@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== TOP BAR ===== */
.top-bar {
  width: 100%;
  padding: 8px 25px;
  background: rgba(2, 136, 105, 0.9);
  text-align: right;
}

.login-btn {
  padding: 6px 16px;
  background: white;
  color: rgb(15, 196, 154);
  text-decoration: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
}

.login-btn:hover {
  background: rgb(15, 196, 154);
  color: black;
}

/* ===== MODERN NAVIGATION BAR ===== */
nav {
  background: linear-gradient(90deg, rgb(17, 164, 137), rgb(17,164,137));
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0px 3px 8px rgba(0,0,0,0.3);
}

nav ul {
  list-style-type: none;
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

/* ===== CONTENT AREA ===== */
article {
  background: rgba(0,0,0, 0.6);
  margin: 30px auto;
  padding: 30px;
  width: 80%;
  color:White;
  border-radius: 12px;
  box-shadow: 0px 5px 15px rgba(0,0,0,0.3);
  animation: zoomIn 1s ease-in-out;
}

/* Content animation */
@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

p {
  text-align: start;
  line-height: 1.6;
}

/* ===== FORM (Modern Look) ===== */
form {
  background: rgba(220, 255, 230, 0.9); /* very light green */
  width: 50%;
  margin: 20px auto;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0px 6px 15px rgba(0,0,0,0.2);
  text-align: left;
  color:black;
}



form p {
  font-weight: bold;
  margin: 10px 0 5px;
}

input, select, textarea {
  width: 95%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #888;
  border-radius: 8px;
}

input[type="radio"], 
input[type="checkbox"] {
  width: auto;
  margin: 0 5px;
}

/* ===== BUTTON (Animated Glow) ===== */
.center-btn {
  display: flex;
  justify-content: center;
  align-items: center;
}

button {
  padding: 12px 45px;
  background: linear-gradient(135deg, #0ea539, #09e640);
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0px 0px 10px rgba(15,196,154,0.7));
}

button:hover {
  transform: scale(1.08);
  box-shadow: 0px 0px 20px rgba(15,196,154,0.7);
}

/* ===== FOOTER (Modern Gradient) ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  margin-top: 30px;
  font-size: 18px;
  box-shadow: 0px -3px 8px rgba(0,0,0,0.3);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 600px) {
  nav ul {
    flex-direction: column;
  }

  nav ul li {
    margin: 5px 0;
  }

  article {
    width: 95%;
  }

  form {
    width: 90%;
  }
}



  </style>
</head>

<body>
     <header>
    <h1>
       FAKE NEW'S DETECTON SYSTEM
    </h1>
  </header>

  <div class="top-bar">
    <a href="login.php" class="login-btn">Login</a>
</div>

  <!-- Navigation bar -->
  <nav>
    <ul>
      <li><a href="home.php">HOME</a></li>
     <li><a href="register.php">REGISTER</a></li>
<li><a href="news.php">DETECT NEWS</a></li>
    </ul>
  </nav>

<article>
    <center>
    <h2>Register by giving the below details</h2>
    </center>
  
    <form action="connect.php" method="post">

          <center>
            <h2>User Registration</h2><br>
</center>
         <label for="name">1.Username :</label>
  <input type="text" id="name" name="name" required><br>

  <label for="gender">2 . Gender          :    </label>
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>

<label for="email">3.Gmail ID :</label>
    <input type="email" name="email" required><br><br>

 <label for="Password">4.Password :</label>
   <input type="password" name="password" required><br><br>

  
   <input type="checkbox" name="agreement" required>I hereby declare that the information provided above is true and correct to the best of knowledge.  
     I agree to abide by the rules and regulations of this authorization.<br><BR>

       <center> <input type="reset" value="Reset">

        <input type="submit" value="Submit"><br></center>

        <?php if (!empty($message)): ?>
  <div class="msg <?php echo $msgType; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>





    </form>
  
</article>

<footer>
  BE AWARE OF FAKE NEW'S
</footer>


</body>


</html>