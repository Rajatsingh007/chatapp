<?php
if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $sourcePath = $_FILES['userImage']['tmp_name'];
        $ImageName = $_POST["imageName"];
        $targetPath = "images/" . $_POST["imageName"].".jpg";
        if (move_uploaded_file($sourcePath, $targetPath)) {
            echo "file uploaded";
        }else{
            echo "file Not uploaded";
        }
    }
}
?>