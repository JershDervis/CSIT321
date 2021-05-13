<?php
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_POST['name']) && empty($_POST['name'])) { //Check Unit Name is set
    echo 'Invalid unit.';
    exit;
}

$unitName = $_POST['name'];
$unitID = -1;

//Update in the database
try {
    $stmt = $db->prepare('INSERT INTO unit (name) VALUES ( :unitName );');
    $stmt->execute(array(
        'unitName'  =>  $unitName
    ));
    $unitID = $db->lastInsertId();
} catch(PDOException $e) {
    echo $e->getMessage();
}

echo json_encode(array(
    'unitName'  =>  $unitName,
    'unitID'    =>  $unitID
));

?>