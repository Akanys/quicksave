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
              <a href="index.php" class="espace active">Quick<span>Save</span></a>
              <a href="#presentation">Présentation</a>
              <a href="#localisation">Géolocalisation</a>
              <a href="#contact">Contact</a>
              <a href="javascript:void(0);" style="font-size:18px;" class="icon" onclick="myFunction()">&#9776;</a>
             </div>
          </div>
        </header>
        <section id="tarif">
          <div>
            <h1>QuickSave vous donne la possiblité de venir en aide et de sauver une vie.</h1>
          </div>
          <div id="bouton">
            <a href="inscription.php"><input class="but1" type="button" value="S'inscrire"></a>
           <a href="connexion.php"><input class="but2" type="button" value="Se connecter"></a>
          </div>
        </section>
        <section id="presentation">
          <div class="presente">
            <div class="p1">
              <img class="imagep" src="images/efficace.png" alt="">
              <h3>Efficacité !</h3>
                <p>Localisation des défibrillateurs et des pharmacies les plus proches en cas d’urgences.</p>
            </div>
            <div class="p2">
              <img class="imagep" src="images/rapide.png" alt="">
              <h3>Rapidité !</h3>
              <p>Localisation des membres formés aux gestes de premiers secours dans le périmètre.</p>
            </div>
            <div class="p3">
              <img class="imagep" src="images/rejoins.png" alt="">
              <h3>Rejoignez-nous !</h3>
              <p>Sauvez votre prochain en apprenants dès maintenant les gestes qui<br>
                sauvent.</p>
            </div>
          </div>
        </section>
        <section id="map">
          <h2>Localisez rapidemment le défibrillateur et la pharmacie en cas d’urgence.</h2>
          <script>
             var latitude = [];
             var longitude = [];
             var latitude2 = [];
             var longitude2 = [];
             var latitude3 = [];
             var longitude3 = []; 
             var membresco = []; 
          </script>

          <?php
          include('traitement.php');
          foreach ($donnees as $key => $donnee) {
              $separation = explode(', ', $donnee['GeoPoint']);
              $latitude = $separation [0];
              $longitude = $separation [1];
              echo "<script>latitude.push('".$latitude."')</script>";
              echo "<script>longitude.push('".$longitude."')</script>";
            }
          foreach ($donnees2 as $key => $donnee2) {
            $separation2 = explode(', ', $donnee2['geo_point']);
            $latitude2 = $separation2 [0];
            $longitude2 = $separation2 [1];
            echo "<script>latitude2.push('".$latitude2."')</script>";
            echo "<script>longitude2.push('".$longitude2."')</script>";
            }
          foreach ($donnees3 as $key => $donnee3) {
            $separation3 = explode(', ', $donnee3['coordonnees']);
            $latitude3 = $separation3 [0];
            @ $longitude3 = $separation3 [1];
            echo "<script>latitude3.push('".$latitude3."')</script>";
            echo "<script>longitude3.push('".$longitude3."')</script>";
            }
            foreach ($membresco as $key => $membre) {

              $veriftime = $membre['connectiontime'] + 30000;
  
              $actualtime = time();
  
              $pseudo = $membre['pseudo'];
  
              if($veriftime >= $actualtime){
  
              echo "<script>membresco.push('".$pseudo."')</script>";
  
              }
  
            }
          ?>
          <?php		
            if( isset($_POST['envoi']) )
            {
            $a = $_POST['latitude'];
            $b = $_POST['longitude'];

            echo $a;
            echo $b;	
            }	
            if (empty($a) == FALSE && empty($b) == FALSE) {
              $date1 = date("d m Y H:i");
              $geoloc = $a . "," . $b;

              $req = $bdd->prepare("INSERT INTO accidents(date1, coordonnees) VALUES(:date1, :geoloc)");
              $req->execute(array(
                'geoloc' => $geoloc,
                'date1' => $date1
              ));	
            }
          ?>
          <script>
          function Mapinit() {
            var uluru = {lat: 43.5850789334, lng: 1.43591944506};
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 12,
              center: {lat: 43.6100789334, lng: 1.43591944506}
            });
            for(var i=0; i<latitude.length; i++){
              var luru = {lat: Number(latitude[i]), lng: Number(longitude[i])};
              var luru2 = {lat: Number(latitude2[i]), lng: Number(longitude2[i])};
              var luru3 = {lat: Number(latitude3[i]), lng: Number(longitude3[i])};
              var image1 = {
              url: 'images/defibrillateurs.png',                     
              } 
              var image2 = {
              url: 'images/pharm.png',                     
              } 
              var image3 = {
              url: 'images/morts.png',                     
              } 
              var marker = new google.maps.Marker({
              position: luru,
              map: map,
              icon: image1
              });
              var marker2 = new google.maps.Marker({
              position: luru2,
              map: map,
              icon: image2
              });
              var marker3 = new google.maps.Marker({
              position: luru3,
              map: map,
              icon: image3
            });
            }
          }
        </script>
        <script>
          function maPosition(position) {
          
          document.getElementById('latitude').value=position.coords.latitude ;
          document.getElementById('longitude').value=position.coords.longitude ;		
          }
          if(navigator.geolocation)
          navigator.geolocation.getCurrentPosition(maPosition);
        </script>
        </section>
        <section id="membres">
          <h2>Localisez les membres formés en cas de besoin</h2>
          <div class="mtout">
            <div class="m1">
              <input id="b1" type="button" value="Membre localisé">
              <input id="b2" type="button" value="Membre localisé">
            </div>
            <div class="m2">
              <input id="b3" type="button" value="Membre localisé">
              <input id="b4" type="button" value="Membre localisé">
            </div>
            <div class="m3">
              <input id="b5" type="button" value="Membre localisé">
              <input id="b6" type="button" value="Membre localisé">
            </div>
            <div class="m4">
              <input id="b7" type="button" value="Membre localisé">
              <input id="b8" type="button" value="Membre localisé">
            </div>
          </div>        
        </section>
        <section id="contact">
          <h2>Si vous souhaitez nous rejoindre ou simplement nous contacter.</h2>
          <form method="post" action="">
            <div class="id">
              <input name="nom" class="nom" type="text" placeholder="Nom...">
              <input name="prenom" class="prenom" type="text" placeholder="Prénom...">
            </div>
            <div>
              <input name="email" class="mail" type="email" placeholder="Adresse mail...">
            </div>
            <div>
              <textarea name="message" class="message" name="message" placeholder="Message..."></textarea>
            </div>
            <input class="button" type="submit" value="Envoyer">
          </form>
        </section>
        <footer>
          <p>Copyright 2018. Tous droits réservés.</p>
          <a href="index.php"><img class="logof" src="images/logo.png" alt="logo"></a>
        </footer>
      </div>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqUy7cTov8bWne9dkXFILci9aC28XCbCM&callback=Mapinit"></script>
      <script>
      for(var i=0; i<membresco.length; i++){

          var name = 'b' + (i + 1);
          document.getElementById(name).value = membresco[0];

        }
      </script>
    </body>
  </html>

  <?php 
  if(isset($_POST) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['message'])) {
    $name =   $_POST['nom'];
    $firstname = $_POST['prenom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $requete = $bdd->prepare('INSERT INTO message(nom, prenom, email, message) VALUES (:nom, :prenom, :email, :message)');
    $requete->execute(array("nom" => $name, "prenom" => $firstname, "email" => $email, "message"=> $message));

  }
    ?>