<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

$pages = array(
    'index.php' => 'Home',
    'about.php' => 'About',
    'institute.php' => 'Our Institute',
    'lessons.php' => 'Lessons',
    'contact.php' => 'Contact',
    'faqs.php' => 'FAQS',
);

$currentPage = basename($_SERVER['REQUEST_URI']) ;

if(empty($currentPage)) { //incase on home page
    $currentPage = 'index.php';
}

//Check user session for expiry (30 minutes inactive)
if($user->is_logged_in()) {
    if(!$user->sessionValidate()) {
		header('Location: login.php?action=expired'); 
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITE_NAME; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/assets/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script>    var $j = jQuery.noConflict(); //Reserved due to conflict issues </script>
</head>

<body>
    <div class="page-container">
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light d2s-nav">
        <a class="navbar-brand" href="index.php"><img src="assets/logo.svg" alt="Drive 2 Succeed"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <?php 
                    foreach ($pages as $filename => $pageTitle) {
                        if ($filename == $currentPage) {
                            echo '<li class="nav-item active">';
                            echo '<a class="nav-link" href="' . $filename . '">' . $pageTitle . ' <span class="sr-only">(current)</span></a>';
                            echo '</li>';
                        } else {
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . $filename . '">' . $pageTitle . '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
                <?php
                if(!$user->is_logged_in()) {
                    echo '<form action="login.php"><button type="submit" class="btn btn-outline-primary btn-lg">Login</button></form>';
                } else {
                    // echo '<span class="navbar-text"><a href="user.php">My Account <img src="assets/icons/avatar.svg"/></a></span>';
                    echo '<span class="navbar-text">
                    <li id="prof-drop" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="assets/icons/avatar.svg"/> ' . $_SESSION['name'] . '
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">
                        <a class="dropdown-item" href="user.php">My Profile</a>';
                        
                        if($user->isAdmin()) {
                            echo '<a class="dropdown-item" href="builder.php">Content Builder</a>';
                        }

                        echo '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="logout()">Logout</a>
                        </div>
                    </li></span>';
                }
                ?>
            </div>
        </nav>
        <script src="js/nav.js"></script>
