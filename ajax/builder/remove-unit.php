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
    //Get ID
    $stmt = $db->prepare('SELECT u.id FROM unit u WHERE u.name= :unitName ;');
    $stmt->execute(array(
        'unitName'  =>  $unitName
    ));
    $unitID = $stmt->fetch()[0];

    //Delete
    $stmt = $db->prepare('DELETE FROM unit WHERE name= :unitName ;');
    $stmt->execute(array(
        'unitName'  =>  $unitName
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
}

echo json_encode(array(
    'unitName'  =>  $unitName,
    'unitID'    =>  $unitID
));

?>