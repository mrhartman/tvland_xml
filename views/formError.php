<?php
    session_start();
?>
<h2>Error submitting form:</h2>
<p><?php echo $_SESSION['message']; ?></p>
