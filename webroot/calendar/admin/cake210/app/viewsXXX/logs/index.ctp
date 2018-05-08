<div>
<div align="center"><div>[Back To Admin]</div></div>

<?php echo $html->css('themes/sand/grid'); ?>

<?php echo $html->css('jqModal'); ?>

<!-- Of course we should load the jquery library -->
<?php echo $this->Html->script('jqGrid-3.4.3/jquery'); ?>

<?php echo $this->Html->script('jqModal/jqModal'); ?>

<?php echo $this->Html->script('jqModal/jqDnR'); ?>

<?php echo $this->Html->script('jqGrid-3.4.3/all'); ?>

<script type="text/javascript">
// We use a document ready jquery function.
function registerNS(ns)
{
 var nsParts = ns.split(".");
 var root = window;

 for(var i=0; i<nsParts.length; i++)
 {
  if(typeof root[nsParts[i]] == "undefined")
   root[nsParts[i]] = new Object();

  root = root[nsParts[i]];
 }
}

registerNS("ncal.admin");

jQuery(document).ready(function(){
var lastsel;

ncal.admin.logs = {};

ncal.admin.logs.onSuccess = function(xmlHtreq){
	if(xmlHtreq.status < 200 || xmlHtreq.status > 299){
		alert("Could not save data to server");
		return false;
	} else {
		return true;
	}
}

ncal.admin.logs.onAfterSave = function(rowid,data){
  //not needed
	return true;
}

jQuery("#list2").jqGrid({

    url: '<?php echo( Router::url('/') ) ?>' + 'logs/get/' + new Date().getTime(),
    datatype: "json",
    height: 600,
    width:1000,
	  jsonReader:{
	        		root: "data",
	        		records: "num",
	        		total: "total",
	        		page: "page",
	        		repeatitems: false,
	        		id: "0"
	      	},
    colNames:['id', 'starttime', 'endtime', 'subject', 'note', 'bookableobject', 'canceled', 'modifiedByUid','is for','operation','amntTagged','created'],
    colModel:[
        {name:'id',index:'id', width:15},
        {name:'starttime',index:'starttime', width:100},
        {name:'endtime',index:'endtime', width:100},
        {name:'subject',index:'subject', width:50},
        {name:'note',index:'note', width:50},
        {name:'name',index:'name', width:100},
        {name:'canceled',index:'canceled', width:20, editable:false, formatter:'select', edittype:'select', editoptions:{value:{0:'No',1:'Yes'}}},
        {name:'displaynameMod',index:'displaynameMod', width:100},
        {name:'displaynameFor',index:'displaynameFor', width:100},
        {name:'operation',index:'operation', width:35, editable:false, formatter:'select', edittype:'select', editoptions:{value:{1:'Create',2:'Modify',3:'Cancel',4:'Cancel in no refund',8:'Login'}}},
        {name:'amntTagged',index:'amntTagged', width:50}, 	
        {name:'created',index:'created', width:100}	
    ],
    pager: jQuery('#pager2'),
    rowNum:100,
    rowList:[10,20,50],
    imgpath: '<?php echo( Router::url('/') ) ?>css/themes/sand/images',
    sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
    caption: "Logs"
});

jQuery("#list2").navGrid('#pager2',{edit:false, add:false, del:false});
});

function doSearch(ev){ 
    if(!flAuto) 
        return; // var elem = ev.target||ev.srcElement; 
    if(timeoutHnd) 
        clearTimeout(timeoutHnd) 
        timeoutHnd = setTimeout(gridReload,500) 
} 

function gridReload(){ 
    var mod_name = jQuery("#mod_by_name").val();  
    var booking_is_for_name = jQuery("#booking_is_for_name").val();
    var start_aft_dt = jQuery("#start_aft_dt").val();
    var start_bef_dt = jQuery("#start_bef_dt").val();
    var end_aft_dt = jQuery("#end_aft_dt").val();
    var end_bef_dt = jQuery("#end_bef_dt").val();
    var create_aft_dt = jQuery("#cre_aft_dt").val();
    var create_bef_dt = jQuery("#cre_bef_dt").val();
    var bookable = jQuery("#bookable").val();
    var event_type = jQuery("#event_type").val();
    jQuery("#list2").setGridParam({url: '<?php echo( Router::url('/') ) ?>' + "logs/get?mod_nm=" + mod_name + "&for_nm=" + booking_is_for_name + "&sta_a_dt=" + start_aft_dt + "&sta_b_dt=" + start_bef_dt + "&end_a_dt=" + end_aft_dt + "&end_b_dt=" + end_bef_dt + "&cre_a_dt=" + create_aft_dt + "&cre_b_dt=" + create_bef_dt + "&bookable=" + bookable + "&ev_type=" + event_type,page:1});   
    jQuery("#list2").trigger("reloadGrid"); 
}

</script>



    modified by: 
        <select id='mod_by_name'>
            <option value='-1'>ANY</option>
            <?php
                foreach ($users as $u){
                    echo("<option value=" . $u['User']['id'] . ">".$u['User']['displayname']."</option>");
                }
            ?>
        </select>
    <br/>
    booking is for:
        <select id='booking_is_for_name'>
            <option value='-1'>ANY</option>
            <?php
                foreach ($users as $u){
                    echo("<option value=" . $u['User']['id'] . ">".$u['User']['displayname']."</option>");
                }
            ?>
        </select>    
    <br/>
    start time of event is after <input type='text' id='start_aft_dt'> and before <input type='text' id='start_bef_dt'> (blank fields are ignored) <br/>
    end time of event is after <input type='text' id='end_aft_dt'> and before <input type='text' id='end_bef_dt'> (blank fields are ignored) <br/>
    create/modify time of record is after <input type='text' id='cre_aft_dt'> and before <input type='text' id='cre_bef_dt'> (blank fields are ignored) <br/>
    bookable object:
        <select id='bookable'>
            <option value='-1'>ANY</option>
            <?php
                foreach ($bookables as $b){
                    echo("<option value=" . $b['Bookable']['id'] . ">".$b['Bookable']['name']."</option>");
                }
            ?>    
        </select>
    <br/>
    event type: <select id='event_type'>
                       <option value='-1'>ANY</option>
                       <option value='1'>Create</option>
                       <option value='2'>Modify</option>
                       <option value='3'>Cancel</option>
                       <option value='8'>Login</option>
                </select>
    <br/>
    <button onclick="gridReload()" id="submitButton" style="margin-left:30px;">Search</button> 

<!-- the grid definition in html is a table tag with class 'scroll' -->
<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table>

<!-- pager definition. class scroll tels that we want to use the same theme as grid -->
<div id="pager2" class="scroll" style="text-align:center;"></div>

<a href="javascript:void(0)" id="g1" onclick="deb();">Get url</a> 

</div>