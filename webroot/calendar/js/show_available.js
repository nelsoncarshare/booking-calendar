function registerNS(ns)
{
    var nsParts = ns.split(".");
    var root = window;

    for (var i=0; i<nsParts.length; i++)
    {
        if (typeof root[nsParts[i]] == "undefined") {
            root[nsParts[i]] = {};
        }
        root = root[nsParts[i]];
    }
}
registerNS("showavailable");
			
	showavailable.isAlphabetic = function(sText)
	{
		var ValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890* ";
		var IsAlphabetic=true;
		var Char;


		for (i = 0; i < sText.length; i++)
		{
			Char = sText.charAt(i);
			if (ValidChars.indexOf(Char) == -1)
			{
				IsAlphabetic = false;
			}
		}
		return IsAlphabetic;
	}
	
	showavailable.onGetEvents = function(data)
	{
			var fifteenMinutes = 60*15; //in seconds	
			var blockwidth = 4;
			var prevTimeStamp = data['starttimepadded'];
			var table2 = "";
			var style = "";
			
			if (data['interval'] > 400) blockwidth = 1;
			else if (data['interval'] > 200) blockwidth = 2;
			else if (data['interval'] > 100) blockwidth = 3;
			else blockwidth = 4;

			// days header
			var bgcolor = "#fff";
			var countedBlocks = 0;
			
			var dd = new Date(data['starttimepadded']*1000);
			var dateText = dd.getDate();
			for (var i = data['starttimepadded']; i <= data['endtimepadded']; i += fifteenMinutes){
				var dd = new Date(i*1000);
				if (dd.getHours() == 0 && dd.getMinutes() == 0 && countedBlocks > 0){
					if (bgcolor == "#fff"){
						bgcolor = "#999";
					} else {
						bgcolor = "#fff";
					}
					var visText = "";
					if (countedBlocks > 12*4){
						visText = dateText;
					}					
					table2 += "<td class='sa' nowrap='true' style='" + style + "'>" + visText + "<br/><img src='media/p.gif' width='" + (blockwidth * countedBlocks) + "' height='1' border='0'></td>";

					dateText = dd.getDate();
					countedBlocks = 0;
				}
				countedBlocks += 1;
			}			
			if (countedBlocks > 12*4){
					dateText = dd.getDate();
					table2 += "<td class='sa' nowrap='true' style='" + style + "'>" + dateText + "<br/><img src='media/p.gif' width='" + (blockwidth * countedBlocks) + "' height='1' border='0'></td>";
					countedBlocks = 0;				
			}
			$( "td#days" ).html("<table border='0' cellpadding='0' cellspacing='0'><tr>" + table2 + "</tr></table>");
			
			//hours header
			var table1 = "";
			//Want twenty divisions. convert the interval to hours and divide by twenty
			var step = Math.ceil((data['interval']/4)/20); 
		
			for (var i = data['starttimepadded']; i <= data['endtimepadded']; i += (fifteenMinutes * 4 * step)){
				var dd = new Date(i*1000);
				table1 += "<td class='sa' nowrap='true' style='" + style + "'>" + dd.getHours() + "<br/><img src='media/p.gif' width='" + (blockwidth * 4 * step) + "' height='1' border='0'></td>";
			}
			//console.log(table1);
			$( "td#hours" ).html("<table border='0' cellpadding='0' cellspacing='0'><tr>" + table1 + "</tr></table>");
			
			//events
			for (vidx = 0; vidx < data.eventsPerVehicle.length; ++vidx) {
				var totalBlocksUsed = 0;
				var evnts = data.eventsPerVehicle[vidx];
				var table = "";
				if (evnts.length > 0){
					var evidx = 0;
					while (evidx < evnts.length) {
						//create a space block 
						if (totalBlocksUsed >= data["interval"]){
							evidx = evnts.length + 1;
							break;
						}
						var numblocks;
						var dbgStr = "";
						if (evidx == 0){
							 numblocks = evnts[evidx]['startblock'];
						}else{
							 numblocks = evnts[evidx]['startblock'] - evnts[evidx-1]['startblock'] - evnts[evidx-1]['numblocks'];
						}
						if (numblocks > 0){
							table += "<td><img src='media/p.gif' width='" + (numblocks * blockwidth) + "' height='10' border='0'/></td>";	// " + numblocks + "						
						}
						totalBlocksUsed += numblocks;
						
						//create an event block
						numblocks = evnts[evidx]['numblocks'];
						table += "<td><img src='media/p.gif' width='" + (numblocks * blockwidth) + "' height='10' style='background-color: " + evnts[evidx]['color'] + "'/></td>"; //" + evnts[evidx]['numblocks'] + "
						prevStart = evnts[evidx]['startblock'] + numblocks;
						totalBlocksUsed += numblocks;
						
						evidx++;
					}
					
					//fill until end
					$( "td[vid=" + evnts[0].bookableid + "]" ).html("<table border='0' cellpadding='0' cellspacing='0'><tr>" + table + "</tr></table>");
				}
				
			}
	}
	
	showavailable.getEvents = function(startDateTime,endDateTime)
	{
    	  var argss = {starttime:showavailable.date2YYYYMMDDHHMM(startDateTime),
    	  						 endtime:showavailable.date2YYYYMMDDHHMM(endDateTime),
    	  						 action:"showavailable"};
    	 	console.log("Fetching events for showAvailable from " + argss[0] + " to " + argss[1]);
				$.ajax({url:"ajax/events.php",
        				type: "get",
        				data: argss, 					
							  success:function(result){
							  	  var myData = result;
							  		if(myData.status == false){
    									  $( "div.error-msg-box" ).show();
    									  $( "div.error-msg-box" ).text(myData.errors[0]);
    								} else {
    										$( "div.error-msg-box" ).hide();
    										showavailable.onGetEvents(myData.data);
    								}
  							}, 							
  			});			
	}
	
	showavailable.getURLVars = function() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    	  var v = value;
        vars[key] = decodeURI(v);
    });
    return vars;
	}

	
	showavailable.date2YYYYMMDDHHMM = function(myDate) {
	   var yyyy = myDate.getFullYear().toString();
	   var m = myDate.getMonth();
	   m += 1;
	   var mm = m.toString(); // getMonth() is zero-based
	   var dd  = myDate.getDate().toString();
	   var hh = myDate.getHours().toString();
	   console.log("hrs " + hh);
	   var mn = myDate.getUTCMinutes().toString();
	   var str =  yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]) + " " + (hh[1]?hh:"0"+hh[0]) + ":" + (mn[1]?mn:"0"+mn[0]); // padding
  	 return str;
  }
	 
    // wait for the DOM to be loaded 
  $(document).ready(function() {
    	var startDateTime = null;
    	var endDateTime = null;
    	var urlVars = showavailable.getURLVars();
    	if ("starttime" in urlVars && "endtime" in urlVars){
    		startDateTime = new Date(urlVars["starttime"]);
    		endDateTime = new Date(urlVars["endtime"]);
    	} else if ("year" in urlVars && "month" in urlVars && "day" in urlVars){
     		startDateTime = new Date(urlVars["year"] + "-" + urlVars["month"] + "-" + urlVars["day"] + " 00:00");
    		endDateTime = new Date(startDateTime);
    		endDateTime = endDateTime.setDate(endDateTime.getDate() + 1);
    	}
    	if (startDateTime != null && endDateTime != null && endDateTime >= startDateTime){
				showavailable.getEvents(startDateTime,endDateTime);
			} else {
				console.log("invalid dates");
			}
    }); 