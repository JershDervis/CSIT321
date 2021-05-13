<?php
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}

$required = ['unitID', 'title', 'link'];

foreach($required as $ex) {
    if((!isset($_POST[$ex]) && empty($_POST[$ex]))) {
        echo json_encode('Didn\'t received expected input');
        exit;
    }
}

//Update in the database
try {
    $stmt = $db->prepare('INSERT INTO theory (unit_id, title, link) VALUES ( :unitID , :title , :link );');
    $stmt->execute(array(
        'unitID' =>     $_POST['unitID'],
        'title'  =>     $_POST['title'],
        'link'   =>     $_POST['link']
    ));
    $theoryID = $db->lastInsertId();
} catch(PDOException $e) {
    echo json_encode($e->getMessage());
}

echo json_encode(array(
    'unitID'    =>  $_POST['unitID'],
    'title'     =>  $_POST['title'],
    'link'      =>  $_POST['link'],
    'theoryID'  =>  $theoryID
));
?>