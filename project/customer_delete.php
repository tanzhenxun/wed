<?php
// include database connection
include 'config/database.php';
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id = isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    $query_order_list = "SELECT * FROM order_summary WHERE customer_id = ?";
    $stmt_order_list = $con->prepare($query_order_list);
    $stmt_order_list->bindParam(1, $id);
    $stmt_order_list->execute();
    $num = $stmt_order_list->rowCount();
    if ($num > 0) {
        header('Location: customer_read.php?action=cancel');
    } else {
        try {
            // delete query
            $query = "DELETE FROM customers WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
            
            if($stmt->execute()){
                // redirect to read records page and
                // tell the user record was deleted
                header('Location: customer_read.php?action=deleted');
            }else{
                die('Unable to delete record.');
            }
        }
        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }
?>