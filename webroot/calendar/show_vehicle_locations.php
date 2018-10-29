<?php

define('IN_PHPC', true);
$phpc_root_path = 'members/calendar/';
require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');

if ( isset($_GET['cal']) ){
	$cal = $_GET['cal'];
	$mapcenterlat = quick_query("select latitude from ".SQL_PREFIX."calendars where calendar=" .$db->qstr($_GET['cal']), "latitude");
	$mapcenterlong = quick_query("select longitude from ".SQL_PREFIX."calendars where calendar=" .$db->qstr($_GET['cal']), "longitude");
} else {
	$cal = 0;
	$mapcenterlat = quick_query("select latitude from ".SQL_PREFIX."calendars", "latitude");
	$mapcenterlong = quick_query("select longitude from ".SQL_PREFIX."calendars", "longitude");
}

if (!is_numeric($mapcenterlat)){
	$mapcenterlat = 0.0;
}
if (!is_numeric($mapcenterlong)){
	$mapcenterlong = 0.0;
}

?><!DOCTYPE html>
<html>
  <head>
    <title>Nelson</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      html, body {
        width: 630px; 
        height: 400px;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
	var d = new Date();
    var map;
	var calendarNum =  <?php echo($cal); ?>;
	var mapCenterLat = <?php echo($mapcenterlat); ?>;
	var mapCenterLng = <?php echo($mapcenterlong); ?>;
    var json = "<?php echo($phpc_root_path); ?>index.php?action=data&vehicle_locations=1&calendar_name=" + calendarNum + "&t="+d.getTime();
    var infowindow;
    function initialize() {

        var mapProp = {
            center: new google.maps.LatLng(mapCenterLat, mapCenterLng),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map"), mapProp);

        infowindow = new google.maps.InfoWindow();

        $(document).ready(function(){
          $.getJSON(json, function(result){
              $.each(result, function(key, data){
                var latLng = new google.maps.LatLng(data.lat, data.lng);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: data.icon,
                    title: data.description
                });

                var details = data.description;

                bindInfoWindow(marker, map, infowindow, details);
              });
          });
        });
    }

    function bindInfoWindow(marker, map, infowindow, strDescription) {
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(strDescription);
            infowindow.open(map, marker);
        });
    }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo($GOOGLE_MAPS_API_KEY['carsharecoop.ca']); ?>&callback=initialize"
    async defer></script>
  </body>
</html>