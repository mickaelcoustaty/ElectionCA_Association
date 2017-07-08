<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<title>Ajout candidats au CA</title>
</head>
<body style="width:90%;margin:auto;">
<h1 class="jumbotron" style="text-align: center;">Math en Jeans - Vote pour l'election du Conseil d'Administration</h1>

<form method="post" action="candidats.php" enctype="multipart/form-data">
     <label for="mon_fichier">Fichier (format CSV) :</label><br />
     <input type="file" name="csvFile" id="mon_fichier" /><br /><br />

<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=idcndb;charset=utf8', 'idcn', 'idcnPWD');

		// On vide la table car on va la reremplir avec les nouveaux ID
		$reponse = $bdd->query("SELECT nbCandidats FROM `MeJ_admin`");
		$nbCandidats = $reponse->fetch();
		echo '<label for="nbMandats">Nombre de mandats à renouveler :</label>';
		echo '<input type="text" name="nbMandats" value="'.intval($nbCandidats["nbCandidats"]).'"><br><br>';
	}
	catch(Exception $e)
	{
	        die('Erreur : '.$e->getMessage());
	}
?>

     <input type="submit" name="submit" value="Envoyer" />
</form>

<br/><br/><br/>
<p style="text-align: center;"><a href="index.php"><button type="button" class="btn">Retour à l'administration</button></a></p>
</body>
</html>