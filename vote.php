<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<title>Vote</title>
</head>
<body style="width:80%;margin:auto;">
<h1 class="jumbotron">Math en Jeans - Vote pour l'election du Conseil d'Administration</h1>
<!--<div class="row" style="margin:'auto'; width:'90%';">-->
<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=idcndb;charset=utf8', 'idcn', 'idcnPWD');

		// Si le formulaire est rempli, on enregistre le vote
		if (!empty($_POST))
		{
			// On teste si ce code existe ou a deja vote
			$reponse = $bdd->query("SELECT code,vote FROM `MeJ_Account` WHERE code='".$_POST['Code']."'");
			$vote = $reponse->fetch();
			// Si le code est invalide
			if ($vote['code']!=$_POST['Code'] || $_POST['Code']=="")
				echo '<p style="color:red">Votre code n\'existe pas !</p>';
			// Sinon on vote
			else
			{
				// Si la personne n'a pas deja vote
				if ($vote['vote'] == 0)
				{
					// Si la personne n'a pas coché plus de cases que le nombre maxi prevu pour le vote
					$queryNbCandidats = $bdd->query("SELECT nbCandidats FROM `MeJ_admin`");
					$nbCandidats = $queryNbCandidats->fetch();
					if ((sizeof($_POST)-1) <= intval($nbCandidats["nbCandidats"]))
					//if ($nbVoteSaisis <= intval($nbCandidats["nbCandidats"]))
					{
						// Et on met a jour la table des votants pour eviter le double vote
						$bdd->exec("UPDATE `MeJ_Account` SET vote = 1 WHERE code='".$_POST['Code']."'");
						echo '<p style="color:red">Votre vote a ete pris en compte, merci !</p>';

						$Candidats = $bdd->query("SELECT id,nom FROM `MeJ_Candidats`");
						foreach  ($Candidats as $row)
						{
							if ($_POST[$row["id"]])
							{
								$queryNbVoteExistant = $bdd->query("SELECT nbVote FROM `MeJ_Candidats` WHERE id=".$row["id"]);
								$nbVoteExistant=$queryNbVoteExistant->fetch();
								$test = intval($nbVoteExistant["nbVote"]);
								$bdd->exec("UPDATE `MeJ_Candidats` SET nbVote = ".intval($test+1)." WHERE id='".$row["id"]."'");
								$nbVoteSaisis = $nbVoteSaisis + 1;
							}
						}
					}
					else
					{
						echo '<p style="color:red">Vous avez coché '.(sizeof($_POST)-1).' cases alors que le nombre maximum de votes est de '.$nbCandidats["nbCandidats"].', merci de réessayer !</p>';
					}
				}
				else
				{
					echo '<p style="color:red">Vous avez deja vote</p>';
				}
			}
		}
		// Sinon on affiche le formulaire
		else
		{
			echo '<div class="container">';
			echo '<form action="vote.php" method="post" name="listeCandidats" style="text-align:left;">Code :<input type="text" name="Code"><br/><br/>';
			//echo '<form action="vote.php" method="post">';
			$Candidats = $bdd->query("SELECT id,nom FROM `MeJ_Candidats`");
			foreach  ($Candidats as $row)
			{
				echo '<div class="checkbox"><label><input type="checkbox" name="'.$row["id"].'">"'.$row["nom"].'"</label></div>';
			}
			echo '<br/><br/><input type="submit" value="Voter"></form></div>';
		}
	}
	catch(Exception $e)
	{
	        die('Erreur : '.$e->getMessage());
	}
?>

<!--</div>-->
</body>
</html>