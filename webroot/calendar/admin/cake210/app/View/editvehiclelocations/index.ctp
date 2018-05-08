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

	$query = 'SELECT * FROM '.SQL_PREFIX."locations";

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
?>

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo(get_google_maps_api_key1()); ?>"
      type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    
	var baseIcon = new GIcon();
	baseIcon.iconSize = new GSize(14, 9);
	baseIcon.iconAnchor = new GPoint(9, 7);
	baseIcon.infoWindowAnchor = new GPoint(9, 2);
	
	var map;
	var myCars = new Array();
	var myCarIDs = new Array();
		
    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        
        map.addControl(new GLargeMapControl());
        
        map.setCenter(new GLatLng(<?php echo("$mapcenterlat, $mapcenterlong") ?>), 13);
        
		<?php
			$optionsText = "";
			if ($row1 = $result->FetchRow()) {
		
				for (; $row1; $row1 = $result->FetchRow()) {
					echo('addIcon(' . zeroIfNull($row1['GPS_coord_x']) . "," . zeroIfNull($row1['GPS_coord_y']) . ",'" . addslashes($row1['name']) . "'," . $row1['id'] . ");" . "\n");
					$optionsText .= '<option value="' . $row1['id'] . '">' . $row1['name'] . " " . $row1['city'] . " " . $row1['address1'] . '</option> ';
				}

			}     	
        ?>
      }
    }
	
	function myDragEnd(marker) {
       var myid = myCarIDs[marker.getTitle()];
       updateLocationInDatabase(marker.getLatLng().lat(), marker.getLatLng().lng(), myid, "ADMIN_SET_LOC"); 
    }
	
	function addIcon(lat,lng,mytitle,myid){
        var vanIcon = new GIcon(baseIcon);
		vanIcon.image = "van.gif";
               
        //var marker = new GMarker(new GLatLng(lat,lng), {draggable:true, icon:vanIcon, title:mytitle})
        var marker = new GMarker(new GLatLng(lat,lng), {draggable:true, title:mytitle})
        
        myCars[myid] = marker;
        myCarIDs[mytitle] = myid; 
        
        GEvent.addListener(marker, "dragstart", function() {
		  map.closeInfoWindow();
		  });
		
		GEvent.addListener(marker, "dragend", function(){ myDragEnd(marker); });
        
		map.addOverlay(marker);			
	}
	
	function centerIcon(){
		var mytitle = document.getElementById('carSelectBox').value;
		if (mytitle != ""){
			var myMarker = myCars[mytitle];
			if (myMarker != null){
				myMarker.setLatLng( map.getCenter() );
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
		var url='<?php echo $html->url('/locations/updateGPS/')?>';
		url=url+'/'+mylat+"/"+mylong+"/"+vehicle_id+"/"+myoperation+"/";
		url=url+'&sid='+Math.random()
		xmlHttp.onreadystatechange=stateChanged 
		xmlHttp.open('GET',url,true)
		xmlHttp.send(null)
	}
	
    //]]>
    </script>
  </head>
  <body onload="load()" onunload="GUnload()">
    <div id="map" style="width: 400px; height: 500px"></div>
    <br/>
    <br/>
    <form>
    	<select id="carSelectBox" name="cars">
    	
	    	<?php
	    		echo($optionsText);       	
	        ?>
    	</select>
    </form>
    <a href="javascript:void(0);" onClick="centerIcon()">place location in center of map.</a>

<?php
}
edit_vehicle_locations($this->html);
?>
