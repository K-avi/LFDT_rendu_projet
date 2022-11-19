
<?php



session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  
  header("location: ../html/homepagevar.html");
  exit;
}

//verifie que l'id existe
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require "setup.php";
    
    $sql = "SELECT * FROM pending_tourney_request WHERE pendingID = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              
                $name = $row["name"];
                $surname = $row["surname"];
                $email = $row["email"];
            } else{
                
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    //header("location: error.php");
    exit();
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name :</label>
                        <b><?php echo $row["name"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Surname :</label>
                        <b><?php echo $row["surname"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Etablissement :</label>
                        <b><?php echo $row["etablissement"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <b><?php echo $row["email"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Isadmin :</label>
                        <b><?php echo $row["isadmin"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Tourney1 :</label>
                        <b><?php echo $row["tourney1"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Tourney2 :</label>
                        <b><?php echo $row["tourney2"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Tourney3 :</label>
                        <b><?php echo $row["tourney3"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>Maillist :</label>
                        <b><?php echo $row["maillist"]; ?></b>
                    </div>
                    <div class="form-group">
                        <label>ID :</label>
                        <b><?php echo $row["pendingID"]; ?></b>
                    </div>
                   
                    <button type="button" class="btn btn-primary float-center"> <small><a href="index.php" class="font-italic lien2 text-center">Back</a></small> </button>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>