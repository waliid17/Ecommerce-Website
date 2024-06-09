<?php
session_start();
unset($_SESSION['user-id']);
header("Location: /pro-outil/");
?>