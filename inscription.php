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
            <legend>S'inscrire sur le site</legend>
            <div class="id">
              <input class="nom" type="text" name="pseudo" placeholder="Identifiant">
              <input class="prenom" type="password" name="pass" placeholder="Mot de passe"><br>
            </div>
            <br>
            <div>
              <label class="col-lg-2 control-label">Observateur</label>
              <input type="radio" class="form-control" value="0" name="choice">
              <label class="col-lg-2 control-label">Intervenant</label>
              <input type="radio" class="form-control" value="1" name="choice">
            </div>
            <button type="submit" name="submit" class="but3">Inscription</button>
          </form>
        </body>
        <footer>
          <p>Copyright 2018. Tous droits réservés.</p>
          <a href="index.php"><img class="logof" src="images/logo.png" alt="logo"></a>
        </footer>

<?php
//Connexion à la BDD
try {

  $bdd = new PDO('mysql:host=localhost;dbname=quicksave', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

}

catch (PDOException $e) {

  print "Erreur !: " . $e->getMessage() . "<br/>";
  die();

}

if(ISSET($_POST['submit'])){

  //On créer les variables
  $pseudo =   $_POST['pseudo'];
  $intervenant =   $_POST['choice'];
  $pass = $_POST['pass'];
  $pass = password_hash($pass, PASSWORD_DEFAULT);
  $connectiontime = time();

  echo ($intervenant);
  $verif = $bdd->query("SELECT id FROM membres WHERE pseudo='$pseudo'");
  $verif = $verif->rowCount();
  if($verif == 1){

    ?>
    <b>Pseudo déjà utilisé !</b>
    <?php

  }
  else{

    $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, intervenant, connectiontime) VALUES (:pseudo, :pass, :intervenant, :connectiontime)');
    $req->execute(array("pseudo" => $pseudo, "pass" => $pass, "intervenant" => $intervenant, "connectiontime"=> $connectiontime));

    if(!empty($pseudo) && !empty($pass)){

      session_start();
      $_SESSION['pseudo'] = $_POST['pseudo'];
      header('Location: accueil.php');

    }

    else{

    ?>
    <b>Pseudo ou MDP vide !</b>
    <?php
    
    }
  }
}
?>