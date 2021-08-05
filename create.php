<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$dat = $name = $address = $diag = "";
$dat_err = $name_err = $address_err = $diag_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    $input_dat = trim($_POST["dat"]);
    $dat = $input_dat;
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_diag = trim($_POST["diag"]);
    $diag = $input_diag;

    
    // Check input errors before inserting in database
    if(empty($dat_err) && empty($name_err) && empty($address_err) && empty($diag_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (dat, name, address, diag) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_dat, $param_name, $param_address, $param_diag);
            
            // Set parameters
            $param_dat = $dat;
            $param_name = $name;
            $param_address = $address;
            $param_diag = $diag;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="main.css">

    
    
    
    
</head>
<header><center><img src="logogbt.png"></center></header>

<body>
<nav class="navbar navbar-expand-lg navbar-ligt">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" arial-label="Toggle navigation">
					<span class="navbar-collapse-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="HOME/home.html"><b>HOME<b></a>
						</li>
					</ul>
				</div>
			</nav>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1><b>Client Record</b></h1>
                    </div> 
                    <p><h2><b>Enregistrez le client</b></h2></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label><b>Date d'entree</b></label><br>
                        <input type="date" name="dat" id="dat" value="<?php echo $dat; ?>">
                        <span class="help-block"><?php echo $dat_err;?></span>
                        </div> <br> 
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label><b>Nom</b></label>
                            <input type="text" name="name" id="nom" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div> <br>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label style="width: 450px;"><b>Contact</b></label>
                            <input type="text" name="address" id="lname" style ><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div> <br>
                        <div class="form-group <?php echo (!empty($diag_err)) ? 'has-error' : ''; ?>">
                            <label>Diagnostique</label>
                            <textarea rows="10" cols="80" name="diag" id="txt_area" value="<?php echo $diag; ?>"></textarea>
                            <span class="help-block"><?php echo $diag_err;?></span>
                        </div> <br>
                        <input type="submit" class="btn btn-primary" value="Submit" id="button">
                        <a href="index.php" type="submit" class="btn btn-default" id="button">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    
</body>

</html>