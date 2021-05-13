<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/config.php');

if (empty($_FILES['image']))
    throw new Exception('Image file is missing');

$img = $_FILES['image'];
$tmpImgName = $img['tmp_name'];
$userImgName = $img['name'];

$maxFileSize = 2 * 10e6; // = 2 000 000 bytes = 2MB
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

/** 
 * The following checks are for security purposes
 * Credit to: https://stackoverflow.com/a/52761262
 */
if ($img['error'] !== 0) {
    if ($img['error'] === 1) 
        throw new Exception('Max upload size exceeded');
    throw new Exception('Image uploading error: INI Error');
}
if (!file_exists($img['tmp_name']))
    throw new Exception('Image file is missing in the server');

if ($img['size'] > $maxFileSize)
    throw new Exception('Max size limit exceeded'); 

$imageData = getimagesize($img['tmp_name']);
if (!$imageData) 
    throw new Exception('Invalid image');

$mimeType = $imageData['mime'];
if (!in_array($mimeType, $allowedMimeTypes)) 
    throw new Exception('Only JPEG, PNG and GIFs are allowed');

//If nothing thrown then continue with upload
$ext = pathinfo($userImgName, PATHINFO_EXTENSION);
$uniqueFileName = uniqid(rand(), true) . '.' . $ext;

if(move_uploaded_file($tmpImgName, FILES . $uniqueFileName)) {
    //Update in the database
    try {
        $stmt = $db->prepare('INSERT INTO files(file_name, loc_name) VALUES ( :fName , :lName);');
        $stmt->execute(array(
            'fName'  =>  $userImgName,
            'lName'  =>  $uniqueFileName
        ));
        $fileID = $db->lastInsertId();
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

    $data = array(
        'id'        =>  $fileID,
        'file_name' =>  $userImgName,
        'loc_name'  =>  $uniqueFileName,
        'log'       =>  'Uploaded file: ' . $userImgName
    );
} else {
    throw new Exception('Unable to move uploaded file');
}

header('Content-Type: application/json');
echo json_encode($data);


?>