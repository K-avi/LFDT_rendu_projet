<?php
session_start();

if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
  
  header("location: ../html/homepagevar.html");
  exit;
}

if(isset($_POST["id"]) && !empty($_POST["id"])){
    require_once "setup.php";
    
    // Prepare a delete statement n an update statement

    
    $sql_ret = "SELECT * FROM pending_tourney_request WHERE pendingID = :id";
   
    $sql_inscrit= "INSERT INTO inscrits (name, surname ,email , etablissement, maillist, ID, isadmin) VALUES (:name, :surname, :email, :school, :maillist ,:id, :isadmin)";
    

    $sql_d = "DELETE FROM pending_tourney_request WHERE pendingID = :id";


    if($stmt = $pdo->prepare($sql_ret)){
    
        $stmt->bindParam(":id", $param_id);
    
        $param_id = trim($_POST["id"]);

        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              
                $name = $row["name"];
                $surname = $row["surname"];
                $email = $row["email"];
                $school= $row["etablissement"];
                $maillist= $row["maillist"];
                $isadmin= $row["isadmin"];

                $tourney1= $row["tourney1"];
                $tourney2= $row["tourney2"];
                $tourney3= $row["tourney3"];

                

                if($stmt1 = $pdo->prepare($sql_inscrit)){
                    // associe variables a parametres
                    $stmt1->bindParam(":name", $param_name);
                    $stmt1->bindParam(":surname", $param_surname);
                    $stmt1->bindParam(":email", $param_email);
                    $stmt1->bindParam(":school", $param_school);
                    
                    $stmt1->bindParam(":isadmin", $param_isadmin);
                    $stmt1->bindParam(":maillist", $param_maillist);

                    $param_name = $name;
                    $param_surname = $surname;
                    $param_email = $email;
                    $param_school= $school;

                    $param_isadmin = intval($isadmin);
                    $param_maillist= $maillist;
                    $stmt1->bindParam(":id", $param_id);

            
                  
                    if($stmt1->execute()){
                        echo "done inserting into 'inscrits'!";

                    }else{
                        echo "error while adding to inscrits";
                        exit();
                    }
                    
                
                }else{
                    
                    exit();
                }


                if( $tourney1 || $tourney2 || $tourney3 ){
                    //comme il n'y a que 3 tournois; on suppose qu'on connait leurs ID et que ces ID sont 1, 2 et 3

                    if($tourney1==1){
                        $sql_tourneys_inscrits= "INSERT INTO tourneys_inscrits  (inscrit_id, tourney_id) VALUES (:id, :tournid)";
                        if($stmt2 = $pdo->prepare($sql_tourneys_inscrits)){
                            // Bind variables to the prepared statement as parameters
                            $stmt2->bindParam(":id", $param_id);
                            $stmt2->bindParam(":tournid", $param_t1_id);

                            $param_t1_id=1;
                            if($stmt2->execute()){
                                echo "done inserting t1 to tourneys_inscrits";
                            }
                        }
                        unset($stmt2);
                    }

                    if($tourney2==1){
                        $sql_tourneys_inscrits= "INSERT INTO tourneys_inscrits  (inscrit_id, tourney_id) VALUES (:id, :tournid)";
                        if($stmt3=$pdo->prepare($sql_tourneys_inscrits)){
                            // Bind variables to the prepared statement as parameters
                            $stmt3->bindParam(":id", $param_id);
                            $stmt3->bindParam(":tournid", $param_t2_id);

                            $param_t2_id=2;
                            if($stmt3->execute()){
                                echo "done inserting t2 to tourneys_inscrits";
                            }
                        }
                        unset($stmt3);
                    }

                    if($tourney3==1){
                        $sql_tourneys_inscrits= "INSERT INTO tourneys_inscrits  (inscrit_id, tourney_id) VALUES (:id, :tournid)";
                        if($stmt4 = $pdo->prepare($sql_tourneys_inscrits)){
                            // Bind variables to the prepared statement as parameters
                            $stmt4->bindParam(":id", $param_id);
                            $stmt4->bindParam(":tournid", $param_t3_id);

                            $param_t3_id=3;
                            if($stmt4->execute()){
                                echo "done inserting t3 to tourneys_inscrits";
                            }
                        }
                        unset($stmt4);
                    }

                }
                if($stmt5 = $pdo->prepare($sql_d)){ //this statement is disabled atm and not tested bc u might want to keep 
                    //the entrys in the tmp database for a while even if u confirmed them
                    // Bind variables to the prepared statement as parameters
                    /*$stmt->bindParam(":id", $param_id);
                    
                    // Set parameters
                    $param_id = trim($_POST["id"]);
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Records deleted successfully. Redirect to landing page
                        header("location: index.php");
                        exit();
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }*/
                    unset($stmt5);
                
                } 
                unset($stmt1);
            }
        }

    }
    
    unset($stmt);
    unset($pdo);
    

} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->

    <link rel="stylesheet" href="../css/styles_var.css" />

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <!--awesome fonts -->
    <script src="https://kit.fontawesome.com/f3e9265dae.js" crossorigin="anonymous"></script>

    <!-- JS to treat the form-->

    <script src="../javascript/formcheck.js"></script>

    <title>CRUD delete</title>
  </head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Confirm Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to confirm this pending request?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>