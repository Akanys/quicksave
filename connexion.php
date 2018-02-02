<!doctype html>
  <html lang="fr">
    <head>
      <meta charset="utf-8">
      <title>Quicksave</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet"> 
      <link rel="stylesheet" href="css/style.css">
      <script type="text/javascript" src="js/navbar.js"></script>
    </head>
    <body>
      <div id="container">
        <header>
          <div id="menu">
            <div class="topnav" id="myTopnav">
              <a href="index.php" class="active">Quick<span>Save</span></a>
              <a href="javascript:void(0);" style="font-size:18px;" class="icon" onclick="myFunction()">&#9776;</a>
             </div>
          </div>
        </header>
        <body>
          <form method="post" action="">
            <legend>Connexion au Panel</legend>
            <div class="id">
              <input class="nom" type="text" name="pseudo" placeholder="Identifiant">
              <input class="prenom" type="password" name="pass" placeholder="Mot de passe"><br>
              <button type="submit" name="submit" class="but3">Connexion</button>
            </div>
          </form>
        </body>
        <footer>
          <p>Copyright 2018. Tous droits réservés.</p>
          <a href="index.php"><img class="logof" src="images/logo.png" alt="logo"></a>
        </footer>
<?php
// on se connecte à MySQL 
try {
    $bdd = new PDO('mysql:host=localhost;dbname=quicksave', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

if(isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['pass'])) {
  $pseudo =   $_POST['pseudo'];
  $pass = $_POST['pass'];
  $pass = password_hash($pass, PASSWORD_DEFAULT);

  // on recupére le pass de la table qui correspond au pseudo du visiteur
  $sql = $bdd->query("SELECT pass FROM membres WHERE pseudo='$pseudo'");
  
  while ($data = $sql->fetch())
  {

  if($data['pass'] != $pass) {
    echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>Oh Non !</strong> Le pseudo ou mot de passe entré est incorrect. Merci de recommencer !
</div>';
  }
  
  else {
    session_start();
    $_SESSION['pseudo'] = $pseudo;
    
    echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Yes !</strong> Vous etes bien connecté, redirection dans 5 secondes ! <meta http-equiv="refresh" content="5; URL=accueil.php">
</div>';
    // ici vous pouvez afficher un lien pour renvoyer
    // vers la page d'accueil de votre espace membres 
  }
  }
  $sql->closeCursor();

}
else {
  $champs = '<p><b>(Remplissez tous les champs pour vous connectez !)</b></p>';
}


?>
