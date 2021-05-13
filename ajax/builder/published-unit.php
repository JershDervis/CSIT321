<?php
header("Content-Type: application/json", true);

/**
 *  Change a unit's publically available state. 
 */

require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if(!$user->isAdmin()) { // Check Admin
    header('Location: login.php');
    exit;
}
if(!isset($_POST['unit']) && empty($_POST['unit'])) { //Check Unit ID is set
    echo 'Invalid unit.';
    exit;
}

$unitID = $_POST['unit'];
$state = $_POST['newState']; //True, 1 = make public

//Update in the database
try {
    $stmt = $db->prepare('UPDATE unit SET published = :newState WHERE id = :unitID');
    $stmt->execute(array(
        'newState'  =>  $state,
        'unitID'    =>  $unitID
    ));
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>