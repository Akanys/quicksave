<form method="post" action="">

    <legend>S'inscrire sur le site</legend>

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

<br/><br/><center><button type="submit" name="submit" class="btn btn-primary">S'Inscrire</button></center>
</form>

<?php
//Connexion à la BDD
try {
    $bdd = new PDO('mysql:host=localhost;dbname=quicksave', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
  
if(ISSET($_POST['submit'])){

  //On créer les variables
  $pseudo =   $_POST['pseudo'];
  $pass = $_POST['pass'];
  $pass = hash("sha256", $pass);

  $verif = $bdd->query("SELECT id FROM membres WHERE pseudo='$pseudo'");
  $verif = $verif->rowCount();
  
  if($verif == 1){
    ?>
    <b>Pseudo déjà utilisé !</b>
    <?php
  }
  else{
    $req = $bdd->prepare('INSERT INTO membres(pseudo, pass) VALUES (:pseudo, :pass)');

    $req->execute(array("pseudo" => $pseudo, "pass" => $pass));

    if(!empty($pseudo) && !empty($pass)){
      session_start();
      $_SESSION['pseudo'] = $_POST['pseudo'];
      header('Location: coucou.php');
    }
    else{
    ?>
    <b>Pseudo ou MDP vide !</b>
    <?php
    }
  }
}
?>