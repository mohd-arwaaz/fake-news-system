<?php
session_start();      // start session
session_destroy();    // destroy all session data

header("Location: home.php");  // redirect to login
exit();
?>

