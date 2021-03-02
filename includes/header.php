<?php
require_once('config.php');

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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Drive to Succeed</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/assets/favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/survey-jquery/survey.min.css" type="text/css" rel="stylesheet"/>
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
    <div class="page-container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light d2s-nav">
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
                <form action="login.php">
                    <button type="submit" class="btn btn-outline-danger btn-lg">Login</button>
                </form>
            </div>
        </nav>
