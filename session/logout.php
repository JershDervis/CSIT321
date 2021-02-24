<?php 

require_once('../config.php');

$user->logout(); 

header('Refresh: 5;URL=../index.php');

?>

<center>
    <div>
        Logging out... returning to home page in 5 seconds<br>
        Home page not loading? <a href="../index.php">Click Here</a>
    </div>
</center>

<?php

require('../includes/footer.php');

?>