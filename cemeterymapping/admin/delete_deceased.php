<?php   
include 'db/db.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']); 

   
    $get_grave = "SELECT grave_id FROM deceased WHERE deceased_id = '$id' AND deleted_at IS NULL";
    $result = $conn->query($get_grave);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $grave_id = $row['grave_id'];

        
        $sql_deceased = "UPDATE deceased SET deleted_at = NOW() WHERE deceased_id = '$id'";
        if ($conn->query($sql_deceased) === TRUE) {

          
            $sql_update_grave = "UPDATE graves SET status = 'available' WHERE grave_id = '$grave_id'";
            if ($conn->query($sql_update_grave) === TRUE) {
                header("Location: admin.php?status=deleteDeceasedSuccess"); 
                exit();
            } else {
                echo "Error updating grave status: " . $conn->error;
            }

        } else {
            echo "Error deleting deceased record: " . $conn->error;
        }
    } else {
        echo "Error: Deceased record not found or already deleted.";
    }
}
?>
