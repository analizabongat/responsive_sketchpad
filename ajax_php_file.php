<?php
//print_r($_FILES);
$sourcePath = $_FILES['image']['tmp_name'];       // Storing source path of the file in a variable
$targetPath = "uploads/".$_FILES['image']['name']; // Target path where file is to be stored
move_uploaded_file($sourcePath,$targetPath) ;    // Moving Uploaded file
echo $_FILES['image']['name'];
?>