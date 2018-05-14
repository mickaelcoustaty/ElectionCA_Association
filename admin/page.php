<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<title>page.php</title>
</head>
<body style="width:90%;margin:auto;">
<h1 class="jumbotron" style="text-align: center;">Math en Jeans - Vote pour l'election du Conseil d'Administration</h1>
<?php
	try
	{
		include '../bddAccess.php';

		// On vide la table car on va la reremplir avec les nouveaux ID
		$bdd->exec("TRUNCATE TABLE MeJ_Account");

		// On verifie que le fichier a bien ete uploade
		if ($_FILES['csvFile']['error'] > 0) $erreur = "Erreur lors du transfert";
		// ensuite on verifie que c'est bien un fichier csv
		$extensions_valides = array( 'csv' );
		//1. strrchr renvoie l'extension avec le point (« . »).
		//2. substr(chaine,1) ignore le premier caractère de chaine.
		//3. strtolower met l'extension en minuscules.
		$extension_upload = strtolower(  substr(  strrchr($_FILES['csvFile']['name'], '.')  ,1)  );
		
		if ( in_array($extension_upload,$extensions_valides) )
		{
			// on deplace le fichier pour le lire
			$filename = "toEncode.csv";
			$resultat = move_uploaded_file($_FILES['csvFile']['tmp_name'],$filename);
			if ($resultat)
			{
				//echo "<p>Transfert réussi</p>";
				$row = 1;
				if (($handle = fopen($filename, "r")) !== FALSE)
				{
				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				    {
				        $num = count($data);
				        $row++;
				        $password = hash("sha256", $data[0].$_POST['cle']);
						
						$loginToAdd = $data[0];
						$passwordToAdd = substr($password, 0, 8);
						$emailToAdd = $data[1];
				        // On ajoute une entrée dans la table MeJ_Account
						$bdd->exec("INSERT INTO `MeJ_Account` (`id`, `nom`, `code`, `mail`, `vote`) VALUES (NULL, '".$loginToAdd."', '".$passwordToAdd."', '".$emailToAdd."', ". 0 .")");
						
						//// Pour l'envoi du mail
						
						// Pour
						$to = $emailToAdd;
						// Sujet
						$subject = 'Votre compte pour le vote au CA de l\'association';
						// message
						$message = '
						<html>
						 <head>
						  <title>Association Math en Jeans</title>
						  <meta charset="UTF-8">
						 </head>
						 <body>
						  <p>Voici vos informations de connexion pour le vote de 2018 !</p>
						  <table>
							<tr>
								<th>Identifiant</th><th>Mot de passe</th>
							</tr>
							<tr>
								<td>'.$loginToAdd.'</td><td>'.$passwordToAdd.'</td>
							</tr>
						  </table>
						 </body>
						</html>
						';

						$headers = 'From: Gilles@email.com' . "\r\n" . 'Reply-To: Gilles@email.com' . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1';
						 
						$retourMail = mail($to, $subject, $message, $headers);
						
						echo "<br>mail envoyé à ".$emailToAdd;
					}
				}
			}
			echo "<br><br>";
			// Et on les affiche
			$reponse = $bdd->query("SELECT * FROM `MeJ_Account`");
			foreach  ($reponse as $row)
			{
		        print $row['nom'] . "," . $row['code'] . "<br/>";
  			}
		}
		else
			echo "<p>Erreur extension de fichier</p>";

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