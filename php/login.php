<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "../php/setup.php";
 
// Define variables and initialize with empty values
$name = $password = "";
$name_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if name is empty
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($name_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT isadmin, name, adminpasswd FROM pending_tourney_request WHERE adminpasswd = :password";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
           // $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            $param_password = trim($_POST["password"]);
            
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if name exists, if yes then verify password
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //checks that user trying to connect entered the correct name n is an admin
                if( ($param_name != $row["name"] && ($row["isadmin"]!=1))){
                    echo "Oops! Something went wrong. Please try again later.";
                }
                if($stmt->rowCount() == 1){
                    
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;                            
                        
                } else{
                    // name doesn't exist, display a generic error message
                    $login_err = "Invalid name or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);

    header("location: index.php");
    exit;
}
?>


 <!doctype html>
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

</head>

<body class="login">
    <div class="container-fluid justify-content-center">
      <div class="row">
         <div class="col-4">
          <button type="button" class="btn btn-primary"> <small> <a href="login.php" class="font-italic lien2 text-center">Connexion<a> </small> </button>
         </div>
         <div class="col">
            <h1 class="text-left">Les Fous des Tours</h1>
           <img src="../images/logov2.png" width="50" height="auto" class="img-fluid rounded mx-auto d-block max" alt="Responsive image" />
         </div>

      </div>
    </div>



    <br/>

    <hr/>
    <div class="container-fluid justify-content-center d-flex">
        <div class="row">
         <div class="col-2">
           <a href="../html/homepagevar.html" class="font-italic lien1">Accueil </a>
         </div>
         <div class="col">
           <a href="../html/informationsvar.html" class="font-italic lien1">Informations </a>
         </div>
         <div class="col">
             <a href="jointourney.php" class="font-italic lien1">Rejoindre </a>
         </div>
         <div class="col">
           <a href="../html/actualitesvar.html" class="font-italic lien1">Actualites</a>
        </div>
        <div class="col">
           <a href="../html/playvar.html" class="font-italic lien1">Jouez </a>
         </div>

        </div>
        
     </div>
     <hr/>


      <h3>Se Connecter:</h3>

      <small class="text-italic">
        vous n'êtes pas inscrits? <a href="jointourney.php">inscrivez-vous ici<a>
      </small>
      <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
      <div class="form-group">
        <label >Entrez votre nom d'utilisateur</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Entrer nom d'utilisateur">

      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Entrez votre mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de Passe">
      </div>
      <br/>
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>


</body>
  <hr/>
  <footer>
 <div class="d-flex justify-content-center container-fluid">.


        <div class="row">
         <div class="col">
           <a href="https://www.instagram.com/lesfousdestours/" target= "_blank"  class=lien1><i class="fa-brands fa-instagram icone1"></i></a>
         </div>
         <div class="col">
           <a href="https://discord.gg/abBp6pv3mG" target= "_blank"  class=lien1><i class="fa-brands fa-discord icone1"></i></a>
         </div>
         <div class="col">
           <a href="https://web.whatsapp.com/" target= "_blank"  class=lien1><i class="fa-brands fa-whatsapp icone1"></i></a>
         </div>
         <div class="col">
           <a href="https://web.whatsapp.com/" target= "_blank"  class=lien1><i class="fa-brands fa-facebook icone1"></i></a>
         </div>


       </div>

  </div>
  </footer>
</html>
