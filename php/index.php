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
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Manage pending request</h2>
                        <button type="button" class="btn btn-primary float-right"> <small><a href="jointourney.php" class="font-italic lien2 text-center">Create a Request</a></small> </button>
                    </div>
                    <?php
                    // Include config file
                    require "setup.php";

                    $cpt=0;
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM pending_tourney_request";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Surname</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>ID</th>";
                                        echo "<th>isadmin</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $cpt++ ."</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['surname'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['pendingID'] . "</td>";
                                        echo "<td>" . $row['isadmin'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['pendingID'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['pendingID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['pendingID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo '<a href="confirm.php?id='. $row['pendingID'] .'" title="Confirm Record" data-toggle="tooltip"><span class="fas fa-check"></span></a>';
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    
                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>        
        </div>
        <button type="button" class="btn btn-primary float-center"> <small><a href="../html/homepagevar.html" class="font-italic lien2 text-center">Back</a></small> </button>
    </div>
</body>
</html>
