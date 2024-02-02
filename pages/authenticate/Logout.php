<?php
    unset($_COOKIE[session_name()]); 
    //setcookie(session_name(), null, -1, '/'); 
    $session->destroy();
    
?>
<script>
   
             window.setTimeout(function() {
                window.location.href="index.php";
            }, 500);
</script>
