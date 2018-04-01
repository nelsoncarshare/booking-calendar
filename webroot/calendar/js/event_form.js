var xmlHttp

function openCouldntBookCar()
{
	window.open('http://' + window.location.host + window.location.pathname + '?action=couldnt_book_vehicle', 'couldntbookvehicle','width=700,height=500, scrollbars=1');
}

function showUser(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	 {
	 alert ('Browser does not support HTTP Request');
	 return;
	 }
	var url='getAnnouncement.php';
	url=url+'?q='+str;
	url=url+'&sid='+Math.random();
	xmlHttp.onreadystatechange=stateChanged; 
	xmlHttp.open('GET',url,true);
	xmlHttp.send(null);
}

function stateChanged() 
{ 
  if (xmlHttp.readyState==4 || xmlHttp.readyState=='complete'){ 
    if (xmlHttp.responseText == '') {
      document.getElementById('infoText').innerHTML = '';
 	  document.getElementById('infoText').style.visibility = 'hidden';
    } else {
      document.getElementById('infoText').style.visibility = 'visible';
 	  document.getElementById('infoText').innerHTML=xmlHttp.responseText + '&nbsp;'
    } 
  } 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject('Msxml2.XMLHTTP');
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
 }
return xmlHttp;
}

function openShowAvailableWindow()
{
	console.log("clicked open show avail");
	var startDay =   document.getElementById('day').value;
	var startMonth = document.getElementById('month').value;
	var startYear =  document.getElementById('year').value;
	var startHour =  document.getElementById('starthour').value;

	var endDay = document.getElementById('endday').value;
	var endMonth = document.getElementById('endmonth').value;
	var endYear = document.getElementById('endyear').value;
	var endHour = document.getElementById('endhour').value;	
	
	window.open('http://' + window.location.host + window.location.pathname + '?action=show_available&starttime=' + startYear+ '-' +startMonth+ '-' + startDay + ' '+startHour+'&endtime='+endYear+'-'+endMonth+'-'+endDay+' '+endHour, 'showavailability','width=700,height=500, scrollbars=1');
	//$("#show_availability_div").show();

//	var startDateTime = null;
//	var endDateTime = null;
//
//	console.log("sta " + startYear + "-" + startMonth + "-" + startDay + " " + startHour + ":00");
//	console.log("end " + endYear + "-" + endMonth + "-" + endDay + " 00:00");
// 	startDateTime = new Date(startYear + "-" + startMonth + "-" + startDay + " " + endHour + ":00");
//	endDateTime = new Date(endYear + "-" + endMonth + "-" + endDay + " 00:00");
//	
//	showavailable.getEvents(startDateTime,endDateTime);
}

function openTripEstimateWindow()
{
	window.open('http://' + window.location.host + window.location.pathname + '?action=trip_estimate', 'tripestimate','width=700,height=500, scrollbars=1');
}


$(document).ready(function(){
    
//var obj = document.getElementById('couldntBookCarReasonDiv');
//obj.style.visibility='hidden';
   $("#couldntBookCarReasonDiv").hide();
   
   $("#openCouldntBookCarLink").click(function(event){
			openCouldntBookCar();		
   });
   
   $("#openShowAvailability").click(function(event){
			openShowAvailableWindow();		
   });
   
   $("#refreshShowAvailability").click(function(event){
   		openShowAvailableWindow();
 	 });
 
   $("#show_availability_div").hide();
   
   $("#date_selector").datepicker();
   $('#date_selector').on('change keyup paste mouseup',function(){
   		$('#day').val($(this).val().split('/')[1]);
   		$('#month').val($(this).val().split('/')[0]);
   		$('#year').val($(this).val().split('/')[2]);
   });

   $("#end_date_selector").datepicker();
   $('#end_date_selector').on('change keyup paste mouseup',function(){
   		$('#endday').val($(this).val().split('/')[1]);
   		$('#endmonth').val($(this).val().split('/')[0]);
   		$('#endyear').val($(this).val().split('/')[2]);
   });

$('#subject').on('keyup paste change mouseup',function(){
  if($(this).val().length>0){
$('.description').slideDown('slow');  
}
else{
 $('.description').slideUp('slow'); 
}
});
 
 });
