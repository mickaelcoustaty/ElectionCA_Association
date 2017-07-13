<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<title>Resultats</title>
</head>
<body style="width:90%;margin:auto;">
<h1 class="jumbotron" style="text-align: center;">Math en Jeans - Vote pour l'election du Conseil d'Administration</h1>

<?php
	try
	{
		include '../bddAccess.php';
		
		echo '<table class="table table-striped">';
		// On affiche
		$Candidats = $bdd->query("SELECT nom FROM `MeJ_Candidats`");
		foreach  ($Candidats as $row)
		{
			echo "<tr>";
			echo "<th>".$row['nom']."</th>";
	        $reponse = $bdd->query("SELECT nbVote FROM `MeJ_Candidats` WHERE nom='".$row['nom']."'");
	        $vote = $reponse->fetch();
	        echo "<th>".$vote[0]."</th>";
	        echo "</tr>";
		}
		echo "</table>";
	}
	catch(Exception $e)
	{
	        die('Erreur : '.$e->getMessage());
	}
?>

<br/><br/><br/>
<p style="text-align: center;"><a href="index.php"><button type="button" class="btn">Retour à l'administration</button></a></p>
</body>
</html>