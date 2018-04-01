<div>
<div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?></div>

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
    url:'<?php echo $this->Html->url(array("controller" => "couldntbookcar","action" => "get"));?>' + "/" + new Date().getTime(),
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
    colNames:['id', 'creationtime', 'comment', 'displayname', 'vehicle desired'],
    colModel:[
        {name:'id',index:'id', width:15},
        {name:'creationtime',index:'creationtime', width:100},
        {name:'comment',index:'comment', width:200},
        {name:'displayname',index:'displayname', width:50},
        {name:'name',index:'name', width:100},
    ],
    pager: jQuery('#pager2'),
    rowNum:100,
    rowList:[10,20,50],
    imgpath:  '<?php echo( Router::url('/') ) ?>css/themes/sand/images',
    sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
    caption: "Logs"
});

jQuery("#list2").navGrid('#pager2',{edit:false, add:false, del:false});
});

</script>

<!-- the grid definition in html is a table tag with class 'scroll' -->
<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table>

<!-- pager definition. class scroll tels that we want to use the same theme as grid -->
<div id="pager2" class="scroll" style="text-align:center;"></div>
 

</div>