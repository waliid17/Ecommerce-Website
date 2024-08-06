<?php 
session_start();
?>

<script>
    /*
    const wishlist = JSON.parse(localStorage.getItem('wishlist'));
    const userId = <?= $_SESSION['user-id'] ?>;

    // Combine the user ID with the wishlist data
    const dataToSend = {
        userId: userId,
        wishlist: wishlist
    };

    fetch('save_wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });


    */
    localStorage.removeItem('wishlist');
    window.location.href = "/pro-outil/";
</script>

<?php
unset($_SESSION['user-id']);
?>