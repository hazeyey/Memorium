<?php
include 'db/db.php';

include 'db/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $check = "SELECT * FROM deceased WHERE grave_id = '$id' AND deleted_at IS NULL";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        header("Location: index.php?status=deleteGraveFailed"); 
        exit();
    } else {
       
        $sql = "UPDATE graves SET deleted_at = NOW() WHERE grave_id = '$id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?status=deleteGraveSuccess"); 
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

?>
