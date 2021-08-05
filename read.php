<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $dat = $row["dat"];
                $name = $row["name"];
                $address = $row["address"];
                $diag = $row["diag"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="main.css">
    
</head>
<header><center><img src="logogbt.png"></center></header>
<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div>
                        <label>Date</label>
                        <p id="dat"><?php echo $row["dat"]; ?></p>
                    </div>
                    <div>
                        <label>Nom</label>
                        <p id="nom"><?php echo $row["name"]; ?></p>
                    </div>
                    <div>
                        <label>Contact</label>
                        <p id="lname"><?php echo $row["address"]; ?></p>
                    </div>
                    <div>
                        <label>Diagnostique</label>
                        <p id="txt_area"><?php echo $row["diag"]; ?></p>
                    </div>
                    <p><a href="index.php" id="button">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>