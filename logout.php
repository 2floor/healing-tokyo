<?php
session_start();
unset($_SESSION['jis']);
header("Location:./");
exit();
?>