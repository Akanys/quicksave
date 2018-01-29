<form method="post" action="">

    <legend>Connexion au Panel</legend>

    <div class="form-group">
      <label class="col-lg-2 control-label">Login</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="pseudo" placeholder="Login">
      </div>
    </div><br/><br/><br/>

    <div class="form-group">
      <label class="col-lg-2 control-label">Mot de passe</label>
      <div class="col-lg-10">
        <input type="pass" class="form-control" name="pass" placeholder="Mot de passe">
      </div>
    </div>

<br/><br/><center><button type="submit" name="submit" class="btn btn-primary">Connexion</button></center>
</form>

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
  $pass = hash("sha256", $pass);

  // on recupére le pass de la table qui correspond au pseudo du visiteur
  $sql = $bdd->query("SELECT pass FROM membres WHERE pseudo='$pseudo'");
  
  while ($data = $sql->fetch())
  {

  if($data['pass'] != $pass) {
    echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">x</button>
  <strong>Oh Non !</strong> Mauvais pseudo / pass. Merci de recommencer !
</div>';
  }
  
  else {
    session_start();
    $_SESSION['pseudo'] = $pseudo;
    
    echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Yes !</strong> Vous etes bien logué, Redirection dans 5 secondes ! <meta http-equiv="refresh" content="5; URL=coucou.php">
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
