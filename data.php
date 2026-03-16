<?php
include "authadmin.php";

/* DB Connection */
$conn = new mysqli("localhost", "root", "prince143", "books");
if ($conn->connect_error) {
    die("Connection failed");
}

/* Filter */
$statusFilter = "";

if (isset($_GET['filter']) && $_GET['filter'] != "all") {
    $status = $conn->real_escape_string($_GET['filter']);
    $statusFilter = "WHERE status LIKE '$status'";
}


/* Fetch Data */
$result = $conn->query("SELECT * FROM news_result $statusFilter");

if (!$result) {
    die("Query Error: " . $conn->error);
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Search History</title>

<style>
*{
  box-sizing:border-box;
  margin:0;
  padding:0;
  font-family:'Poppins', Arial;
}

/* ---------- BODY ---------- */
body{
  background-image:url("bg.jpg");
  background-size:cover;
  background-position:center;
  min-height:100vh;
  display:flex;
  flex-direction:column;
}

/* ---------- HEADER ---------- */
header{
  background:linear-gradient(135deg,rgb(17,164,137),rgb(8,108,90));
  padding:22px;
  text-align:center;
  font-size:30px;
  color:white;
}

/* ---------- CONTAINER ---------- */
.container{
  width:95%;
  margin:30px auto;
  background:rgba(0,0,0,0.6);
  padding:20px;
  border-radius:16px;
  backdrop-filter:blur(10px);
}

/* ---------- ACTION BAR ---------- */
.actions{
  display:flex;
  justify-content:space-between;
  margin-bottom:15px;
}

select, .btn{
  padding:8px 14px;
  border-radius:20px;
  border:none;
  font-size:14px;
}

select{
  outline:none;
}

.btn{
  background:linear-gradient(135deg,#0ea539,#09e640);
  color:black;
  font-weight:bold;
  cursor:pointer;
}

.btn:hover{
  opacity:0.85;
}

/* ---------- TABLE ---------- */
table{
  width:100%;
  border-collapse:collapse;
  background:white;
  border-radius:10px;
  overflow:hidden;
}

th,td{
  padding:12px;
  border:1px solid #ddd;
  text-align:center;
}

th{
  background:rgb(8,108,90);
  color:white;
}

tr:nth-child(even){
  background:#f2f2f2;
}

/* STATUS */
.real{color:green;font-weight:bold;}
.fake{color:red;font-weight:bold;}

/* ---------- FOOTER ---------- */
footer{
  background:linear-gradient(135deg,rgb(17,164,137),rgb(8,108,90));
  padding:15px;
  text-align:center;
  color:white;
  margin-top:auto;
}
</style>
</head>

<body>

<header>
  SEARCH HISTORY
</header>

<div class="container">

<div class="actions">
  <!-- FILTER -->
  <form method="get">
    <select name="filter" onchange="this.form.submit()">
  <option value="all" <?php if(!isset($_GET['filter']) || $_GET['filter']=="all") echo "selected"; ?>>All</option>
  <option value="real" <?php if(isset($_GET['filter']) && $_GET['filter']=="real") echo "selected"; ?>>Real</option>
  <option value="fake" <?php if(isset($_GET['filter']) && $_GET['filter']=="fake") echo "selected"; ?>>Fake</option>
</select>

  </form>

  <!-- DOWNLOAD -->
  <a href="downloadcsv.php" class="btn">Download CSV</a>
</div>

<table>
<tr>
  <th>S.No</th>
  <th>News Searched</th>
  <th>Status</th>
  <th>Confidence</th>
  <th>Type (National/State)</th>
  <th>state</th>
</tr>


<?php
  $sr = 1;
if ($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    echo "<tr>";
   echo "<td>".$row['sno']."</td>";
echo "<td style='text-align:left'>".htmlspecialchars($row['news_text'])."</td>";
echo "<td class='".strtolower(trim($row['status']))."'>".strtoupper(trim($row['status']))."</td>";
echo "<td>".$row['confidence']."</td>";
echo "<td>".$row['search_type']."</td>";

  // ✅ Correct logic: show National Source OR State
    if ($row['search_type'] === "national") {
        echo "<td>".$row['national']."</td>";
    } else {
        echo "<td>".$row['state']."</td>";
    }

  

    echo "</tr>";
  }
}else{
  echo "<tr><td colspan='6'>No records found</td></tr>";
}
?>
</table>

</div>

<footer>
© 2026 Fake News Detection System | Admin Panel
</footer>

</body>
</html>
