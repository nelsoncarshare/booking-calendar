var g_year="";
var g_month="";
var g_day="";
var g_id="";

function showAvailabilityForDay( year, month, day){

	var startDay =   day;
	var startMonth = month;
	var startYear =  year;
	var startHour =  '00:00';

	var endDay = day + 1;
	var endMonth = month;
	var endYear = year;
	var endHour = '00:00';	
	
	window.open('http://' + window.location.host + window.location.pathname + '?action=show_available&starttime=' + startYear+ '-' +startMonth+ '-' + startDay + '%20'+startHour+'&endtime='+endYear+'-'+endMonth+'-'+endDay+'%20'+endHour, 'showavailability','width=700,height=500,scrollbars=1');

}

function ModalDialogClose()
{
	if(window.is_modal_open != undefined && window.is_modal_open == true)
	{
		window.is_modal_open = false
		$(".ui-dialog-content").dialog("close");
}
}

function LoadingBlockUI()
{
    $.blockUI({ 
		message: 'Please Wait...',
		css: { 
        	border: 'none', 
        	padding: '15px', 
        	backgroundColor: '#000', 
        	'-webkit-border-radius': '10px', 
        	'-moz-border-radius': '10px', 
        	opacity: .5, 
        	color: '#fff' 
    } });
}

function LoadingUnblockUI()
{
	$.unblockUI();
}

function openJQueryDialog(width, height, title_header, content)
{
	$('#modal_window_div').html(content)
	LoadingUnblockUI();	
			
	if (!$("#modal_window_div").hasClass('ui-dialog-content')) {
		var opt = {
		        autoOpen: false,
		        modal: true,
		        width: width,
		        height: height,
		        fluid: true, //new option
		        title: title_header,
				show: {
					effect: "blind",
					duration: 1000
				},
				hide: {
					effect: "explode",
					duration: 1000
				}
		};
		$("#modal_window_div").dialog(opt)
	}

	$("#modal_window_div").dialog(opt).dialog("open").dialog( "option", "width", width );
	window.is_modal_open = true;
}

function openJQueryDialogWithFrame(width, height, title_header, url)
{
	//$('#modal_window_div').html(content)
	$('#modal_window_div').html("");
	//LoadingUnblockUI();	
			
	//$("#modal_window_div").remove('#myIframe');
		var opt = {
		        autoOpen: false,
		        modal: true,
		        width: width,
		        height: height,
		        fluid: false, //new option
		        title: title_header,
				/*show: {
					effect: "blind",
					duration: 1000
				},
				hide: {
					effect: "explode",
					duration: 1000
				},*/
				close:function () {
   					$('#myIframe').remove();//have do destroy dynamic element
				}

		};
		$("#modal_window_div").append($("<iframe id='myIframe' width='"+width+"px' height='"+height+"px' frameBorder='0'/>").attr("src", url)).dialog(opt).dialog("open");
		window.is_modal_open = true;
}


$('#modal_window_div').live("dialogclose", function(){
   //code to run on dialog close
  // alert(g_day);
  a='#'+g_day;
 	if(g_id!=""){
    	//  parent.$('.ui-dialog-titlebar-close').click();
        $.ajax({ url: "ajax/getAddedEvent.php?id="+g_id, context: document.body, success: function(data){
        	  if($(a).length == 0){
  	b='#td_'+g_day;
  	$(b).append("<ul id='"+g_day+"''><li>"+data+"</li></ul>");
  }
  else{
  	 $(a).append('<li>'+data+'</li>');
  }
              
              }});  
 
}


  
});

function openDetailedCarShareRecord(id, title_header)
{
	ModalDialogClose();
	LoadingBlockUI();
	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + '?action=display&modal_id='+id,
		type: "GET",
		dataType: "html",
		success: function (data) { 
			setTimeout(function() { openJQueryDialog(550, 400, title_header, data) }, 1000)
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
}

function openEventFormModifyDialog(id, title_header)
{
	ModalDialogClose();
	LoadingBlockUI();
	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + '?action=event_form&id='+id,
		type: "GET",
		dataType: "html",
		success: function (data) { 
			setTimeout(function() { openJQueryDialog(700, 600, title_header, data) }, 1000)
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
	
	return false;
}




function showEventHistory(id, title_header)
{
	ModalDialogClose();
	LoadingBlockUI();
	//alert('http://' + window.location.host + window.location.pathname + '?action=display&event_history='+id)
	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + '?action=display&event_history='+id,
		type: "GET",
		dataType: "html",
		success: function (data) { 
			setTimeout(function() { openJQueryDialog(700, 600, title_header, data) }, 1000)
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
}

function addEvent(actionUrl, title_header,year,month,day)
{
	g_year=year;
	g_month=month;
	g_day=day;
	ModalDialogClose();
	LoadingBlockUI();
	
	openJQueryDialogWithFrame(550, 400, title_header, actionUrl);
}

function openAnnouncement(announcementUrl, title_header)
{
	ModalDialogClose();
	//LoadingBlockUI();
	
	openJQueryDialogWithFrame(550, 400, title_header, announcementUrl);
}

// on window resize run function
$(window).resize(function () {
    fluidDialog();
});

// catch dialog if opened within a viewport smaller than the dialog width
$(document).on("dialogopen", ".ui-dialog", function (event, ui) {
    fluidDialog();
});


function fluidDialog() {
	console.log($(window).width());

    var $visible = $(".ui-dialog:visible");
    // each open dialog
    $visible.each(function () {
        var $this = $(this);
        var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
        console.log(dialog.options);
        // if fluid option == true
        if (dialog.options.fluid) {
            var wWidth = $(window).width();
            // check window width against dialog width
            if (wWidth < (parseInt(dialog.options.width) + 50))  {
                // keep dialog from filling entire screen
                $this.css("max-width", "90%");
            } else {
                // fix maxWidth bug
                $this.css("max-width", dialog.options.width + "px");
            }
            //reposition dialog
            dialog.option("position", dialog.options.position);
        }
    });

}

function event_delete(msg,id)
{
	//console.log('1:'+id)
var r = confirm(msg);
if (r == true) {
ModalDialogClose();
//
$.ajax({
		url: 'ajax/deleteEvent.php?id='+id,
		type: "GET",
		dataType: "html",
		success: function (data) {
			//alert(data);
		if(data!='') {
					//console.log('2')
			LoadingBlockUI();
			openJQueryDialog(550, 400, '', data)
					console.log('3')
		}
		else{
					//console.log('4')
				p='li > div#'+id;
				$("table.calendar").find(p).remove();
		}
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
}
}

function onClickShiftMonth(shiftBy){
	
	var currentMonth = parseInt(window.current_month);
	var currentYear = parseInt(window.current_year);
	var nextMonth = currentMonth + shiftBy;
	
	if (nextMonth > 12){
		window.current_month = nextMonth - 12;
		window.current_year = currentYear + 1;
	} else if (nextMonth < 1){
		window.current_month = 12 - nextMonth;
		window.current_year = currentYear - 1;
	} else {
		window.current_month = nextMonth;
	}
	console.log("onClickShiftMonth current month " + window.current_month + " year " + window.current_year  );
	Calendar.rebuildCurrentCalendar();
}

$(document).ready(function() {
    $('.collapsible').collapsible();
    console.log("ADDING TO MONTH");
    $( "#next_arrow" ).click(function() {
  			onClickNextMonth();
		});
		$( "#prev_arrow" ).click(function() {
  			onClickNextMonth();
		});
});