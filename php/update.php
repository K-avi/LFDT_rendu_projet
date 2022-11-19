
<?php


session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  
  header("location: ../html/homepagevar.html");
  exit;
}

require_once "setup.php";
 
// Define variables and initialize with empty values
$name = $surname = $email = $school ="";
$tourney1 = $tourney2 = $tourney3= $maillist= 0;

$name_err= $surname_err = $email_err = $tourney1_err = $tourney2_err = $tourney3_err = $maillist_err = $school_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
        echo "namerr";
    } else{
        $name = $input_name;
    }
    
    // Validate surname 
    $input_surname = trim($_POST["surname"]);
  
    if(empty($input_surname)){
        $surname_err = "Please enter a surname.";   
        echo "surerr";  
    } else{
        $surname = $input_surname;
    }

    // Validate school 
    $input_school = trim($_POST["school"]);
   // echo trim($_POST["school"]);
    if(empty($input_school)){
        $school_err = "Please enter a school.";   
        echo "scherr";  
    } else{
        $school = $input_school;
    }
    
    
    //validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email"; 
        echo "emailerr";    
    }else{
        $email = $input_email;
    }


    $input_tourney1=$input_tourney2=$input_tourney3=$input_maillist=-1;

    $input_tourney1= intval(trim($_POST["tourney1"]));
    echo trim($_POST["tourney1"]);
    if( $input_tourney1==1){
        $tourney1_err = "errrrr";
        echo "t1err ";
    }else{
        $tourney1 = $input_tourney1;
    }

    $input_tourney2= intval(trim($_POST["tourney2"]));
    if( $input_tourney2 ==-1){
        $tourney2_err = "errrrr";
        echo "t2err ";
    }else{
        $tourney2 = $input_tourney2;
    }

    $input_tourney3= intval(trim($_POST["tourney3"]));
    if($input_tourney3 ==-1){
        $tourney3_err = "errrrr";
        echo "t3err ";
    }else{
        $tourney3= $input_tourney3;
    }

    $input_maillist= intval(trim($_POST["maillist"]));
    if( $input_maillist ==-1){
        $maillist_err= "err"; 
        echo "mlerr ";  
    }else{
        $maillist= $input_maillist;
    }

    
    if( empty($name_err) && empty($surname_err) && empty($email_err) && empty($tourney1_err) && empty($tourney2_err) && empty($tourney3_err) && empty($maillist_err) && empty($school_err)){
        // Prepare an update statement
        $sql = "UPDATE pending_tourney_request SET name=:name, surname=:surname, email=:email, etablissement=:school,tourney1=:tourney1, tourney2=:tourney2,tourney3=:tourney3, maillist=:maillist WHERE pendingID=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":surname", $param_surname);
            $stmt->bindParam(":school", $param_school);
            $stmt->bindParam(":email", $param_email);


            $stmt->bindParam(":tourney1", $param_tourney1);
            $stmt->bindParam(":tourney2", $param_tourney2);
            $stmt->bindParam(":tourney3", $param_tourney3);
            $stmt->bindParam(":maillist", $param_maillist);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_surname = $surname;
            $param_email = $email;
            $param_school = $school;

            $param_tourney1= $tourney1;
            $param_tourney2= $tourney2;
            $param_tourney3= $tourney3;
            $param_maillist = $maillist;

            $param_id=$id;
         
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM pending_tourney_request WHERE pendingID = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $name = $row["name"];
                    $address = $row["surname"];
                    $salary = $row["email"];


                    $tourney1 = $row["tourney1"];
                    $tourney2 = $row["tourney2"];
                    $tourney3 = $row["tourney3"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>CRUD INDEX</title>

    <!-- bootstap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- custom css-->

    <link rel="stylesheet" href="../css/styles_var.css" />

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

     <!--awesome fonts -->
     <script src="https://kit.fontawesome.com/f3e9265dae.js" crossorigin="anonymous"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the pending tourney request.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>School</label>
                            <input type="text" name="school" class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                            <span class="invalid-feedback"></span>
                        </div>
                      
                        <div class="form-radio">
                           
                            <label class="form-check-label" >inscrit au premier tournoi</label>

                            <input type="radio" id="tourney1y"
                            name="tourney1" value="1">
                            <label for="tourney1y">oui</label>

                            <input type="radio" id="tourney1n"
                            name="tourney1" value="0">
                            <label for="tourney1n">non</label>

                        <div class="form-radio">
                           
                            <label class="form-check-label" >inscrit au 2e tournoi</label>

                            <input type="radio" id="tourney2y"
                            name="tourney2" value="1">
                            <label for="tourney2y">oui</label>

                            <input type="radio" id="tourney2n"
                            name="tourney2" value="0">
                            <label for="tourney2n">non</label>

                        </div>
                        <div class="form-radio">
                           
                            <label class="form-check-label" >inscrit au 3e tournoi</label>

                            <input type="radio" id="tourney3y"
                            name="tourney3" value="1">
                            <label for="tourney3y">oui</label>

                            <input type="radio" id="tourney3n"
                            name="tourney3" value="0">
                            <label for="tourney3n">non</label>

                        </div>
                            <br/>
                            <div class="form-radio">
                           
                           <label class="form-check-label" >inscrit a la mail list </label>

                           <input type="radio" id="maillisty"
                           name="maillist" value="1">
                           <label for="maillisty">oui</label>

                           <input type="radio" id="maillist"
                           name="maillist" value="0">
                           <label for="maillistn">non</label>

                       </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>