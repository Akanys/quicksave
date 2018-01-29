<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Toujours définir la hauteur de la carte pour définir la taille de la div
       * élément qui contient la carte. */
      #map {
        height: 100%;
      }
      /* Facultatif: Rend la page dans la fenêtre. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    
    <div id="map"></div>
    <script>
      var latitude = [];
      var longitude = [];
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
      ?>
      <script>

      function Mapinit() {
        var uluru = {lat: 43.5850789334, lng: 1.43591944506};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        for(var i=0; i<latitude.length; i++){
          var luru = {lat: Number(latitude[i]), lng: Number(longitude[i])};
          var marker = new google.maps.Marker({
          position: luru,
          map: map
        });
        }
      }   
      
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Localisation found.');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Le navigateur ne supporte pas la géolocalisation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkStsRA4z4Y6RIWDYVaZ_HhfSE9kh-RuM&callback=initMap"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqUy7cTov8bWne9dkXFILci9aC28XCbCM&callback=Mapinit"></script>

  </body>
</html>