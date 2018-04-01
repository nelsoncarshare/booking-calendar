
function Calendar() {
	this.buildLogin = function(){
		
	};
	
	this.buildCalendar = function(){
		
	};
	
}

Calendar.viewType = {
	MONTH: 0,
	WEEK: 1,
	DAY: 2
}


window.day_names_html = new Object();
day_names_html['Sunday'] = "Sun<span>day</span>";
day_names_html['Monday'] = "Mon<span>day</span>";
day_names_html['Tuesday'] = "Tue<span>sday</span>";
day_names_html['Wednesday'] = "Wed<span>nesday</span>";
day_names_html['Thursday'] = "Thu<span>rsday</span>";
day_names_html['Friday'] = "Fri<span>day</span>";
day_names_html['Saturday'] = "Sat<span>urday</span>";

window.day_name = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

window.month_names = ['',
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
              ];



Calendar.rebuildCurrentCalendar = function(){
	
	//alert('rebuild')
	
	if(window.current_month != undefined && window.current_year != undefined && window.current_calendar_name != undefined)
	{
		//alert('clearing...')
		clearEventsForMonth(window.current_month, window.current_year, window.current_calendar_name);
		//alert('building...')
		Calendar.buildCalendarAjax(window.current_month, window.current_year, window.current_calendar_name);
	}
}

Calendar.checUser = function()
{
	console.log ( 'chcking user' );
	if(window.is_logged_in == undefined || window.is_logged_in == false)
	{
		console.log ( 'user not logged in' );
		var d = new Date();
		Calendar.loadContentAjax('?action=login&lastaction=display&year='+d.getFullYear()+'&month='+(d.getMonth()+1)+'&day='+d.getDate()+'&calendar=0');
		return false;
	}
	console.log ( 'user logged in' );
	return true;
}

Calendar.buildWeek = function(week_num, year, cal_name){
	
	window.currentViewType = Calendar.viewType.WEEK;
	
	if(week_num == 0)
	{
		window.current_week_of_month = 4
		window.current_month -= 1
		if(window.current_month == 0)
		{
			window.current_year -= 1
			window.current_month = 12
		}
	}
	
	if(week_num == 5)
	{
		window.current_week_of_month = 1
		window.current_month += 1
		if(window.current_month == 13)
		{
			window.current_year += 1
			window.current_month = 1
		}
	}
	
	//alert('1:'+cal_name)
	Calendar.loadContentAjaxCalendar('?action=display&year='+window.current_year+'&week_num='+window.current_week_of_month+'&calendar_name='+cal_name)
}

function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}

Calendar.buildCalendarAjax = function(month, year, calendar_name){	
	var myTime = Date.now();
	console.log("=== start buildCalendarAjax");
	//alert('month: '+month+', year: '+year+', calendar_name: '+calendar_name)
	if(window.is_modal_open != undefined && window.is_modal_open == true)
	{
		ModalDialogClose();
	}
	
	window.currentViewType = Calendar.viewType.MONTH;
	
	if(!Calendar.checUser()) return;
	
	window.current_day_of_month = 1
	window.current_week_of_month = 1
	window.current_month = month
	window.current_year = year
	window.current_calendar_name = calendar_name
	
	if(!window.calendars_config)
	{
		setTimeout(function(){Calendar.buildCalendarAjax(month, year, calendar_name)}, 1000);
		return;
	}
	
	//alert(window.calendars_config)
	

	
	//detect config
	//console.log('cal name: '+calendar_name)
	//console.log('calendars_config.length: '+calendars_config.length)
	//alert(JSON.stringify(window.calendars_config))
	window.config = window.calendars_config[0]
	for(var i = 0 ; i < calendars_config.length ; i++)
		if(window.calendars_config[i]['calendar'] == calendar_name)
		{
			window.config = window.calendars_config[i]
			break;
		}

	if(config)
	{
		var days_tr = $('<tr></tr>');
		for(var i = 0 ; i < 7 ; i++)
		{
			if(config['start_monday'])
				d = i + 1 % 7;
			else
				d = i;
			days_tr.append('<th id="days_names_header">'+day_names_html[day_name[d-1]]+'</th>');
		}

		var notes = getNoteCalendar(calendar_name);
		//alert(JSON.stringify(notes))
		//A)
		var caption_tag = $('<caption></caption>').html(config['calendar_title']+" / "+month_names[window.current_month]+" "+window.current_year)
		
		//B)
		var thead_tag = $('<thead></thead>')
		thead_tag.append(days_tr)
		
		//D)
		var month_section_tag = Calendar.create_month(month, year, calendar_name)
		
		//C)
		var table_tag = $('<table class="calendar"></table>')
		table_tag.append(caption_tag)
		table_tag.append(thead_tag)
		table_tag.append(month_section_tag)
		
		var calendar_div_tag = $('<div></div>')
		calendar_div_tag.append(month_navbar(month, year))
		
		window.is_filters_box_closed = true;
		var inner_div_cars = $('<div style="border: solid 1px gray; width: 350px; display: none; position: absolute; background-color: #ffffff; float: right;margin-left: -310px;" id="inner_filter_div"></div>');
		var events = getEventsForMonth(month, year, calendar_name);
		var existing_cars = []
		window.car_ids = []
		
		if(events.length > 0)
			inner_div_cars.append('<button onclick="return Calendar.filterCheckboxChanged(0)" style="margin-top: 5px; margin-left: 5px;">All</button>');
		
		for(var i = 0 ; i < events.length ; i++)
		{
			if(existing_cars.indexOf(events[i]['name']) == -1)
			{
				inner_div_cars.append('<p><input type="checkbox" id="car_check_'+events[i]['car_id']+'" onchange="return Calendar.filterCheckboxChanged('+events[i]['car_id']+')" checked />'+events[i]['name']+'</p>');
				existing_cars.push(events[i]['name']);
				window.car_ids.push(events[i]['car_id'])
			}
		}
		
		var links_table = $('<table style="float: right;"></table>')
		var links_table_tr = $('<tr></tr>')				
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));		
		links_table_tr.append($('<td></td>').append($('<div style="curson: pointer;" id="div_filter" onclick="return Calendar.showPastEventsClicked()"><a href="#">Show Past Events</a></div>').append(inner_div_cars)))		
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
		links_table_tr.append($('<td></td>').append($('<div style="curson: pointer;" id="div_filter" onclick="return Calendar.filterClicked()"><a href="#">Filter</a></div>').append(inner_div_cars)))
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
		links_table_tr.append($('<td></td>').append($('<a href="http://' + window.location.host + window.location.pathname + '?action=event_form">Book A Vehicle</a>')))
		/*
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
		links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildCalendarAjax(window.current_month, window.current_year, window.current_calendar_name)">Month</a>')))
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
		links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildWeek(window.current_week_of_month, window.current_year, window.current_calendar_name)">Week</a>')))
		links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
		links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildDay(window.current_day_of_month, window.current_month, window.current_year, window.current_calendar_name)">Day</a>')))
		*/
		links_table.append(links_table_tr)
		
		calendar_div_tag.append(links_table)
		calendar_div_tag.append(table_tag)
		calendar_div_tag.append(month_navbar(month, year))
		
		var iText = $('<div></div>');
		var found = false;
		
		//notes on head
		for(var i = 0 ; i < notes.length; i++) {
			if (notes[i].display_on_day == 0){
				var obj = notes[i];
				found = true;
				var h3 = $('<h3></h3>')
				h3.html(obj.title)
				var aLink = $('<a onClick="openAnnouncement(\'display_announcement.php?id='+obj.id+'\');"></a>')
				aLink.append(h3)
				iText.append(aLink)
			}
		}

		if ( found ){
			infoNoteText = $('<div style="margin: 8px 0px 8px 0px; padding: 4px 4px 4px 4px; border: 2px solid #000; background-color: #FFFFDD;"></div>')
			infoNoteText.append(iText)
		} else {
			infoNoteText = "";
		}
		
		var main_cal_div = $('<div></div>')
		main_cal_div.append(infoNoteText)
		main_cal_div.append(calendar_div_tag)
		
		$('#main_content_div').html(main_cal_div);

		//display on day
		for(var i = 0 ; i < notes.length; i++) {
			if (notes[i].display_on_day == 1){
				var obj = notes[i];
				for (var j = 0; j < obj.dates.length; j++){
					var objDt = obj.dates[j];
					var aStartDtObj = new Date(objDt['startdate']);
					var aEndDtObj = new Date(objDt['enddate']);
					var aStartDt = aStartDtObj.getTime();
					var aEndDt = aEndDtObj.getTime();
					var calStartDtObj = new Date(window.current_year,window.current_month-1,1,0,0,0);
					var calEndDtObj = new Date(window.current_year,window.current_month,1,0,0,0);
					var calStartDt = calStartDtObj.getTime();
					var calEndDt = calEndDtObj.getTime();
					if (aStartDt < calStartDt) aStartDt = calStartDt;
					if (aEndDt > calEndDt) aEndDt = calEndDt;
					while (aStartDt <= aEndDt){
						var dy = new Date(aStartDt);
						var dayNum = dy.getDate();
						var h3 = $('<h3></h3>')
						h3.html(obj.title)
						var aLink = $('<a onClick="openAnnouncement(\'display_announcement.php?id='+obj.id+'\');"></a>')
						aLink.append(h3)
						$('#td_' + dayNum).prepend(aLink);						
						aStartDt += 1000 * 60 * 60 * 24;
					}
				}
			}
		}
		
		//alert($('#main_content_div').html())
		console.log("=== end buildCalendarAjax " + (Date.now() - myTime));
	}
}

Calendar.filterCheckboxChanged = function(car_id){
	if(car_id == 0)
	{
		for(var i = 0 ; i < window.car_ids.length ; i++)
		{
			$('.car_id_'+window.car_ids[i]).css('display', 'block');
			$('#car_check_'+window.car_ids[i]).prop('checked', true);
		}
	}
	else
		$('.car_id_'+car_id).css('display', $('#car_check_'+car_id).is(':checked') ? 'block' : 'none');
}

Calendar.filterClicked = function(){
	window.is_filters_box_closed = !window.is_filters_box_closed;
	$('#inner_filter_div').css('display', window.is_filters_box_closed ? 'none' : 'block');
	//return false;
}

Calendar.showPastEventsClicked = function(){
		if (typeof $.cookie('viewOld') === 'undefined' || $.cookie("viewOld") == 0) {
				$.cookie("viewOld", "1");
		} else { 
				$.cookie("viewOld", "0");
		}
		Calendar.rebuildCurrentCalendar();
}

function month_navbar(month, year)
{
	var html = $('<div class="phpc-navbar"></div>');
	//alert(Calendar.currentViewType)
	if(window.currentViewType == Calendar.viewType.MONTH){
		var d = new Date();
		d.setMonth(month-1);
		d.setYear(year);
	
		d.setMonth(d.getMonth()-1);
		var prev_m_d = d.getMonth();
		var prev_y = d.getFullYear();
	
		d.setMonth(d.getMonth()+2);
		var next_m_d = d.getMonth();
		var next_y = d.getFullYear();
	
		var prev_m = prev_m_d+1;
		var next_m = next_m_d+1;
	
		html.append($('<a id="prev_arrow" href="javascript:void(0);" onClick="onClickShiftMonth(-1);" class="arrow"><</a>'));
		html.append($('<a id="next_arrow" href="javascript:void(0);" onClick="onClickShiftMonth(+1);" class="arrow">></a>'));
	}
	else if(window.currentViewType == Calendar.viewType.WEEK)
	{
		var prev_current_week_of_month = window.current_week_of_month - 1
		var next_current_week_of_month = window.current_week_of_month + 1

		html.append($('<a href="javascript:void(0);" onClick="Calendar.buildWeek('+prev_current_week_of_month+', '+window.current_year+', '+window.current_calendar_name+')" class="arrow"><</a>'));
		html.append($('<a href="javascript:void(0);" onClick="Calendar.buildWeek('+next_current_week_of_month+', '+window.current_year+', '+window.current_calendar_name+')" class="arrow">></a>'));
	}
	else if(window.currentViewType == Calendar.viewType.DAY)
	{	
		var d = new Date(window.current_year, window.current_month-1, window.current_day_of_month, 0, 0, 0 );
	
		d.setDate(d.getDate() - 1);
		var prev_m_day = d.getDate();
		var prev_m_d = d.getMonth()+1;
		var prev_y = d.getFullYear();
	
		d.setDate(d.getDate() + 2);
		var next_m_day = d.getDate();
		var next_m_d = d.getMonth()+1;
		var next_y = d.getFullYear();
	
//		console.log('build prev: '+prev_m_day+'/'+prev_m_d+'/'+prev_y)
//		console.log('build next: '+next_m_day+'/'+next_m_d+'/'+next_y)
//		console.log('===================')
//		console.log('')
		
		html.append($('<a href="javascript:void(0);" onClick="Calendar.buildDay('+prev_m_day+', '+prev_m_d+', '+prev_y+', '+window.current_calendar_name+')" class="arrow"><</a>'));
		html.append($('<a href="javascript:void(0);" onClick="Calendar.buildDay('+next_m_day+', '+next_m_d+', '+next_y+', '+window.current_calendar_name+')" class="arrow">></a>'));
	}
	
	return html;
}

Calendar.buildDay = function(day, month, year, cal_name){
	
//	console.log('')
//	console.log('===================')
//	console.log('buildDay: '+day+'/'+month+'/'+year)
	
	window.currentViewType = Calendar.viewType.DAY;
	
	window.current_day_of_month = day;
	window.current_month = month;
	window.current_year = year;
	
	//alert('2:'+cal_name)
	Calendar.loadContentAjaxCalendar('?action=display&year='+year+'&day='+day+'&calendar_name='+cal_name+'&month='+month)
}

Calendar.create_month = function(month, year, calendar_name)
{
	var events = getEventsForMonth(month, year, calendar_name)
	//alert(events)
	
	return $('<tbody></tbody>').append(Calendar.create_weeks(events, 1, month, year));
}

function day_of_first(month, year)
{
	return date('w', mktime(0, 0, 0, month, 1, year));
}

// returns the number of days in $month
function days_in_month(month, year)
{
	return date('t', mktime(0, 0, 0, month, 1, year));
}

//returns the number of weeks in $month
function weeks_in_month(month, year)
{
    var firstOfMonth = new Date(year, month-1, 1);
    var lastOfMonth = new Date(year, month, 0);
	
    var used = firstOfMonth.getDay() + lastOfMonth.getDate();
	
	var weeks = Math.ceil( used / 7);
	
	return weeks;
}

Calendar.create_weeks = function(events, week_of_month, month, year)
{
	if(week_of_month > weeks_in_month(month, year)) return $('<tr></tr>');

        html_week = $('<tr></tr>').append(Calendar.display_days(events, 0, week_of_month, month, year));

        return [html_week].concat(Calendar.create_weeks(events, week_of_month + 1,
                                month, year));
}

function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}


function formatted_time_string(time, type)
{
	switch(type) {
		default:
			var myregexp = /(\d+):(\d+)/;
			var match = myregexp.exec(time);
			var hour = 0;
			var minute = 0;
			if (match != null)
			{
				hour = match[1];
				minute = match[2];
			}

			if(!window.config['hours_24']) {
				if(hour >= 12) 
				{
                	if(hour == 12 && minute == 0) 
                	{
                    	pm = ' noon';
                    } else if (hour == 12) {
						pm = 'pm';
                	} else {
                		hour -= 12;
                		pm = 'pm';
                	}
                 } else {
                    if(hour == 0 && minute == 0) 
                    {
                         hour = 12;
              			 pm = ' midnight';	
                    } else if (hour == 0){
                    	 hour = 12;
                    	 pm = 'am';
                    } else {
                    	pm = 'am';
                    }
				}
			} else {
				pm = '';
			}

			return sprintf('%d:%02d%s', hour, minute, pm);
	}
}


function formatted_date_string(startyear, startmonth, startday, endyear,
		endmonth, endday, hour, minute)
{
	var timestamp = new Date(startyear, startmonth, startday, hour, minute, 0, 0).getTime()
	timestamp = timestamp - 60;
	var str = date("M",timestamp) + " " + date('j',timestamp);
	return str;
}



function getMonday(d) {
  d = new Date(d);
  var day = d.getDay(),
      diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
	
	a = new Date(d.setDate(diff));
	//alert(a.toString())
	
  return new Date(d.setDate(diff));
}

Calendar.display_days = function(result, day_count, week_of_month, month, year)
{
		if(day_count > 6) return [];

		var EVENT_TYPE_BOOKING = 1;
		var html_day = $('<td></td>');
		
		if(config['start_monday'] == 0)
			first_day_of_week = 0;
		else
			first_day_of_week = 1;
		
		//first_day_of_week = getMonday(new Date(year, month))
		day_of_month = (week_of_month - 1) * 7 + day_count
			- ((7 + day_of_first(month, year) - first_day_of_week) % 7) + 1;

		if(!window.datalog){
			window.datalog = "";
		} else {
			window.datalog += "day_of_month: "+day_of_month+", week_of_month: "+week_of_month+", day_count: "+day_count+", first_day_of_week: "+first_day_of_week+", month: "+month+", year: "+year+"\n";
		}
		
		if(day_of_month <= 0 || day_of_month > days_in_month(month, year)) {
			//alert(1)
			html_day = $('<td class="prev-month">&nbsp;</td>')
		} else {
			//alert(2)
			/********EVENTS**********/
		    have_events = false;
				html_events = $('<ul id="'+day_of_month+'"></ul>');
				for(var i = 0 ; i < result.length ; i++) {
					var row = result[i];
					var stStamp = strtotime(row['starttime']);
					var endStamp = strtotime(row['endtime']);
					if (row['end_hour'] == "00" && row['end_minute'] == "00")
					{
						// prevent date from displaying on next day.
						endStamp = endStamp - 1;
					}
					//alert(new Date(year, month, day_of_month-1, 0, 0, 0, 0).toString())
					var curDayStart = strtotime(new Date(year, month-1, day_of_month, 0, 0, 0, 0).toString())
					var curDayEnd = strtotime(new Date(year, month-1, day_of_month+1, 0, 0, 0, 0).toString())
					//alert(year+'/'+month+'/'+day_of_month)
					//alert(3)
					//alert('curDayEnd = '+curDayEnd+', stStamp = '+stStamp+', curDayStart = '+curDayStart+', endStamp = '+endStamp)
					window.datalog += "curDayEnd: "+curDayEnd+", stStamp: "+stStamp+", curDayStart:"+curDayStart+", endStamp: "+endStamp+"\n";
					if ( curDayEnd >= stStamp && curDayStart <= endStamp ){
						//alert(4)
						if (row['eventtype'] == EVENT_TYPE_BOOKING) {
							backgrndImage = "";
						} else {
							backgrndImage = "url(media/striped.gif); background-repeat:repeat-y";
						}

						var subject = escapeHtml(strip_tags(stripslashes(
										row['subject'])));

//						var event_start_time = formatted_time_string(
//								row['starttime'],
//								row['eventtype']);
//
//						var event_end_time = formatted_time_string(
//								row['endtime'],
//								row['eventtype']);	
//
//						var event_start_date_str = formatted_date_string(row['year'], row['month'],
//										row['day'], row['year'], row['month'],
//										row['day'], row['hour'], row['minute']);
//
//						event_end_date_str = formatted_date_string(row['end_year'], row['end_month'],
//									row['end_day'], row['end_year'], row['end_month'],
//									row['end_day'], row['end_hour'], row['end_minute']);				
						//alert(event_end_date_str)
						if (row['grp_displayname'] == 'INDIVIDUAL_DO_NOT_DELETE') {
							displayname = row['displayname'];
						} else {
							displayname = row['grp_displayname'] + " (" + row['displayname'] +")";
						}


//						if (event_start_date_str == event_end_date_str){
//							vis_text = event_start_time + " to " + event_end_time;
//						} else {
//							vis_text = event_start_time +" " + event_start_date_str + " to " + event_end_time + " " + event_end_date_str;				
//						}

						var car_text = $('<a href="'+location.href+'?action=display&id='+row['id']+'" style="color:black; font-weight: bold;">'+row['name']+' [edit]</a>')

				        var link_text = "";
				        if (row['description'] != "" || row['subject'] != ""){
				        	link_text = "<b>Subject: "+row['subject']+"</b><br>";
				        }

						var div_car_name = row['name'];
						var div_time = row['formattedTime'];
						var username = substr(displayname, 0,12)+"...";
						
						var car_text = $('<div class="car_dive_display car_id_'+row['car_id']+'" id="'+row['id']+'">'+div_car_name+'<br>'+div_time+'<br>'+username+'<br>'+link_text+'<a href="#" onclick="openDetailedCarShareRecord('+row['id']+', \''+addslashes(div_car_name)+'\'); return false;" style="color:black; font-weight: bold;">[more][edit]</a></div>')
//						console.log('color: '+row['color']);
						var eventt = $('<li style="background: '+row['color']+'; '+backgrndImage+'"></li>').append(car_text)
				
                        html_events.append(eventt);
                        have_events = true; 
			        }
				}

			/*********END EVENTS ****/

			var currentday = date('j');
			var currentmonth = date('n');
			var currentyear = date('Y');

			// set whether the date is in the past or future/present
			if(currentyear > year || currentyear == year
					&& (currentmonth > month
						|| currentmonth == month 
						&& currentday > day_of_month
					   )) {
			}

	        if(config['anon_permission']) {
			//alert(5)
				var a_tag = $("<a href='javascript:void(0);' onClick='showAvailabilityForDay("+year+", "+month+", "+day_of_month+")'>"+day_of_month+"</a>");
				var span_tag = $('<span class="suffix">th</span>');
				var data_link = $("<a href='http://" + window.location.host + window.location.pathname + "?action=event_form&year="+year+"&month="+month+"&day="+day_of_month+"'>+</a>");
				//create_date_link_dialog('+', 'event_form', year, month, day_of_month);
				
				var parent_span_dialog = $('<span class="num"></span>')
				parent_span_dialog.append(a_tag);
				parent_span_dialog.append(span_tag);
				parent_span_dialog.append('&nbsp;');
				parent_span_dialog.append(data_link);
				
				var td_tag = $('<td '+(have_events ? 'id="td_'+day_of_month+'"' : 'class="events" id="td_'+day_of_month+'"')+'></td>')
				td_tag.append($('<h3 class="day"></h3>')).append(parent_span_dialog)
				html_day = td_tag
	        } else {
		//alert(6)
				html_day = $('<td '+(have_events ? "" : 'class="events"')+'></td>').append(create_date_link(day_of_month, 'display', year, month, day_of_month));
	        }

			if(have_events){
				//alert(7)
				html_day.append(html_events);
			}
		}

		//alert(window.datalog);

		return [html_day].concat(Calendar.display_days(result, day_count + 1, week_of_month, month, year));
}

function create_date_link(text, action, year, month, day)
{
	var url = location.href+"?action="+action;
	url += "&year="+year;
	url += "&month="+month;

	url = "href=\"javascript:void(0);\" onClick=\"Calendar.loadContentAjax('"+url+"')\"";

	return $('<a '+url+'>'+text+'</a>');
}

function create_date_link_dialog(text, action, year, month, day)
{
	var url = 'href="javascript:void(0);"  onClick="addEvent(\''+location.href+'?action='+action;
	url += "&amp;year="+year;
	url += "&amp;month="+month;
	url += "&amp;day="+day;
//        if($lastaction !== false) $url .= "&amp;lastaction=$lastaction";
	url += '\',\'\','+year+','+month+','+day+');"';

	return $('<a '+url+'>'+text+'</a>');
}



Calendar.loadContentAjaxCalendar = function(url){
	LoadingBlockUI();

	window.current_url = url;

	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + url,
		type: "POST",
		dataType: "html",
		success: function (data) { 
			
			
			var calendar_div_tag = $('<div></div>')
			var table_tag = $('<table class="calendar"></table>')
			
			var caption_tag = $('<caption></caption>').html(config['calendar_title']+" / "+month_names[window.current_month]+(window.currentViewType == Calendar.viewType.WEEK ? " ("+window.current_week_of_month+"/4 week)" : "")+" "+window.current_year)
			
			var thead_tag = $('<thead></thead>')
			//thead_tag.append(days_tr)
			table_tag.append(caption_tag)
			table_tag.append(thead_tag)
			
			var table_tag_tr = $('<tr></tr>')
			var table_tag_td = $('<td></td>')
			table_tag_td.html(data)
			table_tag_tr.append(table_tag_td)
			table_tag.append(table_tag_tr)
			
			
			var links_table = $('<table style="float: right;"></table>')
			var links_table_tr = $('<tr></tr>')
			links_table_tr.append($('<td></td>').append($('<a href="http://' + window.location.host + window.location.pathname + '?action=event_form">Book A Vehicle</a>')))
			/*
			links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
			links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildCalendarAjax(window.current_month, window.current_year, window.current_calendar_name)">Month</a>')))
			links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
			links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildWeek(window.current_week_of_month, window.current_year, window.current_calendar_name)">Week</a>')))
			links_table_tr.append($('<td>&nbsp;|&nbsp;</td>'));
			links_table_tr.append($('<td></td>').append($('<a href="javascript:void(0);" onClick="Calendar.buildDay(window.current_day_of_month, window.current_month, window.current_year, window.current_calendar_name)">Day</a>')))
			*/
			links_table.append(links_table_tr)
			
			calendar_div_tag.append(month_navbar(window.current_month, window.current_year))
			calendar_div_tag.append(links_table)
			calendar_div_tag.append(table_tag)
			
			$('#main_content_div').html('')
			$('#main_content_div').append(calendar_div_tag)
			LoadingUnblockUI();
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
};

Calendar.loadContentAjax = function(url){
	
	if(window.is_modal_open != undefined && window.is_modal_open == true)
	{
		ModalDialogClose();
	}
	
	if(window.arrayContent == null)
		window.arrayContent = new Array();
	
	LoadingBlockUI();
	/*if(typeof window.arrayContent[url] == 'undefined')
	{*/
		$.ajax({
			url: 'http://' + window.location.host + window.location.pathname + url,
			type: "POST",
			dataType: "html",
			success: function (data) { 
				console.log("start ajax success=====");
				var myTime = Date.now();
				window.arrayContent[url] = data;
				$('#main_content_div').html(window.arrayContent[url]);
				LoadingUnblockUI();
				console.log("end ajax success =======" + (Date.now() - myTime));
			},
			error: function (xhr, status) { LoadingUnblockUI(); }
		});
	/*}
	else
	{
		//alert('content exists for url: '+url)
		$('#main_content_div').html(window.arrayContent[url]);
		LoadingUnblockUI();
	}*/
};

Calendar.submitAjaxForm = function(action, form_id)
{
    $.ajax({
           type: "POST",
           url: action,
           data: $("#"+form_id).serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert(data); 
           }
         });

    return false;
}

Calendar.openEventFormDialog = function(year,month,day_of_month)
{
	var dateStr;
	if (year === undefined || month === undefined || day_of_month === undefined){
		 dateStr = "";
	} else {
		 dateStr = "&year=" + year + "&month=" + month + "&day=" + day_of_month;
	}
	ModalDialogClose();
	LoadingBlockUI();
	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + '?action=event_form' + dateStr,
		type: "GET",
		dataType: "html",
		success: function (data) { 
			//alert(data);
		
			openJQueryDialog(700, 800, 'Create New Booking', data)
			
		    var frm = $('#event_form');
		    frm.submit(function (ev) {
			
				
		        $.ajax({
		            type: frm.attr('method'),
		            url: frm.attr('action'),
		            data: frm.serialize(),
		            success: function (data) {
			//alert(data)
						//if(data.indexOf('ModalDialogClose') > -1)
						//{
							ModalDialogClose();
							Calendar.rebuildCurrentCalendar();
						//}
						//else
		                //	openJQueryDialog(700, 800, 'Create New Booking', data);
		            },
					error: function (xhr, status) { alert('error submitting event form') }
		        });

		        ev.preventDefault();
		    });
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
	
	return false;
}

Calendar.postForgetPassword = function(){
	var username_v = $('#forget_password_form').find('input[name="username"]').val();
	var action_v = $('#forget_password_form').find('input[name="action"]').val();
	
	LoadingBlockUI();
	$.ajax({
		url: 'http://' + window.location.host + window.location.pathname + 'index.php',
		type: "POST",
		dataType: "html",
		data: {username: username_v, action: action_v}, 
		success: function (data) { 
			LoadingUnblockUI();
			$('#result_message').html(data);
		},
		error: function (xhr, status) { LoadingUnblockUI(); }
	});
};

Calendar.buildForgetPassword = function(){
	$('#main_content_div').html('<div id="result_message"></div><form action="index.php" id="forget_password_form" method="post">\
	<table class="phpc-mobile">\
	<caption>Forgot my password</caption>\
	<tfoot><tr><td colspan="2"><input name="action" value="new_password" type="hidden" />\
	<input name="submit" value="Email me a new password" type="submit"  />\
	</td></tr></tfoot><tbody><tr><th>Your email address:</th>\
	<td><input name="username" type="text" /></td></tr></tbody></table></form>');
	
	
	
	$( "#forget_password_form" ).submit(function( event ) {
		event.preventDefault();
		
		Calendar.postForgetPassword();
	});
};

Calendar.layout = function () {
	
	/*
	obj = new Calendar();
	obj.buildNavBar();
	obj.buildLogin();*/
}
