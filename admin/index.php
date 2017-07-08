<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <title>Administration Election CA Maths en Jeans</title>
</head>
<body style="width:90%;margin:auto;">
<h1 class="jumbotron" style="text-align: center;">Math en Jeans - Vote pour l'election du Conseil d'Administration</h1>

<?php
      try
      {
            $bdd = new PDO('mysql:host=localhost;dbname=idcndb;charset=utf8', 'idcn', 'idcnPWD');
            $nbVotantsQuery = $bdd->query("SELECT COUNT(`nom`) FROM `MeJ_Account`");
            $nbVotants = $nbVotantsQuery->fetch();
            $nbVoteExprimesQuery = $bdd->query("SELECT COUNT(`vote`) FROM `MeJ_Account` WHERE `vote` > 0 ");
            $nbVoteExprimes = $nbVoteExprimesQuery->fetch();
            echo '<div class="well" style="text-align: center;"><h3>'.$nbVoteExprimes[0].' / '.$nbVotants[0].' vote(s) exprimé(s)</h3></div>';
      }
      catch(Exception $e)
      {
              die('Erreur : '.$e->getMessage());
      }
?>

      <div class="col-md-4">
            <a href="generation.html"><h3>Generer les codes</h3></a>
      </div>

      <div class="col-md-4">
            <a href="resultat.php"><h3>Resultats</h3></a>
      </div>

      <div class="col-md-4">
            <a href="ajout.php"><h3>Insérer candidats</h3></a>
      </div>
   </div>

</body>
</html>