

<?php

require "setup.php";
 
// definis variables
$name = trim($_POST["name"]);
$surname = trim($_POST["surname"]);
$email = trim($_POST["email"]);
$isadmin= 0;
$school= trim($_POST["school"]);

$tourney1= trim($_POST["tourney1"]);
$tourney2= trim($_POST["tourney2"]);
$tourney3= trim($_POST["tourney3"]);

$maillist= trim($_POST["maillist"]);

$tourney1= isset($tourney1)? 1: 0;
$tourney1= isset($Tourney2)? 1: 0;
$tourney1= isset($tourney3)? 1: 0;
$maillist= isset($maillist)? 1: 0;
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

            // Preparation insertion
        $sql = "INSERT INTO pending_tourney_request  (name, surname, etablissement ,email , isadmin, tourney1, tourney2, tourney3, maillist) VALUES (:name, :surname, :school, :email, :isadmin, :tourney1, :tourney2, :tourney3, :maillist)";
   
        if($stmt = $pdo->prepare($sql)){
            // associer les variables aux parametres d'insertion
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":surname", $param_surname);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":school", $param_school);
            
	          $stmt->bindParam(":isadmin", $param_isadmin);
            $stmt->bindParam(":tourney1", $param_tourney1);
            $stmt->bindParam(":tourney2", $param_tourney2);
            $stmt->bindParam(":tourney3", $param_tourney3);
            $stmt->bindParam(":maillist", $param_maillist);

            $param_name = $name;
            $param_surname = $surname;
            $param_email = $email;
            $param_school= $school;

            $param_isadmin = intval($isadmin);
            $param_tourney1 = intval($tourney1);
            $param_tourney2 = intval($tourney2);
            $param_tourney3 = intval($tourney3);
            $param_maillist= $maillist;
       
            // execution 
            if($stmt->execute()){
                //si execution retour a la page de depart
                header("location: jointourney.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }  
        unset($stmt);
    unset($pdo);
}

$conn = null;
	
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
    
    <title>Les Fous des Tours</title>
  </head>


  <body class="heightJoin">

    
    

    <div class="container-fluid padded1">
      <div class="row">
         <div class="col-4">
          <button type="button" class="btn btn-primary"> <small> <a href="../php/login.php" class="font-italic lien2 text-center">Connexion<a> </small> </button>
         </div>
         <div class="col">
            <h1 class="text-left">Les Fous des Tours</h1>
            <img src="../images/logov2.png" width="50" height="auto" class="img-fluid rounded mx-auto d-block max float-center" alt="Responsive image" />
         </div>

      </div>
      <div class="col">
       
     </div>
    </div>
    
    

      <!--img src="../images/Logo_final_vect.svg" class="img-fluid  rounded mx-auto d-block" alt="Responsive image" /-->

    <hr/>
    <div class="container-fluid d-flex justify-content-center padded1">
        <div class="row">
         <div class="col-2">
           <a href="../html/homepagevar.html" class="font-italic lien1 text-center">Accueil </a>
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

  <div class="parallax blue"></div>
  
  <hr/>
    <div class="padded2">
      <div class="text-center " >
        <h3>Nous rejoindre:</h3>
        <hr/>
      </div>

      <div class="text-justify padded2">
        <p class="text-justify">
          Depuis cette page, vous pouvez vous inscrire aux différents tournois de l'association. Ou devenir membre de l'asso.
        </p>
      </div>

      <hr/>
      <br/>
      <small class="text-italic">
        vous êtes déjà inscrits? <a href="login.php">connectez vous ici<a>
      </small>


      

      <form class="form1" "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        <div class="form-group">
          <label for="exampleInputText">Nom</label>
          <input type="text" class="form-control form-check-input-tour" name="name" id="name" placeholder="Nom" required>
        </div>
        <div class="form-group">
          <label for="exampleInputText">Prénom</label>
          <input type="text" class="form-control form-check-input-tour" name="surname" id="surname" placeholder="Prénom" required>
        </div>
        <div class="form-group">
          <label for="exampleInputEtablissement">Remplacer pr listes de fac</label>
          <input type="text" class="form-control form-check-input-tour" id="school"  name="school" placeholder="Etablissement" required>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Mail</label>
          <input type="email" class="form-control form-check-input-tour" name="email" id="email" aria-describedby="emailHelp" placeholder="email@exemple.org" required>

        </div>

        <div class="form-check">
          <input type="checkbox" class="form-check-input-tour" value="1" name="tourney1" id="tourney1" >
          <label class="form-check-label form-check-input-tour" >S'inscrire au tournoi universitaire du S1</label>
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input-tour" value="1" name="tourney2" id="tourney2">
          <label class="form-check-label form-check-input-tour" >S'inscrire au tournoi universitaire du S2</label>
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input-tour" value="1" name="tourney3" id="tourney3">
          <label class="form-check-label form-check-input-tour" >S'inscrire au tournoi interfac</label>
        </div>
        <br/>
        <div class="form-check">
          <input type="checkbox" class="form-check-input-mail"  value="1" name="maillist" id="maillist" checked>
          <label class="form-check-label form-check-input-tour" >Recevoir les mails de l'assocation</label>
        </div>
        
        <br/>
        <button type="submit" class="btn btn-primary" value="submit"> <small> <div class="font-italic lien2 text-center">Valider<div> </small> </button>
        
      
    </form>

    	<div class="container-fluid d-flex justify-content-center padded1">
           <a href="https://www.helloasso.com/associations/les-fous-des-tours" class="font-italic lien1 text-left">S'inscrire à l'association </a>
        

    	</div>
    


    <br/>
  </body>

  
  <footer>
    <hr/>
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
