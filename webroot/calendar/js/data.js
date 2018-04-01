var LOG_LEVEL = 4; //0 = error, 1 = warn, 2 = info, 3 = debug, 4 = trace

function getCalendars()
{
	var url = 'http://' + window.location.host + window.location.pathname + '?action=data&calendars=1';
	if (LOG_LEVEL >= 4) console.log("getCalendars " + url);
	//alert('http://' + window.location.host + window.location.pathname + 'index.php?action=data&calendars=1')
	$.ajax({
		url: url,
		type: "GET",
		dataType: "html",
		success: function (data) { 
			//alert('got data')
			window.calendars_config = JSON.parse(data);
		},
		error: function (xhr, status) { alert('error getting calendars'); }
	});
}

function getNoteCalendar(calendar_name)
{
	if(!window.calendars_notes || !window.calendars_notes[calendar_name+"."+window.current_year+"."+window.current_month])
	{
		$.ajax({
			url: 'http://' + window.location.host + window.location.pathname,
			type: "GET",
			data: { 
					calendar_name: calendar_name,
					action: 'data',
					note_calendar: 1,
					year: window.current_year,
					month: window.current_month
				},
			dataType: "html",
			async: false,
			success: function (data) { 
				//alert('got note:'+data);
				if(!window.calendars_notes)
					window.calendars_notes = new Array();
				window.calendars_notes[calendar_name+"."+window.current_year+"."+window.current_month] = JSON.parse(data);
			},
			error: function (xhr, status) { alert('error getting calendar note'); }
		});
	}
	
	return window.calendars_notes[calendar_name+"."+window.current_year+"."+window.current_month]
}

function clearEventsForMonth(month, year, calendar_name)
{
	if(window.calendar_events && window.calendar_events[calendar_name] && window.calendar_events[calendar_name][year] && window.calendar_events[calendar_name][year][month])
	{
		//alert('CLEARING!!!!!')
		window.calendar_events[calendar_name][year][month] = false;
	}
}

function getEventsForMonth(month, year, calendar_name)
{
	console.log("calling getEventsForMonth");
	//TODO: what if another calendar name will request this info for same year and month? There should be another array level for calendar name
	if(!window.calendar_events || !window.calendar_events[calendar_name] || !window.calendar_events[calendar_name][year] || !window.calendar_events[calendar_name][year][month])
	{
		var viewOld = 0; //false
		if (typeof( $.cookie('viewOld')) === 'undefined'){
				
		} else if ($.cookie("viewOld") == 1) {
			viewOld = 1;
		}
	
		var url = 'http://' + window.location.host + window.location.pathname;
		var data = { 
					month: month,
					year: year,
					action: 'data',
					calendar_name: calendar_name,
					events: 1,
					get_old: viewOld
				};
		if (LOG_LEVEL >= 4) console.log("getEventsForMonth url=" + url + " data=" + data);
		$.ajax({
			url: url,
			type: "GET",
			data: data,
			dataType: "html",
			async: false,
			success: function (data) { 
				//alert('got note:'+data);
				if(!window.calendar_events)
					window.calendar_events = new Array();
				if(!window.calendar_events[calendar_name])
					window.calendar_events[calendar_name] = new Array();
				if(!window.calendar_events[calendar_name][year])
					window.calendar_events[calendar_name][year] = new Array();
				window.calendar_events[calendar_name][year][month] = JSON.parse(data);
			},
			error: function (xhr, status) { alert('error getting calendar note'); }
		});
	}
	
	return window.calendar_events[calendar_name][year][month]
}

function getAllData()
{
	getCalendars()
}

$( document ).ready(function() {
	getAllData();
});