<?php 
session_start();
?>

<script>
    localStorage.removeItem('wishlist');
    window.location.href = "/pro-outil/";
</script>

<?php
unset($_SESSION['user-id']);
?>