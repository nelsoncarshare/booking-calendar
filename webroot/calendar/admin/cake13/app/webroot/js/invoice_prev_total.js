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
ncal.admin.invoiceprevtotal2 = {};

ncal.admin.invoiceprevtotal2.onSuccess = function(xmlHtreq){
	if(xmlHtreq.status < 200 || xmlHtreq.status > 299){
		alert("Could not save data to server");
		return false;
	} else {
		return true;
	}
}

ncal.admin.invoiceprevtotal2.onAfterSave = function(rowid,data){
  //not needed
	return true;
}

console.log('3');
jQuery("#list2").jqGrid({
    url: CAKE_GET_URL + '/' + new Date().getTime(),   
    datatype: "json",
    height: 500,
    width:600,
	  jsonReader:{
	        		root: "data",
	        		records: "num",
	        		total: "total",
	        		page: "page",
	        		repeatitems: false,
	        		id: "0"
	      	},
    colNames:['id', 'name', 'previous_owing', 'payment_made'],
    colModel:[
        {name:'id',index:'id', width:50},
        {name:'name',index:'name', width:150},
        {name:'previous_owing',index:'previous_owing', width:100, editable:true, formatter:'currency', align:'right', editrules: { required:true, number:true }  },
        {name:'payment_made',index:'payment_made', width:100, editable:true, formatter:'currency', align:'right', editrules: { required:true, number:true } },
        		
    ],
		onSelectRow: function(id){ 
			if(id && id!==lastsel){ 
				jQuery('#list2').restoreRow(lastsel); 
				jQuery('#list2').editRow(id,true,null,ncal.admin.invoiceprevtotal2.onSuccess,null,null,ncal.admin.invoiceprevtotal2.onAfterSave); 
				lastsel=id; 
			} 
		}, 
		editurl: CAKE_ROOT + "invoiceprevtotal2/post/'+new Date().getTime()", 
    pager: jQuery('#pager2'),
    rowNum:50,
    rowList:[10,20,50],
    imgpath: CAKE_ROOT + 'css/themes/sand/images',
    sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
    caption: "Demo"
});

jQuery("#list2").navGrid('#pager2',{edit:false, add:false, del:false});
});