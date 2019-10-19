<?php

function zeroIfNull($mynum)
{
	if (!is_numeric($mynum)){
		return 0;
	} else {
		return $mynum;
	}
}

function get_locations()
{
	global  $db;

		$query = "select ".SQL_PREFIX."bookables.name as description, ".SQL_PREFIX."locations.id as id, ".SQL_PREFIX."locations.name as name, city, address1 from ".
		SQL_PREFIX."bookables inner join ".SQL_PREFIX."locations on ".SQL_PREFIX."bookables.location_id=".
		SQL_PREFIX."locations.id inner join ".SQL_PREFIX."vehicles on ".SQL_PREFIX."bookables.vehicle_id=".SQL_PREFIX."vehicles.id left outer join ".
		SQL_PREFIX."vehicletypes on ".SQL_PREFIX."vehicletypes.id=".SQL_PREFIX."vehicles.vehicle_type".
		" where disabled='0'";
	

	$result = $db->Execute($query)
		or db_error(_('Error in get_locations'), $query);

	return $result;
}

function edit_vehicle_locations($html){
	
	if ( isset($_GET['cal']) ){
		$mapcenterlat = quick_query("select latitude from ".SQL_PREFIX."calendars where calendar=" .$db->qstr($_GET['cal']), "latitude");
		$mapcenterlong = quick_query("select longitude from ".SQL_PREFIX."calendars where calendar=" .$db->qstr($_GET['cal']), "longitude");
	} else {
		$mapcenterlat = quick_query("select latitude from ".SQL_PREFIX."calendars", "latitude");
		$mapcenterlong = quick_query("select longitude from ".SQL_PREFIX."calendars", "longitude");
	}
	
	if (!is_numeric($mapcenterlat)){
		$mapcenterlat = 0.0;
	}
	if (!is_numeric($mapcenterlong)){
		$mapcenterlong = 0.0;
	}

	
	$result = get_locations();
	$optinsText = "";
}

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
     	
        

?>

    <div id="map" style="width: 400px; height: 500px"></div>
    <script>
	var d = new Date();
    var map;
	var myCars = new Array();
	var myCarIDs = new Array();	
	var calendarNum =  <?php echo($cal); ?>;
	var mapCenterLat = <?php echo($mapcenterlat); ?>;
	var mapCenterLng = <?php echo($mapcenterlong); ?>;
    var json = "../../../index.php?action=data&vehicle_locations=1&calendar_name=-1&t="+d.getTime();
    var infowindow;
	
	function centerIcon(){
		var mytitle = document.getElementById('carSelectBox').value;
		
		if (mytitle != ""){
			var myMarker = myCars[String(mytitle)];
			if (myMarker != null){
				myMarker.setPosition( map.getCenter() );
			}
		}
	}
	
	function arrayContains(a, o){
		for (x in a)
		{
			if (a[x] == o){
				return true;
			}
			return false;
		}
	}
	
	
	function stateChanged() 
	{ 
	  if (xmlHttp.readyState==4 || xmlHttp.readyState=='complete'){ 
		if (xmlHttp.responseText == '') {
		  //document.getElementById('infoText').innerHTML = '';
		  //document.getElementById('infoText').style.visibility = 'hidden';
		} else {
		  alert(xmlHttp.responseText);
		  //document.getElementById('infoText').style.visibility = 'visible';
		  //document.getElementById('infoText').innerHTML=xmlHttp.responseText + '&nbsp;'
		} 
	  } 
	}

	function GetXmlHttpObject()
	{
		var xmlHttp=null;
		try {
 			// Firefox, Opera 8.0+, Safari
 			xmlHttp=new XMLHttpRequest();
 		} catch (e) {
 		//Internet Explorer
 			try {
  				xmlHttp=new ActiveXObject('Msxml2.XMLHTTP');
  			} catch (e){
  				xmlHttp=new ActiveXObject('Microsoft.XMLHTTP');
  			}
 		}
		return xmlHttp;
	}
	
	function updateLocationInDatabase(mylat,mylong,vehicle_id,myoperation)
	{ 
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
	 	{
	 		alert ('Browser does not support HTTP Request')
	 		return
	 	}
		
		var url= '<?php echo $this->html->url('/locations/updateGPS/')?>';
		url=url+'/'+mylat+"/"+mylong+"/"+vehicle_id+"/"+myoperation+"/";
		url=url+'&sid='+Math.random();
		
		xmlHttp.onreadystatechange=stateChanged 
		xmlHttp.open('GET',url,true)
		xmlHttp.send(null)
	}	
	
	function myDragEnd(marker) {
       var myid = myCarIDs[marker.getTitle()];
	   var lt = marker.getPosition().lat();
	   var lg = marker.getPosition().lng();
       updateLocationInDatabase(lt, lg, myid, "ADMIN_SET_LOC"); 
    }	
	
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
                    icon: "../../../" + data.icon,
					draggable: true,
                    title: data.description
                });
				
				myCars[String(data.id)] = marker;
				myCarIDs[data.description] = data.id; 
				
				google.maps.event.addListener(marker, "dragend", function(){ myDragEnd(marker); });
				
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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo($GOOGLE_MAPS_API_KEY); ?>&callback=initialize"
    async defer></script>
	
	    <form>
    	<select id="carSelectBox" name="cars">
    	
	    	<?php
	$result = get_locations();
			$optionsText = "";
			if ($row1 = $result->FetchRow()) {
		
				for (; $row1; $row1 = $result->FetchRow()) {
					$optionsText .= '<option value="' . $row1['id'] . '">' . $row1['name'] . " " . $row1['city'] . " " . $row1['address1'] . '</option> ';
				}
			}			
	    		echo($optionsText);       	
	        ?>
    	</select>
    </form>
    <a href="javascript:void(0);" onClick="centerIcon()">place location in center of map.</a>
