<?php
/*
   Copyright 2002 - 2005 Sean Proctor, Nathan Poiro

   This file is part of PHP-Calendar.

   PHP-Calendar is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   PHP-Calendar is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP-Calendar; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

 */

/*
   This file is loaded as a style sheet
*/

header('Content-Type: text/css');
/*
define('SEPCOLOR',     '#000000');
define('BG_COLOR1',    '#FFFFFF');
define('BG_COLOR2',    'grey');        //days without a number
define('BG_COLOR3',    '#555566');     //silver  //calendar headings
define('BG_COLOR4',    '#CCCCCC'); 
define('BG_PAST',      'silver');     //silver
define('BG_FUTURE',    'white');
define('TEXTCOLOR1',   '#000000');
define('TEXTCOLOR2',   '#FFFFFF');

if(isset($_GET['bgcolor1'])) {
	$bgcolor1 = $_GET['bgcolor'];
} else {
	$bgcolor1 = BG_COLOR1;
}
*/

/*
   FIXME: you get the idea, eventually the colors should be pickable by a user,
   but we need a real concept of users first
 */

/*
$bgcolor2 = BG_COLOR2;
$bgcolor3 = BG_COLOR3;
$bgcolor4 = BG_COLOR4;
$bgpast = BG_PAST;
$bgfuture = BG_FUTURE;
$sepcolor = SEPCOLOR;
$textcolor1 = TEXTCOLOR1;
$textcolor2 = TEXTCOLOR2;
*/
?>

body {
  font-family: "Open Sans",Verdana, serif;
  font-size: .95em;
  margin: 0 2%;
  background-color: #FFFFFF;
  color: #555;
}

a {
  color: #222;
  background-color: inherit;
  text-decoration: underline;
}

a:hover {
  color: #666;
  background-color: #EFEFE4;
}

h1 {
  font-size: 200%;
  text-align: center;
  font-family: sans-serif;
  color: #000000;
  background-color: inherit;
}

h2 {
  font-size: 175%;
  text-align: center;
  font-family: serif;
  color: #000000;
  background-color: inherit;
}

h3 {
  text-decoration: underline;
}

.phpc-navbar a {
  color: #333;
  background-color: inherit;
  text-decoration: underline;
  font-family: Arial;
  font-weight: bold;
}

.phpc-navbar a:hover {
  background-color: #EFEFE4;
  color: #000;
}

.phpc-navbar {
  margin: 1em 0 1em 0;
  text-align: center;
}

.phpc-navbar a {
  font-size: 90%;
  text-decoration: none;
  margin: 0;
  padding: 10px;
}

.phpc-navbar a.arrow{
  font-size: 14pt;
}

.phpc-main, .phpc-mobile {
  border-style: solid;
  border-collapse: collapse;
  border-color: #CCC;
  border-width: 1px;
  color: #333;
  background-color: #EFEFE4;
  padding: 10px 30px;
}

table.phpc-mobile
{
	width: 370px;
	margin: auto;
	-webkit-box-shadow: 7px 7px 5px 0px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:    7px 7px 5px 0px rgba(50, 50, 50, 0.75);
	box-shadow:         7px 7px 5px 0px rgba(50, 50, 50, 0.75);
}

table.phpc-mobile td, table.phpc-mobile th {padding: 3px 3px 3px 3px;}

table.phpc-main {
  width: 100%;
}

.phpc-main h2, .phpc-mobile h2 {
  margin: 0;
  text-align: left;
  background-color: #555566;
  padding: .25em; 
  border-color: #000000;
  border-style: solid;
  border-width: 0 0 2px 0;
}

.phpc-main div, .phpc-mobile div {
  margin: .5em;
  font-weight: bold;
}

.phpc-hidediv div {
  visibility:hidden;
}

.phpc-main p, .phpc-mobile p {
  border-style: solid;
  border-width: 2px 0 0 0;
  border-color: #000000;
  padding: .5em;
  margin: 0;
  text-align: justify;
}

input, select
{
    color: #444;
    font-size: 90%;
    border: #CCC 1px solid;
    -webkit-border-radius:3px;
	-moz-border-radius:3px;
	border-radius:3px;
	padding:1px 0;
}

input[type="submit"]
{
	position:relative;
	background: #555;
	color: #FFF;
	font-size: 93%;
	padding: 2px 3px;
	margin: 10px 0;
	zoom:1; /* zoom and *display = ie7 hack for display:inline-block */
	overflow: visible; 
	border: 1px solid #777;/* IE Hack*/

	}

.estimate {
	color:#5A7517;
	font-weight: bold;
	font-family: Arial,sans-serif;
	margin: 5px 10px 5px 0;
}

caption {
  font-size: 175%;
  color: #333;
  background-color: #FFFFFF;
  padding: 10px 2px;
  font-weight: bolder;
}

thead th {
  background-color: #444;
  color: #FFFFFF;
  ;
}

thead {
  border: 1px solid #333;
}

thead, tfoot {
  text-align: center;
}

#calendar td, #calendar th {
  border-style: solid;
  border-collapse: collapse;
  border-color: #000000;
  border-width: 1px;
  padding: .5em;
}

table.phpc-main tbody th, table.phpc-mobile tbody th {
  text-align: right;
}

#calendar {
  table-layout: fixed;
}

#calendar td {
  text-align: left;
  /* height: 80px; */
  overflow: hidden;
}

td.past {
  background-color: silver;
  color: inherit;
}

td.future {
  background-color: white;
  color: inherit;
}

td.sa {
	border-bottom: 1px solid #000000;
}

td.none {
  background-color: grey;
  color: inherit;
}

.phpc-list {
  border: 1px solid #000000;
}

.phpc-footer {
  text-align: center;
}

.phpc-button {
  text-align: center;
}

.phpc-add {
  float: right;
  text-align: right;
}

.form-main {
  font-size: 90%;
  border-style: solid;
  border-collapse: collapse;
  border-color: #000000;
  border-width: 2px;
  color: #000000;
  background-color: #CCCCCC;
}

table.form-main {
  width: 100%;
}

table.form-main tbody th {
  text-align: right;
}

div.error-msg-box {
  margin: 8px 0px 8px 0px;
  padding: 4px 4px 4px 4px;
  border: 2px solid #000;
  background-color: #FFFFAA;
  color: #FF0000;
  text-align: center;
  font-weight: bolder;
}

div.info-msg-box {
	margin: 8px 0px 8px 0px; 
	padding: 4px 4px 4px 4px; 
	border: 2px solid #000; 
	background-color: #FFFFDD;
}

/***********************************************************************************************/

.calendar { width: 100%; font-size: 0.75em;/*12*/ line-height: 1.25em;/*15*/ border-collapse: collapse; border-spacing: 0; }

.calendar th { text-align: left; }
.calendar th span { display: none; }

.calendar tr { display: block; }
.calendar td,
.calendar th { display: none; }

.calendar .day { margin: 1em 0 .5em 0; font-weight: bold; }

.calendar .events { display: block; }

.calendar h3 a {text-decoration: none;}

.calendar ul { display: block; list-style: none; margin: 2em 1.25em 0 0;/*15*/ padding: 0; }
.calendar li a { display: block;  left: 0; right: 0; overflow: hidden; text-overflow: ellipsis;  }

.calendar tr td:nth-of-type(1n) .day:before { content: 'Monday '; }
.calendar tr td:nth-of-type(2n) .day:before { content: 'Tuesday '; }
.calendar tr td:nth-of-type(3n) .day:before { content: 'Wednesday '; }
.calendar tr td:nth-of-type(4n) .day:before { content: 'Thursday '; }
.calendar tr td:nth-of-type(5n) .day:before { content: 'Friday '; }
.calendar tr td:nth-of-type(6n) .day:before { content: 'Saturday '; }
.calendar tr td:nth-of-type(7n) .day:before { content: 'Sunday '; }

.calendar .prev-month,
.calendar .next-month { display: none; }

@media only screen and (min-width: 30em) { /*480*/


	.calendar tr { display: table-row; }
	.calendar th, .calendar td { display: table-cell !important; margin: 0; width: 14.2857%; padding: 0.4166em;/*10*/ border: 1px solid #babcbf; vertical-align: top; }

	.calendar .prev-month .day,
	.calendar .next-month .day { color: #bbb; }

	.calendar td .day { display: block; float: right; margin: 0; font-weight: normal; }
	.calendar td .day:before { display: none; }
	.calendar td .suffix { display: none; }
	.car_dive_display
	{
			padding: 3px 3px 3px 3px;
			border: solid 1px #afafaf;
			margin-bottom: 5px;
			border-radius: 5px;
	}

}

@media only screen and (min-width: 40em) { /*640*/

	/* show full days (e.g. "Mon" to "Monday") */
	.calendar th span { display: inline; }
	.car_dive_display
	{
			padding: 3px 3px 3px 3px;
			border: solid 1px #afafaf;
			margin-bottom: 5px;
			border-radius: 5px;
	}
}

@media only screen and (min-width: 40em) and (min-height: 20em) {

	.calendar td { height: 2.5em;/*30*/ }

}
@media only screen and (min-width: 40em) and (min-height: 40em) {

	.calendar td { height: 6.25em;/*75*/ }

}

.modal_dialog .hidden_dialog
{
	display: none;
}

.modal_dialog .visible_dialog
{
	display: block;
}

/************COLLAPSSIBLE**********************/
.collapsible,
.page_collapsible {
    margin: 0;
    padding:10px;
    height:20px;

    border-top:#f0f0f0 1px solid;
    background: #cccccc;

    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-transform:uppercase;
    color: #000;
    font-size:1em;
}

.collapse-open {
    background:#000;
    color: #fff;
}

.collapse-open span {
    display:block;
    float:right;
    padding:10px;
}

.collapse-open span {
    background:url(images/minus.png) center center no-repeat;
}

.collapse-close span {
    display:block;
    float:right;
    background:url(images/plus.png) center center no-repeat;
    padding:10px;
}

div.container {
    padding:0;
    margin:0;
}

div.content {
    background:#f0f0f0;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}
/**********************************************/

