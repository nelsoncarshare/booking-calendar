;(function($){
/**
 * jqGrid English Translation
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.jgrid = {};

$.jgrid.defaults = {
	recordtext: "Row(s)",
	loadtext: "Loading...",
	pgtext : "/"
};
$.jgrid.search = {
    caption: "Search...",
    Find: "Find",
    Reset: "Reset",
    odata : ['equal', 'not equal', 'less', 'less or equal','greater','greater or equal', 'begins with','ends with','contains' ]
};
$.jgrid.edit = {
    addCaption: "Add Record",
    editCaption: "Edit Record",
    bSubmit: "Submit",
    bCancel: "Cancel",
	bClose: "Close",
    processData: "Processing...",
    msg: {
        required:"Field is required",
        number:"Please, enter valid number",
        minValue:"value must be greater than or equal to ",
        maxValue:"value must be less than or equal to",
        email: "is not a valid e-mail",
        integer: "Please, enter valid integer value",
		date: "Please, enter valid date value"
    }
};
$.jgrid.del = {
    caption: "Delete",
    msg: "Delete selected record(s)?",
    bSubmit: "Delete",
    bCancel: "Cancel",
    processData: "Processing..."
};
$.jgrid.nav = {
	edittext: " ",
    edittitle: "Edit selected row",
	addtext:" ",
    addtitle: "Add new row",
    deltext: " ",
    deltitle: "Delete selected row",
    searchtext: " ",
    searchtitle: "Find records",
    refreshtext: "",
    refreshtitle: "Reload Grid",
    alertcap: "Warning",
    alerttext: "Please, select row"
};
// setcolumns module
$.jgrid.col ={
    caption: "Show/Hide Columns",
    bSubmit: "Submit",
    bCancel: "Cancel"	
};
$.jgrid.errors = {
	errcap : "Error",
	nourl : "No url is set",
	norecords: "No records to process",
    model : "Length of colNames <> colModel!"
};
$.jgrid.formatter = {
	integer : {thousandsSeparator: " ", defaulValue: 0},
	number : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, defaulValue: 0},
	currency : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix:"", defaulValue: 0},
	date : {
		dayNames:   [
			"Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat",
			"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
		],
		monthNames: [
			"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
			"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
		],
		AmPm : ["am","pm","AM","PM"],
		S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'},
		srcformat: 'Y-m-d',
		newformat: 'd/m/Y',
		masks : {
            ISO8601Long:"Y-m-d H:i:s",
            ISO8601Short:"Y-m-d",
            ShortDate: "n/j/Y",
            LongDate: "l, F d, Y",
            FullDateTime: "l, F d, Y g:i:s A",
            MonthDay: "F d",
            ShortTime: "g:i A",
            LongTime: "g:i:s A",
            SortableDateTime: "Y-m-d\\TH:i:s",
            UniversalSortableDateTime: "Y-m-d H:i:sO",
            YearMonth: "F, Y"
        },
        reformatAfterEdit : false
	},
	baseLinkUrl: '',
	showAction: 'show',
	addParam : ''
};
// US
// GB
// CA
// AU
})(jQuery);
;(function ($) {
/*
 * jqGrid  3.4.3 - jQuery Grid
 * Copyright (c) 2008, Tony Tomov, tony@trirand.com
 * Dual licensed under the MIT and GPL licenses
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * Date: 2009-03-12 rev 84
 */
$.fn.jqGrid = function( p ) {
	p = $.extend(true,{
	url: "",
	height: 150,
	page: 1,
	rowNum: 20,
	records: 0,
	pager: "",
	pgbuttons: true,
	pginput: true,
	colModel: [],
	rowList: [],
	colNames: [],
	sortorder: "asc",
	sortname: "",
	datatype: "xml",
	mtype: "GET",
	imgpath: "",
	sortascimg: "sort_asc.gif",
	sortdescimg: "sort_desc.gif",
	firstimg: "first.gif",
	previmg: "prev.gif",
	nextimg: "next.gif",
	lastimg: "last.gif",
	altRows: true,
	selarrrow: [],
	savedRow: [],
	shrinkToFit: true,
	xmlReader: {},
	jsonReader: {},
	subGrid: false,
	subGridModel :[],
	lastpage: 0,
	lastsort: 0,
	selrow: null,
	beforeSelectRow: null,
	onSelectRow: null,
	onSortCol: null,
	ondblClickRow: null,
	onRightClickRow: null,
	onPaging: null,
	onSelectAll: null,
	loadComplete: null,
	gridComplete: null,
	loadError: null,
	loadBeforeSend: null,
	afterInsertRow: null,
	beforeRequest: null,
	onHeaderClick: null,
	viewrecords: false,
	loadonce: false,
	multiselect: false,
	multikey: false,
	editurl: null,
	search: false,
	searchdata: {},
	caption: "",
	hidegrid: true,
	hiddengrid: false,
	postData: {},
	userData: {},
	treeGrid : false,
	treeGridModel : 'nested',
	treeReader : {},
	treeANode : 0,
	ExpandColumn: null,
	tree_root_level : 0,
	prmNames: {page:"page",rows:"rows", sort: "sidx",order: "sord"},
	sortclass: "grid_sort",
	resizeclass: "grid_resize",
	forceFit : false,
	gridstate : "visible",
	cellEdit: false,
	cellsubmit: "remote",
	nv:0,
	loadui: "enable",
	toolbar: [false,""],
	scroll: false,
	multiboxonly : false,
	scrollrows : false,
	deselectAfterSort: true
	}, $.jgrid.defaults, p || {});
	var grid={         
		headers:[],
		cols:[],
		dragStart: function(i,x) {
			this.resizing = { idx: i, startX: x};
			this.hDiv.style.cursor = "e-resize";
		},
		dragMove: function(x) {
			if(this.resizing) {
				var diff = x-this.resizing.startX,
				h = this.headers[this.resizing.idx],
				newWidth = h.width + diff, hn, nWn;
				if(newWidth > 25) {
					if(p.forceFit===true ){
						hn = this.headers[this.resizing.idx+p.nv];
						nWn = hn.width - diff;
						if(nWn >25) {
							h.el.style.width = newWidth+"px";
							h.newWidth = newWidth;
							this.cols[this.resizing.idx].style.width = newWidth+"px";
							hn.el.style.width = nWn +"px";
							hn.newWidth = nWn;
							this.cols[this.resizing.idx+p.nv].style.width = nWn+"px";
							this.newWidth = this.width;
						}
					} else {
						h.el.style.width = newWidth+"px";
						h.newWidth = newWidth;
						this.cols[this.resizing.idx].style.width = newWidth+"px";
						this.newWidth = this.width+diff;
						$('table:first',this.bDiv).css("width",this.newWidth +"px");
						$('table:first',this.hDiv).css("width",this.newWidth +"px");
						this.hDiv.scrollLeft = this.bDiv.scrollLeft;
					}
				}
			}
		},
		dragEnd: function() {
			this.hDiv.style.cursor = "default";
			if(this.resizing) {
				var idx = this.resizing.idx;
				this.headers[idx].width = this.headers[idx].newWidth || this.headers[idx].width;
				this.cols[idx].style.width = this.headers[idx].newWidth || this.headers[idx].width;
				// here code to set the width in colmodel
				if(p.forceFit===true){
					this.headers[idx+p.nv].width = this.headers[idx+p.nv].newWidth || this.headers[idx+p.nv].width;
					this.cols[idx+p.nv].style.width = this.headers[idx+p.nv].newWidth || this.headers[idx+p.nv].width;
				}
				if(this.newWidth) {this.width = this.newWidth;}
				this.resizing = false;
			}
		},
		scrollGrid: function() {
			if(p.scroll === true) {
				var scrollTop = this.bDiv.scrollTop;
				if (scrollTop != this.scrollTop) {
					this.scrollTop = scrollTop;
					if ((this.bDiv.scrollHeight-scrollTop-$(this.bDiv).height()) <= 0) {
						if(parseInt(p.page,10)+1<=parseInt(p.lastpage,10)) {
							p.page = parseInt(p.page,10)+1;
							this.populate();
						}
					}
				}
			}
			this.hDiv.scrollLeft = this.bDiv.scrollLeft;
		}
	};
	$.fn.getGridParam = function(pName) {
		var $t = this[0];
		if (!$t.grid) {return;}
		if (!pName) { return $t.p; }
		else {return $t.p[pName] ? $t.p[pName] : null;}
	};
	$.fn.setGridParam = function (newParams){
		return this.each(function(){
			if (this.grid && typeof(newParams) === 'object') {$.extend(true,this.p,newParams);}
		});
	};
	$.fn.getDataIDs = function () {
		var ids=[];
		this.each(function(){
			$(this.rows).slice(1).each(function(i){
				ids[i]=this.id;
			});
		});
		return ids;
	};
	$.fn.setSortName = function (newsort) {
		return this.each(function(){
			var $t = this;
			for(var i=0;i< $t.p.colModel.length;i++){
				if($t.p.colModel[i].name===newsort || $t.p.colModel[i].index===newsort){
					$("tr th:eq("+$t.p.lastsort+") div img",$t.grid.hDiv).remove();
					$t.p.lastsort = i;
					$t.p.sortname=newsort;
					break;
				}
			}
		});
	};
	$.fn.setSelection = function(selection,onsr,sd) {
		return this.each(function(){
			var $t = this, stat,pt, ind;
			onsr = onsr === false ? false : true;
			if(selection===false) {pt = sd;}
			else { ind = $($t).getInd($t.rows,selection); pt=$($t.rows[ind]);}
			selection = $(pt).attr("id");
			if (!pt.html()) {return;}
			if($t.p.selrow && $t.p.scrollrows===true) {
				var olr = $($t).getInd($t.rows,$t.p.selrow);
				var ner = $($t).getInd($t.rows,selection);
				if(ner >=0 ){
					if(ner > olr ) {
						scrGrid(ner,'d');
					} else {
						scrGrid(ner,'u');
					}
				}
			}
			if(!$t.p.multiselect) {
				if($(pt).attr("class") !== "subgrid") {
				if( $t.p.selrow ) {$("tr#"+$t.p.selrow.replace(".", "\\."),$t.grid.bDiv).removeClass("selected");}
				$t.p.selrow = selection;
				$(pt).addClass("selected");
				if( $t.p.onSelectRow && onsr) { $t.p.onSelectRow($t.p.selrow, true); }
				}
			} else {
				$t.p.selrow = selection;
				var ia = $.inArray($t.p.selrow,$t.p.selarrrow);
				if (  ia === -1 ){ 
					if($(pt).attr("class") !== "subgrid") { $(pt).addClass("selected");}
					stat = true;
					$("#jqg_"+$t.p.selrow.replace(".", "\\.") ,$t.rows).attr("checked",stat);
					$t.p.selarrrow.push($t.p.selrow);
					if( $t.p.onSelectRow && onsr) { $t.p.onSelectRow($t.p.selrow, stat); }
				} else {
					if($(pt).attr("class") !== "subgrid") { $(pt).removeClass("selected");}
					stat = false;
					$("#jqg_"+$t.p.selrow.replace(".", "\\.") ,$t.rows).attr("checked",stat);
					$t.p.selarrrow.splice(ia,1);
					if( $t.p.onSelectRow && onsr) { $t.p.onSelectRow($t.p.selrow, stat); }
					var tpsr = $t.p.selarrrow[0];
					$t.p.selrow = (tpsr==undefined) ? null : tpsr;
				}
			}
			function scrGrid(iR,tp){
				var ch = $($t.grid.bDiv)[0].clientHeight,
				st = $($t.grid.bDiv)[0].scrollTop,
				nROT = $t.rows[iR].offsetTop+$t.rows[iR].clientHeight,
				pROT = $t.rows[iR].offsetTop;
				if(tp == 'd') {
					if(nROT >= ch) { $($t.grid.bDiv)[0].scrollTop = st + nROT-pROT; }
				}
				if(tp == 'u'){
					if (pROT < st) { $($t.grid.bDiv)[0].scrollTop = st - nROT+pROT; }
				}
			}
		});
	};
	$.fn.resetSelection = function(){
		return this.each(function(){
			var t = this, ind;
			if(!t.p.multiselect) {
				if(t.p.selrow) {
					$("tr#"+t.p.selrow.replace(".", "\\."),t.grid.bDiv).removeClass("selected");
					t.p.selrow = null;
				}
			} else {
				$(t.p.selarrrow).each(function(i,n){
					ind = $(t).getInd(t.rows,n);
					$(t.rows[ind]).removeClass("selected");
					$("#jqg_"+n.replace(".", "\\."),t.rows[ind]).attr("checked",false);
				});
				$("#cb_jqg",t.grid.hDiv).attr("checked",false);
				t.p.selarrrow = [];
			}
		});
	};
	$.fn.getRowData = function( rowid ) {
		var res = {};
		if (rowid){
			this.each(function(){
				var $t = this,nm,ind;
				ind = $($t).getInd($t.rows,rowid);
				if (!ind) {return res;}
				$('td',$t.rows[ind]).each( function(i) {
					nm = $t.p.colModel[i].name; 
					if ( nm !== 'cb' && nm !== 'subgrid') {
						if($t.p.treeGrid===true && nm == $t.p.ExpandColumn) {
							res[nm] = $.htmlDecode($("span:first",this).html());
						} else {
							res[nm] = $.htmlDecode($(this).html());
						}
					}
				});
			});
		}
		return res;
	};
	$.fn.delRowData = function(rowid) {
		var success = false, rowInd, ia;
		if(rowid) {
			this.each(function() {
				var $t = this;
				rowInd = $($t).getInd($t.rows,rowid);
				if(!rowInd) {return false;}
				else {
					$($t.rows[rowInd]).remove();
					$t.p.records--;
					$t.updatepager();
					success=true;
					if(rowid == $t.p.selrow) {$t.p.selrow=null;}
					ia = $.inArray(rowid,$t.p.selarrrow);
					if(ia != -1) {$t.p.selarrrow.splice(ia,1);}
				}
				if(rowInd == 1 && success && ($.browser.opera || $.browser.safari)) {
					$($t.rows[1]).each( function( k ) {
						$(this).css("width",$t.grid.headers[k].width+"px");
						$t.grid.cols[k] = this;
					});
				}
				if( $t.p.altRows === true && success) {
					$($t.rows).slice(1).each(function(i){
						if(i % 2 ==1) {$(this).addClass('alt');}
						else {$(this).removeClass('alt');}
					});
				}
			});
		}
		return success;
	};
	$.fn.setRowData = function(rowid, data) {
		var nm, success=false;
		this.each(function(){
			var t = this, vl, ind, ttd;
			if(!t.grid) {return false;}
			if( data ) {
				ind = $(t).getInd(t.rows,rowid);
				if(!ind) {return false;}
				success=true;
				$(this.p.colModel).each(function(i){
					nm = this.name;
					vl = data[nm];
					if( vl !== undefined ) {
						if(t.p.treeGrid===true && nm == t.p.ExpandColumn) {
							ttd = $("td:eq("+i+") > span:first",t.rows[ind]);
						} else {
							ttd = $("td:eq("+i+")",t.rows[ind]); 
						}
						t.formatter(ttd, t.rows[ind], vl, i, 'edit');
						success = true;
					}
				});
			}
		});
		return success;
	};
	$.fn.addRowData = function(rowid,data,pos,src) {
		if(!pos) {pos = "last";}
		var success = false, nm, row, td, gi=0, si=0,sind, i;
		if(data) {
			this.each(function() {
				var t = this;
				row =  document.createElement("tr");
				row.id = rowid || t.p.records+1;
				$(row).addClass("jqgrow");
				if(t.p.multiselect) {
					td = $('<td></td>');
					$(td[0],t.grid.bDiv).html("<input type='checkbox'"+" id='jqg_"+rowid+"' class='cbox'/>");
					row.appendChild(td[0]);
					gi = 1;
				}
				if(t.p.subGrid ) { try {$(t).addSubGrid(t.grid.bDiv,row,gi);} catch(e){} si=1;}
				for(i = gi+si; i < this.p.colModel.length;i++){
					nm = this.p.colModel[i].name;
					td  = $('<td></td>');
					t.formatter(td, row, data[nm], i, 'add');
					t.formatCol($(td[0],t.grid.bDiv),i);
					row.appendChild(td[0]);
				}
				switch (pos) {
					case 'last':
						$(t.rows[t.rows.length-1]).after(row);
						break;
					case 'first':
						$(t.rows[0]).after(row);
						break;
					case 'after':
						sind = $(t).getInd(t.rows,src);
						sind >= 0 ?	$(t.rows[sind]).after(row): "";
						break;
					case 'before':
						sind = $(t).getInd(t.rows,src);
						sind > 0 ?	$(t.rows[sind-1]).after(row): "";
						break;
				}
				t.p.records++;
				if($.browser.safari || $.browser.opera) {
					t.scrollLeft = t.scrollLeft;
					$("td",t.rows[1]).each( function( k ) {
						$(this).css("width",t.grid.headers[k].width+"px");
						t.grid.cols[k] = this;
					});
				}
				if( t.p.altRows === true ) {
					if (pos == "last") {
						if (t.rows.length % 2 == 1)  {$(row).addClass('alt');}
					} else {
						$(t.rows).slice(1).each(function(i){
							if(i % 2 ==1) {$(this).addClass('alt');}
							else {$(this).removeClass('alt');}
						});
					}
				}
				try {t.p.afterInsertRow(row.id,data); } catch(e){}
				t.updatepager();
				success = true;
			});
		}
		return success;
	};
	$.fn.hideCol = function(colname) {
		return this.each(function() {
			var $t = this,w=0, fndh=false, gtw;
			if (!$t.grid ) {return;}
			if( typeof colname == 'string') {colname=[colname];}
			$(this.p.colModel).each(function(i) {
				if ($.inArray(this.name,colname) != -1 && !this.hidden) {
					w = parseInt($("tr th:eq("+i+")",$t.grid.hDiv).css("width"),10);
 					$("tr th:eq("+i+")",$t.grid.hDiv).css({display:"none"});
					$($t.rows).each(function(j){
						$("td:eq("+i+")",$t.rows[j]).css({display:"none"});
					});
					$t.grid.cols[i].style.width = 0;
					$t.grid.headers[i].width = 0;
					$t.grid.width -= w;
					this.hidden=true;
					fndh=true;
				}
			});
			if(fndh===true) {
				gtw = Math.min($t.p._width,$t.grid.width);
				$("table:first",$t.grid.hDiv).width(gtw);
				$("table:first",$t.grid.bDiv).width(gtw);
				$($t.grid.hDiv).width(gtw);
				$($t.grid.bDiv).width(gtw);
				if($t.p.pager && $($t.p.pager).hasClass("scroll") ) {
					$($t.p.pager).width(gtw);
				}
				if($t.p.caption) {$($t.grid.cDiv).width(gtw);}
				if($t.p.toolbar[0]) {$($t.grid.uDiv).width(gtw);}
				$t.grid.hDiv.scrollLeft = $t.grid.bDiv.scrollLeft;
			}
		});
	};
	$.fn.showCol = function(colname) {
		return this.each(function() {
			var $t = this, w = 0, fdns=false, gtw, ofl;
			if (!$t.grid ) {return;}
			if( typeof colname == 'string') {colname=[colname];}
			$($t.p.colModel).each(function(i) {
				if ($.inArray(this.name,colname) != -1 && this.hidden) {
					w = parseInt($("tr th:eq("+i+")",$t.grid.hDiv).css("width"),10);
					$("tr th:eq("+i+")",$t.grid.hDiv).css("display","");
					$($t.rows).each(function(j){
						$("td:eq("+i+")",$t.rows[j]).css("display","").width(w);
					});
					this.hidden=false;
					$t.grid.cols[i].style.width = w;
					$t.grid.headers[i].width =  w;
					$t.grid.width += w;
					fdns=true;
				}
			});
			if(fdns===true) {
				gtw = Math.min($t.p._width,$t.grid.width);
				ofl = ($t.grid.width <= $t.p._width) ? "hidden" : "auto";
				$("table:first",$t.grid.hDiv).width(gtw);
				$("table:first",$t.grid.bDiv).width(gtw);
				$($t.grid.hDiv).width(gtw);
				$($t.grid.bDiv).width(gtw).css("overflow-x",ofl);
				if($t.p.pager && $($t.p.pager).hasClass("scroll") ) {
					$($t.p.pager).width(gtw);
				}
				if($t.p.caption) {$($t.grid.cDiv).width(gtw);}
				if($t.p.toolbar[0]) {$($t.grid.uDiv).width(gtw);}
				$t.grid.hDiv.scrollLeft = $t.grid.bDiv.scrollLeft;
			}
		});
	};
	$.fn.setGridWidth = function(nwidth, shrink) {
		return this.each(function(){
			var $t = this, chw=0,w,cw,ofl;
			if (!$t.grid ) {return;}
			if(typeof shrink != 'boolean') {shrink=true;}
			var testdata = getScale();
			if(shrink !== true) {testdata[0] = Math.min($t.p._width,$t.grid.width); testdata[2]=0;}
			else {testdata[2]= testdata[1]}
			$.each($t.p.colModel,function(i,v){
				if(!this.hidden && this.name != 'cb' && this.name!='subgrid') {
					cw = shrink !== true ? $("tr:first th:eq("+i+")",$t.grid.hDiv).css("width") : this.width;
					w = Math.floor((IENum(nwidth)-IENum(testdata[2]))/IENum(testdata[0])*IENum(cw));
					chw += w;
					$("table thead tr:first th:eq("+i+")",$t.grid.hDiv).css("width",w+"px");
					$("table:first tbody tr:first td:eq("+i+")",$t.grid.bDiv).css("width",w+"px");
					$t.grid.cols[i].style.width = w;
					$t.grid.headers[i].width =  w;
				}
				if(this.name=='cb' || this.name == 'subgrid'){chw += IENum(this.width);}
			});
			if(chw + testdata[1] <= nwidth || $t.p.forceFit === true){ ofl = "hidden"; tw = nwidth;}
			else { ofl= "auto"; tw = chw + testdata[1];}
			$("table:first",$t.grid.hDiv).width(tw);
			$("table:first",$t.grid.bDiv).width(tw);
			$($t.grid.hDiv).width(nwidth);
			$($t.grid.bDiv).width(nwidth).css("overflow-x",ofl);
			if($t.p.pager && $($t.p.pager).hasClass("scroll") ) {
				$($t.p.pager).width(nwidth);
			}
			if($t.p.caption) {$($t.grid.cDiv).width(nwidth);}
			if($t.p.toolbar[0]) {$($t.grid.uDiv).width(nwidth);}
			$t.p._width = nwidth; $t.grid.width = tw;
			if($.browser.safari || $.browser.opera ) {
				$("table tbody tr:eq(1) td",$t.grid.bDiv).each( function( k ) {
					$(this).css("width",$t.grid.headers[k].width+"px");
					$t.grid.cols[k] = this;
				});
			}
			$t.grid.hDiv.scrollLeft = $t.grid.bDiv.scrollLeft;
			function IENum(val) {
				val = parseInt(val,10);
				return isNaN(val) ? 0 : val;
			}
			function getScale(){
				var testcell = $("table tr:first th:eq(1)", $t.grid.hDiv);
				var addpix = IENum($(testcell).css("padding-left")) +
					IENum($(testcell).css("padding-right"))+
					IENum($(testcell).css("border-left-width"))+
					IENum($(testcell).css("border-right-width"));
				var w =0,ap=0; 
				$.each($t.p.colModel,function(i,v){
					if(!this.hidden) {
						w += parseInt(this.width);
						ap += addpix;
					}
				});
				return [w,ap,0];
			}
		});
	};
	$.fn.setGridHeight = function (nh) {
		return this.each(function (){
			var ovfl, ovfl2, $t = this;
			if(!$t.grid) {return;}
			if($t.p.forceFit === true) { ovfl2='hidden'; } else {ovfl2=$($t.grid.bDiv).css("overflow-x");}
			ovfl = (isNaN(nh) && $.browser.mozilla && (nh.indexOf("%")!=-1 || nh=="auto")) ? "hidden" : "auto";
			$($t.grid.bDiv).css({height: nh+(isNaN(nh)?"":"px"),"overflow-y":ovfl,"overflow-x": ovfl2});
			$t.p.height = nh;
		});
	};
	$.fn.setCaption = function (newcap){
		return this.each(function(){
			this.p.caption=newcap;
			$("table:first th",this.grid.cDiv).html(newcap);
			$(this.grid.cDiv).show();
		});
	};
	$.fn.setLabel = function(colname, nData, prop, attrp ){
		return this.each(function(){
			var $t = this, pos=-1;
			if(!$t.grid) {return;}
			if(isNaN(colname)) {
				$($t.p.colModel).each(function(i){
					if (this.name == colname) {
						pos = i;return false;
					}
				});
			} else {pos = parseInt(colname,10);}
			if(pos>=0) {
				var thecol = $("table:first th:eq("+pos+")",$t.grid.hDiv);
				if (nData){
					$("div",thecol).html(nData);
				}
				if (prop) {
					if(typeof prop == 'string') {$(thecol).addClass(prop);} else {$(thecol).css(prop);}
				}
				if(typeof attrp == 'object') {$(thecol).attr(attrp);}
			}
		});
	};
	$.fn.setCell = function(rowid,colname,nData,cssp,attrp) {
		return this.each(function(){
			var $t = this, pos =-1;
			if(!$t.grid) {return;}
			if(isNaN(colname)) {
				$($t.p.colModel).each(function(i){
					if (this.name == colname) {
						pos = i;return false;
					}
				});
			} else {pos = parseInt(colname,10);}
			if(pos>=0) {
				var ind = $($t).getInd($t.rows,rowid);
				if (ind>=0){
					var tcell = $("td:eq("+pos+")",$t.rows[ind]);
					if(nData != "") {
						$t.formatter(tcell, $t.rows[ind], nData, pos,'edit');
					}
					if (cssp){
						if(typeof cssp == 'string') {$(tcell).addClass(cssp);} else {$(tcell).css(cssp);}
					}
					if(typeof attrp == 'object') {$(tcell).attr(attrp);}
				}
			}
		});
	};
	$.fn.getCell = function(rowid,col) {
		var ret = false;
		this.each(function(){
			var $t=this, pos=-1;
			if(!$t.grid) {return;}
			if(isNaN(col)) {
				$($t.p.colModel).each(function(i){
					if (this.name == col) {
						pos = i;return false;
					}
				});
			} else {pos = parseInt(col,10);}
			if(pos>=0) {
				var ind = $($t).getInd($t.rows,rowid);
				if(ind>=0) {
					ret = $.htmlDecode($("td:eq("+pos+")",$t.rows[ind]).html());
				}
			}
		});
		return ret;
	};
	$.fn.clearGridData = function() {
		return this.each(function(){
			var $t = this;
			if(!$t.grid) {return;}
			$("tbody tr:gt(0)", $t.grid.bDiv).remove();
			$t.p.selrow = null; $t.p.selarrrow= []; $t.p.savedRow = [];
			$t.p.records = '0';$t.p.page='0';$t.p.lastpage='0';
			$t.updatepager();
		});
	};
	$.fn.getInd = function(obj,rowid,rc){
		var ret =false;
		$(obj).each(function(i){
			if(this.id==rowid) {
				ret = rc===true ? this : i;
				return false;
			}
		});
		return ret;
	};
	$.htmlDecode = function(value){
		if(value=='&nbsp;' || value=='&#160;') {value = "";}
		return !value ? value : String(value).replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"');
	};
	return this.each( function() {
		if(this.grid) {return;}
		this.p = p ;
		if(this.p.colNames.length === 0) {
			for (var i=0;i<this.p.colModel.length;i++){
				this.p.colNames[i] = this.p.colModel[i].label || this.p.colModel[i].name;
			}
		}
		if( this.p.colNames.length !== this.p.colModel.length ) {
			alert($.jgrid.errors.model);
			return;
		}
		if(this.p.imgpath !== "" ) {this.p.imgpath += "/";}
		$("<div class='loadingui' id=lui_"+this.id+"><div class='msgbox'>"+this.p.loadtext+"</div></div>").insertBefore(this);
		$(this).attr({cellSpacing:"0",cellPadding:"0",border:"0"});
		var ts = this,
		bSR = $.isFunction(this.p.beforeSelectRow) ? this.p.beforeSelectRow :false,
		onSelectRow = $.isFunction(this.p.onSelectRow) ? this.p.onSelectRow :false,
		ondblClickRow = $.isFunction(this.p.ondblClickRow) ? this.p.ondblClickRow :false,
		onSortCol = $.isFunction(this.p.onSortCol) ? this.p.onSortCol : false,
		loadComplete = $.isFunction(this.p.loadComplete) ? this.p.loadComplete : false,
		loadError = $.isFunction(this.p.loadError) ? this.p.loadError : false,
		loadBeforeSend = $.isFunction(this.p.loadBeforeSend) ? this.p.loadBeforeSend : false,
		onRightClickRow = $.isFunction(this.p.onRightClickRow) ? this.p.onRightClickRow : false,
		afterInsRow = $.isFunction(this.p.afterInsertRow) ? this.p.afterInsertRow : false,
		onHdCl = $.isFunction(this.p.onHeaderClick) ? this.p.onHeaderClick : false,
		beReq = $.isFunction(this.p.beforeRequest) ? this.p.beforeRequest : false,
		onSC = $.isFunction(this.p.onCellSelect) ? this.p.onCellSelect : false,
		sortkeys = ["shiftKey","altKey","ctrlKey"];
		if ($.inArray(ts.p.multikey,sortkeys) == -1 ) {ts.p.multikey = false;}
		var IntNum = function(val,defval) {
			val = parseInt(val,10);
			if (isNaN(val)) { return (defval) ? defval : 0;}
			else {return val;}
		};
		var formatCol = function (elem, pos){
			var ral = ts.p.colModel[pos].align;
			if(ral) { $(elem).css("text-align",ral);}
			if(ts.p.colModel[pos].hidden) {$(elem).css("display","none");}
		};
		var resizeFirstRow = function (t,er){
			$("tbody tr:eq("+er+") td",t).each( function( k ) {
				$(this).css("width",grid.headers[k].width+"px");
				grid.cols[k] = this;
			});
		};
		var addCell = function(t,row,cell,pos) {
			var td;
			td = document.createElement("td");
			formatter($(td,t),row,cell,pos,'add');			
			row.appendChild(td);
			formatCol($(td,t), pos);
		};
		var formatter = function (elem, row, cellval , colpos, act){
			var cm = ts.p.colModel[colpos]; 
			if(cm.formatter) {
				var opts= {rowId: row.id, colModel:cm,rowData:row};
				if($.isFunction( cm.formatter ) ) {
					cm.formatter(elem,cellval,opts,act);
				} else if($.fmatter){
					$(elem).fmatter(cm.formatter, cellval,opts, act);
				} else {
					$(elem).html(cellval || '&#160;');
				}
			}else {
				$(elem).html(cellval || '&#160;');
			}
			elem[0].title = elem[0].textContent || elem[0].innerText;
		};
		var addMulti = function(t,row){
			var cbid,td;
			td = document.createElement("td");
			cbid = "jqg_"+row.id;
			$(td,t).html("<input type='checkbox'"+" id='"+cbid+"' class='cbox'/>");
			formatCol($(td,t), 0);
			row.appendChild(td);
		};
		var reader = function (datatype) {
			var field, f=[], j=0, i;
			for(i =0; i<ts.p.colModel.length; i++){
				field = ts.p.colModel[i];
				if (field.name !== 'cb' && field.name !=='subgrid') {
					f[j] = (datatype=="xml") ? field.xmlmap || field.name : field.jsonmap || field.name;
					j++;
				}
			}
			return f;
		};
		var addXmlData = function addXmlData (xml,t, rcnt) {
			if(xml) { var fpos = ts.p.treeANode || 0; rcnt=rcnt ||0; if(fpos===0 && rcnt===0) {$("tbody tr:gt(0)", t).remove();} } else { return; }
			var v,row,gi=0,si=0,cbid,idn, getId,f=[],rd =[],cn=(ts.p.altRows === true) ? 'alt':'';
			if(!ts.p.xmlReader.repeatitems) {f = reader("xml");}
			if( ts.p.keyIndex===false) {
				idn = ts.p.xmlReader.id;
				if( idn.indexOf("[") === -1 ) {
					getId = function( trow, k) {return $(idn,trow).text() || k;};
				}
				else {
					getId = function( trow, k) {return trow.getAttribute(idn.replace(/[\[\]]/g,"")) || k;};
				}
			} else {
				getId = function(trow) { return (f.length - 1 >= ts.p.keyIndex) ? $(f[ts.p.keyIndex],trow).text() : $(ts.p.xmlReader.cell+":eq("+ts.p.keyIndex+")",trow).text(); };
			}
			$(ts.p.xmlReader.page,xml).each(function() {ts.p.page = this.textContent  || this.text ; });
			$(ts.p.xmlReader.total,xml).each(function() {ts.p.lastpage = this.textContent  || this.text ; }  );
			$(ts.p.xmlReader.records,xml).each(function() {ts.p.records = this.textContent  || this.text ; }  );
			$(ts.p.xmlReader.userdata,xml).each(function() {ts.p.userData[this.getAttribute("name")]=this.textContent || this.text;});
			$(ts.p.xmlReader.root+" "+ts.p.xmlReader.row,xml).each( function( j ) {
				row = document.createElement("tr");
				row.id = getId(this,j+1);
				if(ts.p.multiselect) {
					addMulti(t,row);
					gi = 1;
				}
				if (ts.p.subGrid) {
					try {$(ts).addSubGrid(t,row,gi,this);} catch (e){}
					si= 1;
				}
				if(ts.p.xmlReader.repeatitems===true){
					$(ts.p.xmlReader.cell,this).each( function (i) {
						v = this.textContent || this.text;
						addCell(t,row,v,i+gi+si);
						rd[ts.p.colModel[i+gi+si].name] = v;
					});
				} else {
					for(var i = 0; i < f.length;i++) {
						v = $(f[i],this).text();
						addCell(t, row, v , i+gi+si);
						rd[ts.p.colModel[i+gi+si].name] = v;
					}
				}
				if(j%2 == 1) {row.className = cn;} $(row).addClass("jqgrow");
				if( ts.p.treeGrid === true) {
					try {$(ts).setTreeNode(rd,row);} catch (e) {}
					ts.p.treeANode = 0;
				}
				$(ts.rows[j+fpos+rcnt]).after(row);
				if(afterInsRow) {ts.p.afterInsertRow(row.id,rd,this);}
				rd=[];
			});
			if(isSafari || isOpera) {resizeFirstRow(t,1);}
		  	if(!ts.p.treeGrid && !ts.p.scroll) {ts.grid.bDiv.scrollTop = 0;}
			endReq();
			updatepager();
		};
		var addJSONData = function(data,t, rcnt) {
			if(data) { var fpos = ts.p.treeANode || 0; rcnt = rcnt || 0; if(fpos===0 && rcnt===0) {$("tbody tr:gt(0)", t).remove();} }  else { return; }
			var v,i,j,row,f=[],cur,gi=0,si=0,drows,idn,rd=[],cn=(ts.p.altRows===true) ? 'alt':'';
			ts.p.page = data[ts.p.jsonReader.page];
			ts.p.lastpage= data[ts.p.jsonReader.total];
			ts.p.records= data[ts.p.jsonReader.records];
			ts.p.userData = data[ts.p.jsonReader.userdata] || {};
			if(!ts.p.jsonReader.repeatitems) {f = reader("json");}
			if( ts.p.keyIndex===false ) {
				idn = ts.p.jsonReader.id;
				if(f.length>0 && !isNaN(idn)) {idn=f[idn];}
			} else {
				idn = f.length>0 ? f[ts.p.keyIndex] : ts.p.keyIndex;
			}
			drows = data[ts.p.jsonReader.root];
			if (drows) {
			for (i=0;i<drows.length;i++) {
				cur = drows[i];
				row = document.createElement("tr");
				row.id = cur[idn] || "";
				if(row.id === "") {
					if(f.length===0){
						if(ts.p.jsonReader.cell){
							var ccur = cur[ts.p.jsonReader.cell];
							row.id = ccur[idn] || i+1;
							ccur=null;
						} else {row.id=i+1;}
					} else {
						row.id=i+1;
					}
				}
				if(ts.p.multiselect){
					addMulti(t,row);
					gi = 1;
				}
				if (ts.p.subGrid) {
					try { $(ts).addSubGrid(t,row,gi,drows[i]);} catch (e){}
					si= 1;
				}
				if (ts.p.jsonReader.repeatitems === true) {
					if(ts.p.jsonReader.cell) {cur = cur[ts.p.jsonReader.cell];}
					for (j=0;j<cur.length;j++) {
						addCell(t,row,cur[j],j+gi+si);
						rd[ts.p.colModel[j+gi+si].name] = cur[j];
					}
				} else {
					for (j=0;j<f.length;j++) {
						v=cur[f[j]];
						if(v === undefined) {
							try { v = eval("cur."+f[j]);}
							catch (e) {}
						}
						addCell(t,row,v,j+gi+si);
						rd[ts.p.colModel[j+gi+si].name] = cur[f[j]];
					}
				}
				if(i%2 == 1) {row.className = cn;} $(row).addClass("jqgrow");
				if( ts.p.treeGrid === true) {
					try {$(ts).setTreeNode(rd,row);} catch (e) {}
					ts.p.treeANode = 0;
				}
				$(ts.rows[i+fpos+rcnt]).after(row);
				if(afterInsRow) {ts.p.afterInsertRow(row.id,rd,drows[i]);}
				rd=[];
			}
			}
			if(isSafari || isOpera) {resizeFirstRow(t,1);}
			if(!ts.p.treeGrid && !ts.p.scroll) {ts.grid.bDiv.scrollTop = 0;}
			endReq();
			updatepager();
		};
		var updatepager = function() {
			if(ts.p.pager) {
				var cp, last,imp = ts.p.imgpath;
				if (ts.p.loadonce) {
					cp = last = 1;
					ts.p.lastpage = ts.page =1;
					$(".selbox",ts.p.pager).attr("disabled",true);
				} else {
					cp = IntNum(ts.p.page);
					last = IntNum(ts.p.lastpage);
					$(".selbox",ts.p.pager).attr("disabled",false);
				}
				if(ts.p.pginput===true) {
					$('input.selbox',ts.p.pager).val(ts.p.page);
				}
				if (ts.p.viewrecords){
					if(ts.p.pgtext) {
						$('#sp_1',ts.p.pager).html(ts.p.pgtext+"&#160;"+ts.p.lastpage );
					}
					$('#sp_2',ts.p.pager).html(ts.p.records+"&#160;"+ts.p.recordtext+"&#160;");
				}
				if(ts.p.pgbuttons===true) {
					if(cp<=0) {cp = last = 1;}
					if(cp==1) {$("#first",ts.p.pager).attr({src:imp+"off-"+ts.p.firstimg,disabled:true});} else {$("#first",ts.p.pager).attr({src:imp+ts.p.firstimg,disabled:false});}
					if(cp==1) {$("#prev",ts.p.pager).attr({src:imp+"off-"+ts.p.previmg,disabled:true});} else {$("#prev",ts.p.pager).attr({src:imp+ts.p.previmg,disabled:false});}
					if(cp==last) {$("#next",ts.p.pager).attr({src:imp+"off-"+ts.p.nextimg,disabled:true});} else {$("#next",ts.p.pager).attr({src:imp+ts.p.nextimg,disabled:false});}
					if(cp==last) {$("#last",ts.p.pager).attr({src:imp+"off-"+ts.p.lastimg,disabled:true});} else {$("#last",ts.p.pager).attr({src:imp+ts.p.lastimg,disabled:false});}
				}
			}
			if($.isFunction(ts.p.gridComplete)) {ts.p.gridComplete();}
		};
		var populate = function () {
			if(!grid.hDiv.loading) {
				beginReq();
				var gdata, prm = {nd: (new Date().getTime()), _search:ts.p.search};
				prm[ts.p.prmNames.rows]= ts.p.rowNum; prm[ts.p.prmNames.page]= ts.p.page;
				prm[ts.p.prmNames.sort]= ts.p.sortname; prm[ts.p.prmNames.order]= ts.p.sortorder;
				gdata = $.extend(ts.p.postData,prm);
				if (ts.p.search ===true) {gdata =$.extend(gdata,ts.p.searchdata);}				
				if ($.isFunction(ts.p.datatype)) {ts.p.datatype(gdata);endReq();}
				var rcnt = ts.p.scroll===false ? 0 : ts.rows.length-1; 
				switch(ts.p.datatype)
				{
				case "json":
					$.ajax({url:ts.p.url,type:ts.p.mtype,dataType:"json",data: gdata, complete:function(JSON,st) { if(st=="success") {addJSONData(eval("("+JSON.responseText+")"),ts.grid.bDiv,rcnt); JSON=null;if(loadComplete) {loadComplete();}}}, error:function(xhr,st,err){if(loadError) {loadError(xhr,st,err);}endReq();}, beforeSend: function(xhr){if(loadBeforeSend) {loadBeforeSend(xhr);}}});
					if( ts.p.loadonce || ts.p.treeGrid) {ts.p.datatype = "local";}
				break;
				case "xml":
					$.ajax({url:ts.p.url,type:ts.p.mtype,dataType:"xml",data: gdata , complete:function(xml,st) {if(st=="success")	{addXmlData(xml.responseXML,ts.grid.bDiv,rcnt); xml=null;if(loadComplete) {loadComplete();}}}, error:function(xhr,st,err){if(loadError) {loadError(xhr,st,err);}endReq();}, beforeSend: function(xhr){if(loadBeforeSend) {loadBeforeSend(xhr);}}});
					if( ts.p.loadonce || ts.p.treeGrid) {ts.p.datatype = "local";}
				break;
				case "xmlstring":
					addXmlData(stringToDoc(ts.p.datastr),ts.grid.bDiv);
					ts.p.datastr = null;
					ts.p.datatype = "local";
					if(loadComplete) {loadComplete();}
				break;
				case "jsonstring":
					if(typeof ts.p.datastr == 'string') { ts.p.datastr = eval("("+ts.p.datastr+")");}
					addJSONData(ts.p.datastr,ts.grid.bDiv);
					ts.p.datastr = null;
					ts.p.datatype = "local";
					if(loadComplete) {loadComplete();}
				break;
				case "local":
				case "clientSide":
					ts.p.datatype = "local";
					sortArrayData();
				break;
				}
			}
		};
		var beginReq = function() {
			if(beReq) {ts.p.beforeRequest();}
			grid.hDiv.loading = true;
			switch(ts.p.loadui) {
				case "disable":
					break;
				case "enable":
					$("div.loading",grid.hDiv).fadeIn("fast");
					break;
				case "block":
					$("#lui_"+ts.id).width($(grid.bDiv).width()).height(IntNum($(grid.bDiv).height())+IntNum(ts.p._height)).fadeIn("fast");
					break;
			}
		};
		var endReq = function() {
			grid.hDiv.loading = false;
			switch(ts.p.loadui) {
				case "disable":
					break;
				case "enable":
					$("div.loading",grid.hDiv).hide();  //Ian changed to hide because fade doesn't work if already hidden which most panels are most of the time.
					break;
				case "block":
					$("#lui_"+ts.id).fadeOut("fast");
					break;
			}
		};
		var stringToDoc =	function (xmlString) {
			var xmlDoc;
			if(typeof xmlString !== 'string') return xmlString;
			try	{
				var parser = new DOMParser();
				xmlDoc = parser.parseFromString(xmlString,"text/xml");
			}
			catch(e) {
				xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
				xmlDoc.async=false;
				xmlDoc["loadXM"+"L"](xmlString);
			}
			return (xmlDoc && xmlDoc.documentElement && xmlDoc.documentElement.tagName != 'parsererror') ? xmlDoc : null;
		};
		var sortArrayData = function() {
			var stripNum = /[\$,%]/g;
			var rows=[], col=0, st, sv, findSortKey,newDir = (ts.p.sortorder == "asc") ? 1 :-1;
			$.each(ts.p.colModel,function(i,v){
				if(this.index == ts.p.sortname || this.name == ts.p.sortname){
					col = ts.p.lastsort= i;
					st = this.sorttype;
					return false;
				}
			});
			if (st == 'float' || st== 'number' || st== 'currency') {
				findSortKey = function($cell) {
					var key = parseFloat($cell.replace(stripNum, ''));
					return isNaN(key) ? 0 : key;
				};
			} else if (st=='int' || st=='integer') {
				findSortKey = function($cell) {
					return IntNum($cell.replace(stripNum, ''));
				};
			} else if(st == 'date') {
				findSortKey = function($cell) {
					var fd = ts.p.colModel[col].datefmt || "Y-m-d";
					return parseDate(fd,$cell).getTime();
				};
			} else {
				findSortKey = function($cell) {
					return $.trim($cell.toUpperCase());
				};
			}
			$.each(ts.rows, function(index, row) {
				if (index > 0) {
					try { sv = $.unformat($(row).children('td').eq(col),{colModel:ts.p.colModel[col]},col,true);}
					catch (_) { sv = $(row).children('td').eq(col).text(); }
					row.sortKey = findSortKey(sv);
					rows[index-1] = this;
				}
			});
			if(ts.p.treeGrid) {
				$(ts).SortTree( newDir);
			} else {
				rows.sort(function(a, b) {
					if (a.sortKey < b.sortKey) {return -newDir;}
					if (a.sortKey > b.sortKey) {return newDir;}
					return 0;
				});
				$.each(rows, function(index, row) {
					$('tbody',ts.grid.bDiv).append(row);
					row.sortKey = null;
				});
			}
			if(isSafari || isOpera) {resizeFirstRow(ts.grid.bDiv,1);}
			if(ts.p.multiselect) {
				$("tbody tr:gt(0)", ts.grid.bDiv).removeClass("selected");
				$("[id^=jqg_]",ts.rows).attr("checked",false);
				$("#cb_jqg",ts.grid.hDiv).attr("checked",false);
				ts.p.selarrrow = [];
			}
			if( ts.p.altRows === true ) {
				$("tbody tr:gt(0)", ts.grid.bDiv).removeClass("alt");
				$("tbody tr:odd", ts.grid.bDiv).addClass("alt");
			}
			ts.grid.bDiv.scrollTop = 0;
			endReq();
		};
		var parseDate = function(format, date) {
			var tsp = {m : 1, d : 1, y : 1970, h : 0, i : 0, s : 0};
			format = format.toLowerCase();
			date = date.split(/[\\\/:_;.\s-]/);
			format = format.split(/[\\\/:_;.\s-]/);
			for(var i=0;i<format.length;i++){
				tsp[format[i]] = IntNum(date[i],tsp[format[i]]);
			}
			tsp.m = parseInt(tsp.m,10)-1;
			var ty = tsp.y;
			if (ty >= 70 && ty <= 99) {tsp.y = 1900+tsp.y;}
			else if (ty >=0 && ty <=69) {tsp.y= 2000+tsp.y;}
			return new Date(tsp.y, tsp.m, tsp.d, tsp.h, tsp.i, tsp.s,0);
		};
		var setPager = function (){
			var inpt = "<img class='pgbuttons' src='"+ts.p.imgpath+"spacer.gif'",
			pginp = (ts.p.pginput===true) ? "<input class='selbox' type='text' size='3' maxlength='5' value='0'/>" : "",
			pgl="", pgr="", str;
			if(ts.p.viewrecords===true) {pginp += "<span id='sp_1'></span>&#160;";}
			if(ts.p.pgbuttons===true) {
				pgl = inpt+" id='first'/>&#160;&#160;"+inpt+" id='prev'/>&#160;";
				pgr = inpt+" id='next' />&#160;&#160;"+inpt+" id='last'/>";
			}
			$(ts.p.pager).append(pgl+pginp+pgr);
			if(ts.p.rowList.length >0){
				str="<SELECT class='selbox'>";
				for(var i=0;i<ts.p.rowList.length;i++){
					str +="<OPTION value="+ts.p.rowList[i]+((ts.p.rowNum == ts.p.rowList[i])?' selected':'')+">"+ts.p.rowList[i];
				}
				str +="</SELECT>";
				$(ts.p.pager).append("&#160;"+str+"&#160;<span id='sp_2'></span>");
				$(ts.p.pager).find("select").bind('change',function() { 
					ts.p.rowNum = this.value; 
					if (typeof ts.p.onPaging =='function') {ts.p.onPaging('records');}
					populate();
					ts.p.selrow = null;
				});
			} else { $(ts.p.pager).append("&#160;<span id='sp_2'></span>");}
			if(ts.p.pgbuttons===true) {
			$(".pgbuttons",ts.p.pager).mouseover(function(e){
				if($(this).attr('disabled') == 'true') { this.style.cursor='auto';}				
				else {this.style.cursor= "pointer";}
				return false;
			}).mouseout(function(e) {
				this.style.cursor= "default";
				return false;
			});
			$("#first, #prev, #next, #last",ts.p.pager).click( function(e) {
				var cp = IntNum(ts.p.page),
				last = IntNum(ts.p.lastpage), selclick = false,
				fp=true, pp=true, np=true,lp=true;
				if(last ===0 || last===1) {fp=false;pp=false;np=false;lp=false; }
				else if( last>1 && cp >=1) {
					if( cp === 1) { fp=false; pp=false; } 
					else if( cp>1 && cp <last){ }
					else if( cp===last){ np=false;lp=false; }
				} else if( last>1 && cp===0 ) { np=false;lp=false; cp=last-1;}
				if( this.id === 'first' && fp ) { ts.p.page=1; selclick=true;} 
				if( this.id === 'prev' && pp) { ts.p.page=(cp-1); selclick=true;} 
				if( this.id === 'next' && np) { ts.p.page=(cp+1); selclick=true;} 
				if( this.id === 'last' && lp) { ts.p.page=last; selclick=true;}
				if(selclick) {
					if (typeof ts.p.onPaging =='function') {ts.p.onPaging(this.id);}
					populate();
					ts.p.selrow = null;
					if(ts.p.multiselect) {ts.p.selarrrow =[];$('#cb_jqg',ts.grid.hDiv).attr("checked",false);}
					ts.p.savedRow = [];
				}
				e.stopPropagation();
				return false;
			});
			}
			if(ts.p.pginput===true) {
			$('input.selbox',ts.p.pager).keypress( function(e) {
				var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
				if(key == 13) {
					ts.p.page = ($(this).val()>0) ? $(this).val():ts.p.page;
					if (typeof ts.p.onPaging =='function') {ts.p.onPaging( 'user');}
					populate();
					ts.p.selrow = null;
					return false;
				}
				return this;
			});
			}
		};
		var sortData = function (index, idxcol,reload){
			var imgs, so, scg, ls, iId;
			if(ts.p.savedRow.length > 0) {return;}
			if(!reload) {
				if( ts.p.lastsort === idxcol ) {
					if( ts.p.sortorder === 'asc') {
						ts.p.sortorder = 'desc';
					} else if(ts.p.sortorder === 'desc') { ts.p.sortorder='asc';}
				} else { ts.p.sortorder='asc';}
				ts.p.page = 1;
			}
			imgs = (ts.p.sortorder==='asc') ? ts.p.sortascimg : ts.p.sortdescimg;
			imgs = "<img src='"+ts.p.imgpath+imgs+"'>";
			var thd= $("thead:first",grid.hDiv).get(0);
			ls = ts.p.colModel[ts.p.lastsort].name.replace('.',"\\.");
			$("tr th div#jqgh_"+ls+" img",thd).remove();
			$("tr th div#jqgh_"+ls,thd).parent().removeClass(ts.p.sortclass);
			iId = index.replace('.',"\\.");
			$("tr th div#"+iId,thd).append(imgs).parent().addClass(ts.p.sortclass);
			ts.p.lastsort = idxcol;
			index = index.substring(5);
			ts.p.sortname = ts.p.colModel[idxcol].index || index;
			so = ts.p.sortorder;
			if(onSortCol) {onSortCol(index,idxcol,so);}
			if(ts.p.datatype == "local") {
				if(ts.p.deselectAfterSort) {$(ts).resetSelection();}
			} else {
				ts.p.selrow = null;
				if(ts.p.multiselect){$("#cb_jqg",ts.grid.hDiv).attr("checked",false);}
				ts.p.selarrrow =[];
				ts.p.savedRow =[];
			}			
			scg = ts.p.scroll; if(ts.p.scroll===true) {ts.p.scroll=false;}
			populate();
			if(ts.p.sortname != index && idxcol) {ts.p.lastsort = idxcol;}
			setTimeout(function() {ts.p.scroll=scg;},500);
		};
		var setColWidth = function () {
			var initwidth = 0; 
			for(var l=0;l<ts.p.colModel.length;l++){
				if(!ts.p.colModel[l].hidden){
					initwidth += IntNum(ts.p.colModel[l].width);
				}
			}
			var tblwidth = ts.p.width ? ts.p.width : initwidth;
			for(l=0;l<ts.p.colModel.length;l++) {
				if(!ts.p.shrinkToFit){
					ts.p.colModel[l].owidth = ts.p.colModel[l].width;
				}
				ts.p.colModel[l].width = Math.round(tblwidth/initwidth*ts.p.colModel[l].width);
			}
		};
		var nextVisible= function(iCol) {
			var ret = iCol, j=iCol, i;
			for (i = iCol+1;i<ts.p.colModel.length;i++){
				if(ts.p.colModel[i].hidden !== true ) {
					j=i; break;
				}
			}
			return j-ret;
		};
		this.p.id = this.id;
		if(this.p.treeGrid === true) {
			this.p.subGrid = false; this.p.altRows =false;
			this.p.pgbuttons = false; this.p.pginput = false;
			this.p.multiselect = false; this.p.rowList = [];
			try {
				$(this).setTreeGrid();
				this.p.treedatatype = this.p.datatype;
				$.each(this.p.treeReader,function(i,n){
					if(n){
						ts.p.colNames.push(n);
						ts.p.colModel.push({name:n,width:1,hidden:true,sortable:false,resizable:false,hidedlg:true,editable:true,search:false});
					}
				});
			} catch (_) {}
		}
		ts.p.keyIndex=false;
		for (var i=0; i<ts.p.colModel.length;i++) {
			if (ts.p.colModel[i].key===true) {
				ts.p.keyIndex = i;
				break;
			}
		}
		if(this.p.subGrid) {
			this.p.colNames.unshift("");
			this.p.colModel.unshift({name:'subgrid',width:25,sortable: false,resizable:false,hidedlg:true,search:false});
		}
		if(this.p.multiselect) {
			this.p.colNames.unshift("<input id='cb_jqg' class='cbox' type='checkbox'/>");
			this.p.colModel.unshift({name:'cb',width:27,sortable:false,resizable:false,hidedlg:true,search:false});
		}
		var	xReader = {
			root: "rows",
			row: "row",
			page: "rows>page",
			total: "rows>total",
			records : "rows>records",
			repeatitems: true,
			cell: "cell",
			id: "[id]",
			userdata: "userdata",
			subgrid: {root:"rows", row: "row", repeatitems: true, cell:"cell"}
		};
		var jReader = {
			root: "rows",
			page: "page",
			total: "total",
			records: "records",
			repeatitems: true,
			cell: "cell",
			id: "id",
			userdata: "userdata",
			subgrid: {root:"rows", repeatitems: true, cell:"cell"}
		};
		if(ts.p.scroll===true){
			ts.p.pgbuttons = false; ts.p.pginput=false; ts.p.pgtext = false; ts.p.rowList=[];
		}
		ts.p.xmlReader = $.extend(xReader, ts.p.xmlReader);
		ts.p.jsonReader = $.extend(jReader, ts.p.jsonReader);
		$.each(ts.p.colModel, function(i){this.width= IntNum(this.width,150);});
		if (ts.p.width) {setColWidth();}
		var thead = document.createElement("thead");
		var trow = document.createElement("tr");
		thead.appendChild(trow); 
		var i=0, th, idn, thdiv;
		if(ts.p.shrinkToFit===true && ts.p.forceFit===true) {
			for (i=ts.p.colModel.length-1;i>=0;i--){
				if(!ts.p.colModel[i].hidden) {
					ts.p.colModel[i].resizable=false;
					break;
				}
			}
		}
		for(i=0;i<this.p.colNames.length;i++){
			th = document.createElement("th");
			idn = ts.p.colModel[i].name;
			thdiv = document.createElement("div");
			$(thdiv).html(ts.p.colNames[i]+"&#160;");
			if (idn == ts.p.sortname) {
				var imgs = (ts.p.sortorder==='asc') ? ts.p.sortascimg : ts.p.sortdescimg;
				imgs = "<img src='"+ts.p.imgpath+imgs+"'>";
				$(thdiv).append(imgs);
				ts.p.lastsort = i;
				$(th).addClass(ts.p.sortclass);
			}
			thdiv.id = "jqgh_"+idn;
			th.appendChild(thdiv);
			trow.appendChild(th);
		}
		if(this.p.multiselect) {
			var onSA = true;
			if(typeof ts.p.onSelectAll !== 'function') {onSA=false;}
			$('#cb_jqg',trow).click(function(){
				var chk;
				if (this.checked) {
					$("[id^=jqg_]",ts.rows).attr("checked",true);
					$(ts.rows).slice(1).each(function(i) {
						if(!$(this).hasClass("subgrid")){
						$(this).addClass("selected");
						ts.p.selarrrow[i]= ts.p.selrow = this.id; 
						}
					});
					chk=true;
				}
				else {
					$("[id^=jqg_]",ts.rows).attr("checked",false);
					$(ts.rows).slice(1).each(function(i) {
						if(!$(this).hasClass("subgrid")){
							$(this).removeClass("selected");
						}
					});
					ts.p.selarrrow = []; ts.p.selrow = null;
					chk=false;
				}
				if(onSA) {ts.p.onSelectAll(ts.p.selarrrow,chk);}
			});
		}
		this.appendChild(thead);
		thead = $("thead:first",ts).get(0);
		var w, res, sort;
		$("tr:first th",thead).each(function ( j ) {
			w = ts.p.colModel[j].width;
			if(typeof ts.p.colModel[j].resizable === 'undefined') {ts.p.colModel[j].resizable = true;}
			res = document.createElement("span");
			$(res).html("&#160;");
			if(ts.p.colModel[j].resizable){
				$(this).addClass(ts.p.resizeclass);
				$(res).mousedown(function (e) {
					if(ts.p.forceFit===true) {ts.p.nv= nextVisible(j);}
					grid.dragStart(j, e.clientX);
					e.preventDefault();
					return false;
				});
			} else {res="";}
			$(this).css("width",w+"px").prepend(res);
			if( ts.p.colModel[j].hidden) {$(this).css("display","none");}
			grid.headers[j] = { width: w, el: this };
			sort = ts.p.colModel[j].sortable;
			if( typeof sort !== 'boolean') {sort =  true;}
			if(sort) { 
				$("div",this).css("cursor","pointer")
				.click(function(){sortData(this.id,j);return false;});
			}
		});
		var isMSIE = $.browser.msie ? true:false,
		isMoz = $.browser.mozilla ? true:false,
		isOpera = $.browser.opera ? true:false,
		isSafari = $.browser.safari ? true : false,
		td, ptr, gw=0,hdc=0, tbody = document.createElement("tbody");
		trow = document.createElement("tr");
		trow.id = "_empty";
		tbody.appendChild(trow);
		for(i=0;i<ts.p.colNames.length;i++){
			td = document.createElement("td");
			trow.appendChild(td);
		}
		this.appendChild(tbody);
		$("tbody tr:first td",ts).each(function(ii) {
			w = ts.p.colModel[ii].width;
			$(this).css({width:w+"px",height:"0px"});
			w +=  IntNum($(this).css("padding-left")) +
			IntNum($(this).css("padding-right"))+
			IntNum($(this).css("border-left-width"))+
			IntNum($(this).css("border-right-width"));
			if( ts.p.colModel[ii].hidden===true) {
				$(this).css("display","none");
				hdc += w;
			}
			grid.cols[ii] = this;
			gw += w;
		});
		if(isMoz) {$(trow).css({visibility:"collapse"});}
		else if( isSafari || isOpera ) {$(trow).css({display:"none"});}
		grid.width = IntNum(gw)-IntNum(hdc);
		ts.p._width = grid.width;
		grid.hTable = document.createElement("table");
		$(grid.hTable).append(thead)
		.css({width:grid.width+"px"})
		.attr({cellSpacing:"0",cellPadding:"0",border:"0"})
		.addClass("scroll grid_htable");
		grid.hDiv = document.createElement("div");
		var hg = (ts.p.caption && ts.p.hiddengrid===true) ? true : false;
		$(grid.hDiv)
			.css({ width: grid.width+"px", overflow: "hidden"})
			.prepend('<div class="loading">'+ts.p.loadtext+'</div>')
			.addClass("grid_hdiv")
			.append(grid.hTable)
			.bind("selectstart", function () { return false; });
		if(hg) {$(grid.hDiv).hide(); ts.p.gridstate = 'hidden'}
		if(ts.p.pager){
			if(typeof ts.p.pager == "string") {if(ts.p.pager.substr(0,1) !="#") ts.p.pager = "#"+ts.p.pager;}
			if( $(ts.p.pager).hasClass("scroll")) { $(ts.p.pager).css({ width: grid.width+"px", overflow: "hidden"}).show(); ts.p._height= parseInt($(ts.p.pager).height(),10); if(hg) {$(ts.p.pager).hide();}}
			setPager();
		}
		if( ts.p.cellEdit === false) {
		$(ts).mouseover(function(e) {
			td = (e.target || e.srcElement);
			ptr = $(td,ts.rows).parents("tr:first");
			if($(ptr).hasClass("jqgrow")) {
				$(ptr).addClass("over");
			}
			return false;
		}).mouseout(function(e) {
			td = (e.target || e.srcElement);
			ptr = $(td,ts.rows).parents("tr:first");
			$(ptr).removeClass("over");
			return false;
		});
		}
		var ri,ci;
		
		$(ts).before(grid.hDiv).css("width", grid.width+"px").click(function(e) {
			td = (e.target || e.srcElement);
			if (td.href) { return true; }
			var scb = $(td).hasClass("cbox");
			ptr = $(td,ts.rows).parent("tr");
			if($(ptr).length === 0 ){
				ptr = $(td,ts.rows).parents("tr:first");
				td = $(td).parents("td:first")[0];
			}
			var cSel = true;
			if(bSR) { cSel = bSR(ptr.attr("id"));}
			if(cSel === true) {
				if(ts.p.cellEdit === true) {
					if(ts.p.multiselect && scb){
						$(ts).setSelection(false,true,ptr);
					} else {
						ri = ptr[0].rowIndex;
						ci = td.cellIndex;
						try {$(ts).editCell(ri,ci,true,true);} catch (e) {}
					}
				} else if ( !ts.p.multikey ) {
					if(ts.p.multiselect && ts.p.multiboxonly) {
						if(scb){$(ts).setSelection(false,true,ptr);}
					} else {
						$(ts).setSelection(false,true,ptr);
					}
				} else {
					if(e[ts.p.multikey]) {
						$(ts).setSelection(false,true,ptr);
					} else if(ts.p.multiselect && scb) {
						scb = $("[id^=jqg_]",ptr).attr("checked");
						$("[id^=jqg_]",ptr).attr("checked",!scb);
					}
				}
				if(onSC) {
					ri = ptr[0].id;
					ci = td.cellIndex;
					onSC(ri,ci,$(td).html());
				}
			}
			e.stopPropagation();
		}).bind('reloadGrid', function(e) {
			if(ts.p.treeGrid ===true) {	ts.p.datatype = ts.p.treedatatype;}
			if(ts.p.datatype=="local"){ $(ts).resetSelection();}
			else if(!ts.p.treeGrid){
				ts.p.selrow=null;
				if(ts.p.multiselect) {ts.p.selarrrow =[];$('#cb_jqg',ts.grid.hDiv).attr("checked",false);}
				if(ts.p.cellEdit) {ts.p.savedRow = []; }
			}
			populate();
		});		
		if( ondblClickRow ) {
			$(this).dblclick(function(e) {
				td = (e.target || e.srcElement);
				ptr = $(td,ts.rows).parent("tr");
				if($(ptr).length === 0 ){
					ptr = $(td,ts.rows).parents("tr:first");
				}
				ts.p.ondblClickRow($(ptr).attr("id"));
				return false;
			});
		}
		if (onRightClickRow) {
			$(this).bind('contextmenu', function(e) {
				td = (e.target || e.srcElement);
				ptr = $(td,ts).parents("tr:first");
				if($(ptr).length === 0 ){
					ptr = $(td,ts.rows).parents("tr:first");
				}
				if(!ts.p.multiselect) {	$(ts).setSelection(false,true,ptr);	}
				ts.p.onRightClickRow($(ptr).attr("id"));
				return false;
			});
		}
		grid.bDiv = document.createElement("div");
		var ofl2 = (isNaN(ts.p.height) && isMoz && (ts.p.height.indexOf("%")!=-1 || ts.p.height=="auto")) ? "hidden" : "auto";
		$(grid.bDiv)
			.addClass("grid_bdiv")
			.scroll(function (e) {grid.scrollGrid();})
			.css({ height: ts.p.height+(isNaN(ts.p.height)?"":"px"), padding: "0px", margin: "0px", overflow: ofl2,width: (grid.width)+"px"} ).css("overflow-x","hidden")
			.append(this);
		$("table:first",grid.bDiv).css({width:grid.width+"px"});
		if( isMSIE ) {
			if( $("tbody",this).size() === 2 ) { $("tbody:first",this).remove();}
			if( ts.p.multikey) {$(grid.bDiv).bind("selectstart",function(){return false;});}
			if(ts.p.treeGrid) {$(grid.bDiv).css("position","relative");}
		} else {
			if( ts.p.multikey) {$(grid.bDiv).bind("mousedown",function(){return false;});}
		}
		if(hg) {$(grid.bDiv).hide();}
		grid.cDiv = document.createElement("div");
		$(grid.cDiv).append("<table class='Header' cellspacing='0' cellpadding='0' border='0'><tr><td class='HeaderLeft'><img src='"+ts.p.imgpath+"spacer.gif' border='0' /></td><th>"+ts.p.caption+"</th>"+ ((ts.p.hidegrid===true) ? "<td class='HeaderButton'><img src='"+ts.p.imgpath+"up.gif' border='0'/></td>" :"") +"<td class='HeaderRight'><img src='"+ts.p.imgpath+"spacer.gif' border='0' /></td></tr></table>")
		.addClass("GridHeader").width(grid.width);
		$(grid.cDiv).insertBefore(grid.hDiv);
		if( ts.p.toolbar[0] ) {
			grid.uDiv = document.createElement("div");
			if(ts.p.toolbar[1] == "top") {$(grid.uDiv).insertBefore(grid.hDiv);}
			else {$(grid.uDiv).insertAfter(grid.hDiv);}
			$(grid.uDiv).width(grid.width).addClass("userdata").attr("id","t_"+this.id);
			ts.p._height += parseInt($(grid.uDiv).height(),10);
			if(hg) {$(grid.uDiv).hide();}
		}
		if(ts.p.caption) {
			ts.p._height += parseInt($(grid.cDiv,ts).height(),10);
			var tdt = ts.p.datatype;
			if(ts.p.hidegrid===true) {
				$(".HeaderButton",grid.cDiv).toggle( function(){
					if(ts.p.pager) {$(ts.p.pager).slideUp();}
					if(ts.p.toolbar[0]) {$(grid.uDiv,ts).slideUp();}
					$(grid.bDiv).hide();
					$(grid.hDiv).slideUp();
					$("img",this).attr("src",ts.p.imgpath+"down.gif");
					ts.p.gridstate = 'hidden';
					if(onHdCl) {if(!hg) {ts.p.onHeaderClick(ts.p.gridstate);}}
					},
					function() {
					$(grid.hDiv).slideDown();
					$(grid.bDiv).show();
					if(ts.p.pager) {$(ts.p.pager).slideDown();}
					if(ts.p.toolbar[0]) {$(grid.uDiv).slideDown();}
					$("img",this).attr("src",ts.p.imgpath+"up.gif");
					if(hg) {ts.p.datatype = tdt;populate();hg=false;}
					ts.p.gridstate = 'visible';
					if(onHdCl) {ts.p.onHeaderClick(ts.p.gridstate)}
					}
				);
				if(hg) { $(".HeaderButton",grid.cDiv).trigger("click"); ts.p.datatype="local";}
			}
		} else {$(grid.cDiv).hide();}
		ts.p._height += parseInt($(grid.hDiv,ts).height(),10);
		$(grid.hDiv).mousemove(function (e) {grid.dragMove(e.clientX); return false;}).after(grid.bDiv);
		$(document).mouseup(function (e) {
			if(grid.resizing) {
				grid.dragEnd();
				if(grid.newWidth && ts.p.forceFit===false){
					var gwdt = (grid.width <= ts.p._width) ? grid.width: ts.p._width;
					var overfl = (grid.width <= ts.p._width) ? "hidden" : "auto";
					if(ts.p.pager && $(ts.p.pager).hasClass("scroll") ) {
						$(ts.p.pager).width(gwdt);
					}
					if(ts.p.caption) {$(grid.cDiv).width(gwdt);}
					if(ts.p.toolbar[0]) {$(grid.uDiv).width(gwdt);}
					$(grid.bDiv).width(gwdt).css("overflow-x",overfl);
					$(grid.hDiv).width(gwdt);
				}
				return false;
			}
			return true;
		});
		ts.formatCol = function(a,b) {formatCol(a,b);};
		ts.sortData = function(a,b,c){sortData(a,b,c);};
		ts.updatepager = function(){updatepager();};
		ts.formatter = function (elem, row, cellval , colpos, act){formatter(elem, row, cellval , colpos,act);};
		$.extend(grid,{populate : function(){populate();}});
		this.grid = grid;
		ts.addXmlData = function(d) {addXmlData(d,ts.grid.bDiv);};
		ts.addJSONData = function(d) {addJSONData(d,ts.grid.bDiv);};
		populate();
		if (!ts.p.shrinkToFit) {
			ts.p.forceFit = false;
			$("tr:first th", thead).each(function(j){
				var w = ts.p.colModel[j].owidth;
				var diff = w - ts.p.colModel[j].width;
				if (diff > 0 && !ts.p.colModel[j].hidden) {
					grid.headers[j].width = w;
					$(this).add(grid.cols[j]).width(w);
					$('table:first',grid.bDiv).add(grid.hTable).width(ts.grid.width);
					ts.grid.width += diff;
					grid.hDiv.scrollLeft = grid.bDiv.scrollLeft;
				}
			});
			ofl2 = (grid.width <= ts.p._width) ? "hidden" : "auto";
			$(grid.bDiv).css({"overflow-x":ofl2});
		}
		$(window).unload(function () {
			$(this).unbind("*");
			this.grid = null;
			this.p = null;
		});
	});
};
})(jQuery);
/**
 * jqGrid common function
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
// Modal functions
var showModal = function(h) {
	h.w.show();
};
var closeModal = function(h) {
	h.w.hide();
	if(h.o) { h.o.remove(); }
};
function createModal(aIDs, content, p, insertSelector, posSelector, appendsel) {
	var clicon = p.imgpath ? p.imgpath+p.closeicon : p.closeicon;
	var mw  = document.createElement('div');
	jQuery(mw).addClass("modalwin").attr("id",aIDs.themodal);
	var mh = jQuery('<div id="'+aIDs.modalhead+'"><table width="100%"><tbody><tr><td class="modaltext">'+p.caption+'</td> <td style="text-align:right" ><a href="javascript:void(0);" class="jqmClose">'+(clicon!=''?'<img src="' + clicon + '" border="0"/>':'X') + '</a></td></tr></tbody></table> </div>').addClass("modalhead");
	var mc = document.createElement('div');
	jQuery(mc).addClass("modalcontent").attr("id",aIDs.modalcontent);
	jQuery(mc).append(content);
	mw.appendChild(mc);
	var loading = document.createElement("div");
	jQuery(loading).addClass("loading").html(p.processData||"");
	jQuery(mw).prepend(loading);
	jQuery(mw).prepend(mh);
	jQuery(mw).addClass("jqmWindow");
	if (p.drag) {
		jQuery(mw).append("<img  class='jqResize' src='"+p.imgpath+"resize.gif'/>");
	}
	if(appendsel===true) { jQuery('body').append(mw); } //append as first child in body -for alert dialog
	else { jQuery(mw).insertBefore(insertSelector);	}
	if(p.left ==0 && p.top==0) {
		var pos = [];
		pos = findPos(posSelector) ;
		p.left = pos[0] + 4;
		p.top = pos[1] + 4;
	}
	if (p.width == 0 || !p.width) {p.width = 300;}
	if(p.height==0 || !p.width) {p.height =200;}
	if(!p.zIndex) {p.zIndex = 950;}
	jQuery(mw).css({top: p.top+"px",left: p.left+"px",width: p.width+"px",height: p.height+"px", zIndex:p.zIndex});
	return false;
};

function viewModal(selector,o){
	o = jQuery.extend({
		toTop: true,
		overlay: 10,
		modal: false,
		onShow: showModal,
		onHide: closeModal
	}, o || {});
	jQuery(selector).jqm(o).jqmShow();
	return false;
};
function hideModal(selector) {
	jQuery(selector).jqmHide();
}

function DnRModal(modwin,handler){
	jQuery(handler).css('cursor','move');
	jQuery(modwin).jqDrag(handler).jqResize(".jqResize");
	return false;
};

function info_dialog(caption, content,c_b, pathimg) {
	var cnt = "<div id='info_id'>";
	cnt += "<div align='center'><br />"+content+"<br /><br />";
	cnt += "<input type='button' size='10' id='closedialog' class='jqmClose EditButton' value='"+c_b+"' />";
	cnt += "</div></div>";
	createModal({
		themodal:'info_dialog',
		modalhead:'info_head',
		modalcontent:'info_content'},
		cnt,
		{ width:290,
		height:120,drag: false,
		caption:"<b>"+caption+"</b>",
		imgpath: pathimg,
		closeicon: 'ico-close.gif',
		left:250,
		top:170 },
		'','',true
	);
	viewModal("#info_dialog",{
		onShow: function(h) {
			h.w.show();
		},
		onHide: function(h) {
			h.w.hide().remove();
			if(h.o) { h.o.remove(); }
		},
		modal :true
	});
};
//Helper functions
function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop; 
		} while (obj = obj.offsetParent);
		//do not change obj == obj.offsetParent 
	}
	return [curleft,curtop];
};
function isArray(obj) {
	if (obj.constructor.toString().indexOf("Array") == -1) {
		return false;
	} else {
		return true;
	}
};
// Form Functions
function createEl(eltype,options,vl,elm) {
	var elem = "";
	switch (eltype)
	{
		case "textarea" :
				elem = document.createElement("textarea");
				if(!options.cols && elm) {jQuery(elem).css("width","99%");}
				jQuery(elem).attr(options);
				if(vl == "&nbsp;" || vl == "&#160;") {vl='';} // comes from grid if empty
				jQuery(elem).val(vl);
				break;
		case "checkbox" : //what code for simple checkbox
			elem = document.createElement("input");
			elem.type = "checkbox";
			jQuery(elem).attr({id:options.id,name:options.name});
			if( !options.value) {
				vl=vl.toLowerCase();
				if(vl.search(/(false|0|no|off|undefined)/i)<0 && vl!=="") {
					elem.checked=true;
					elem.defaultChecked=true;
					elem.value = vl;
				} else {
					elem.value = "on";
				}
				jQuery(elem).attr("offval","off");
			} else {
				var cbval = options.value.split(":");
				if(vl == cbval[0]) {
					elem.checked=true;
					elem.defaultChecked=true;
				}
				elem.value = cbval[0];
				jQuery(elem).attr("offval",cbval[1]);
			}
			break;
		case "select" :
			elem = document.createElement("select");
			var msl = options.multiple==true ? true : false;
			if(options.value) {
				var ovm = [];
				if(msl) {jQuery(elem).attr({multiple:"multiple"}); ovm = vl.split(","); ovm = jQuery.map(ovm,function(n){return jQuery.trim(n)});}
				if(typeof options.size === 'undefined') {options.size =1;}
				if(typeof options.value == 'string') {
					var so = options.value.split(";"),sv, ov;
					jQuery(elem).attr({id:options.id,name:options.name,size:Math.min(options.size,so.length)});
					for(var i=0; i<so.length;i++){
						sv = so[i].split(":");
						ov = document.createElement("option");
						ov.value = sv[0]; ov.innerHTML = jQuery.htmlDecode(sv[1]);
						if (!msl &&  sv[1]==vl) ov.selected ="selected";
						if (msl && jQuery.inArray(jQuery.trim(sv[1]), ovm)>-1) {ov.selected ="selected";}
						elem.appendChild(ov);
					}
				} else if (typeof options.value == 'object') {
					var oSv = options.value;
					var i=0;
					for ( var key in oSv) {
						i++;
						ov = document.createElement("option");
						ov.value = key; ov.innerHTML = jQuery.htmlDecode(oSv[key]);
						if (!msl &&  oSv[key]==vl) {ov.selected ="selected";}
						if (msl && jQuery.inArray(jQuery.trim(oSv[key]),ovm)>-1) {ov.selected ="selected";}
						elem.appendChild(ov);
					}
					jQuery(elem).attr({id:options.id,name:options.name,size:Math.min(options.size,i) });
				}
			}
			break;
		case "text" :
			elem = document.createElement("input");
			elem.type = "text";
			vl = jQuery.htmlDecode(vl);
			elem.value = vl;
			if(!options.size && elm) {
				jQuery(elem).css({width:"98%"});
			}
			jQuery(elem).attr(options);
			break;
		case "password" :
			elem = document.createElement("input");
			elem.type = "password";
			vl = jQuery.htmlDecode(vl);
			elem.value = vl;
			if(!options.size && elm) { jQuery(elem).css("width","99%"); }
			jQuery(elem).attr(options);
			break;
		case "image" :
			elem = document.createElement("input");
			elem.type = "image";
			jQuery(elem).attr(options);
			break;
	}
	return elem;
};
function checkValues(val, valref,g) {
	if(valref >=0) {
		var edtrul = g.p.colModel[valref].editrules;
	}
	if(edtrul) {
		if(edtrul.required === true) {
			if( val.match(/^s+$/) || val == "" )  return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.required,""];
		}
		// force required
		var rqfield = edtrul.required === false ? false : true;
		if(edtrul.number === true) {
			if( !(rqfield === false && isEmpty(val)) ) {
				if(isNaN(val)) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.number,""];
			}
		}
		if(edtrul.minValue && !isNaN(edtrul.minValue)) {
			if (parseFloat(val) < parseFloat(edtrul.minValue) ) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.minValue+" "+edtrul.minValue,""];
		}
		if(edtrul.maxValue && !isNaN(edtrul.maxValue)) {
			if (parseFloat(val) > parseFloat(edtrul.maxValue) ) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.maxValue+" "+edtrul.maxValue,""];
		}
		if(edtrul.email === true) {
			if( !(rqfield === false && isEmpty(val)) ) {
			// taken from jquery Validate plugin
				var filter = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
				if(!filter.test(val)) {return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.email,""];}
			}
		}
		if(edtrul.integer === true) {
			if( !(rqfield === false && isEmpty(val)) ) {
				if(isNaN(val)) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.integer,""];
				if ((val % 1 != 0) || (val.indexOf('.') != -1)) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.integer,""];
			}
		}
		if(edtrul.date === true) {
			if( !(rqfield === false && isEmpty(val)) ) {
				var dft = g.p.colModel[valref].datefmt || "Y-m-d";
				if(!checkDate (dft, val)) return [false,g.p.colNames[valref]+": "+jQuery.jgrid.edit.msg.date+" - "+dft,""];
			}
		}
	}
	return [true,"",""];
};
// Date Validation Javascript
function checkDate (format, date) {
	var tsp = {};
	var result =  false;
	var sep;
	format = format.toLowerCase();
	//we search for /,-,. for the date separator
	if(format.indexOf("/") != -1) {
		sep = "/";
	} else if(format.indexOf("-") != -1) {
		sep = "-";
	} else if(format.indexOf(".") != -1) {
		sep = ".";
	} else {
		sep = "/";
	}
	format = format.split(sep);
	date = date.split(sep);
	if (date.length != 3) return false;
	var j=-1,yln, dln=-1, mln=-1;
	for(var i=0;i<format.length;i++){
		var dv =  isNaN(date[i]) ? 0 : parseInt(date[i],10); 
		tsp[format[i]] = dv;
		yln = format[i];
		if(yln.indexOf("y") != -1) { j=i; }
		if(yln.indexOf("m") != -1) {mln=i}
		if(yln.indexOf("d") != -1) {dln=i}
	}
	if (format[j] == "y" || format[j] == "yyyy") {
		yln=4;
	} else if(format[j] =="yy"){
		yln = 2;
	} else {
		yln = -1;
	}
	var daysInMonth = DaysArray(12);
	var strDate;
	if (j === -1) {
		return false;
	} else {
		strDate = tsp[format[j]].toString();
		if(yln == 2 && strDate.length == 1) {yln = 1;}
		if (strDate.length != yln || tsp[format[j]]==0 ){
			return false;
		}
	}
	if(mln === -1) {
		return false;
	} else {
		strDate = tsp[format[mln]].toString();
		if (strDate.length<1 || tsp[format[mln]]<1 || tsp[format[mln]]>12){
			return false;
		}
	}
	if(dln === -1) {
		return false;
	} else {
		strDate = tsp[format[dln]].toString();
		if (strDate.length<1 || tsp[format[dln]]<1 || tsp[format[dln]]>31 || (tsp[format[mln]]==2 && tsp[format[dln]]>daysInFebruary(tsp[format[j]])) || tsp[format[dln]] > daysInMonth[tsp[format[mln]]]){
			return false;
		}
	}
	return true;
}
function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31;
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30;}
		if (i==2) {this[i] = 29;}
	} 
	return this;
}

function isEmpty(val)
{
	if (val.match(/^s+$/) || val == "")	{
		return true;
	} else {
		return false;
	} 
}
function htmlEncode (value){
    return !value ? value : String(value).replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;");
}
;(function($){
/**
 * jqGrid extension for form editing Grid Data
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
var rp_ge = null;
$.fn.extend({
	searchGrid : function ( p ) {
		p = $.extend({
			top : 0,
			left: 0,
			width: 360,
			height: 80,
			modal: false,
			drag: true,
			closeicon: 'ico-close.gif',
			dirty: false,
			sField:'searchField',
			sValue:'searchString',
			sOper: 'searchOper',
			processData: "",
			checkInput :false,
			beforeShowSearch: null,
			afterShowSearch : null,
			onInitializeSearch: null,
			closeAfterSearch : false,
			// translation
			// if you want to change or remove the order change it in sopt
			// ['bw','eq','ne','lt','le','gt','ge','ew','cn'] 
			sopt: null 
		}, $.jgrid.search, p || {});
		return this.each(function(){
			var $t = this;
			if( !$t.grid ) { return; }
			if(!p.imgpath) { p.imgpath= $t.p.imgpath; }
			var gID = $("table:first",$t.grid.bDiv).attr("id");
			var IDs = { themodal:'srchmod'+gID,modalhead:'srchhead'+gID,modalcontent:'srchcnt'+gID };
			if ( $("#"+IDs.themodal).html() != null ) {
				if( $.isFunction('beforeShowSearch') ) { p.beforeShowSearch($("#srchcnt"+gID)); }
				viewModal("#"+IDs.themodal,{modal: p.modal});
				if( $.isFunction('afterShowSearch') ) { p.afterShowSearch($("#srchcnt"+gID)); }
			} else {
				var cM = $t.p.colModel;
				var cNames = "<select id='snames' class='search'>";
				var nm, hc, sf;
				for(var i=0; i< cM.length;i++) {
					nm = cM[i].name;
					sf = (cM[i].search===false) ? false: true;
					if(cM[i].editrules && cM[i].editrules.searchhidden === true) {
						hc = true;
					} else {
						if(cM[i].hidden === true ) {
							hc = false;
						} else {
							hc = true;
						}
					}					
					if( nm !== 'cb' && nm !== 'subgrid' && sf && hc===true ) { // add here condition for searchable
						var sname = (cM[i].index) ? cM[i].index : nm;
						cNames += "<option value='"+sname+"'>"+$t.p.colNames[i]+"</option>";
					}
				}
				cNames += "</select>";
				var getopt = p.sopt || ['bw','eq','ne','lt','le','gt','ge','ew','cn'];
				var sOpt = "<select id='sopt' class='search'>";
				for(var i = 0; i<getopt.length;i++) {
					sOpt += getopt[i]=='eq' ? "<option value='eq'>"+p.odata[0]+"</option>" : "";
					sOpt += getopt[i]=='ne' ? "<option value='ne'>"+p.odata[1]+"</option>" : "";
					sOpt += getopt[i]=='lt' ? "<option value='lt'>"+p.odata[2]+"</option>" : "";
					sOpt += getopt[i]=='le' ? "<option value='le'>"+p.odata[3]+"</option>" : "";
					sOpt += getopt[i]=='gt' ? "<option value='gt'>"+p.odata[4]+"</option>" : "";
					sOpt += getopt[i]=='ge' ? "<option value='ge'>"+p.odata[5]+"</option>" : "";
					sOpt += getopt[i]=='bw' ? "<option value='bw'>"+p.odata[6]+"</option>" : "";
					sOpt += getopt[i]=='ew' ? "<option value='ew'>"+p.odata[7]+"</option>" : "";
					sOpt += getopt[i]=='cn' ? "<option value='cn'>"+p.odata[8]+"</option>" : "";
				};
				sOpt += "</select>";
				// field and buttons
				var sField  = "<input id='sval' class='search' type='text' size='20' maxlength='100'/>";
				var bSearch = "<input id='sbut' class='buttonsearch' type='button' value='"+p.Find+"'/>";
				var bReset  = "<input id='sreset' class='buttonsearch' type='button' value='"+p.Reset+"'/>";
				var cnt = $("<table width='100%'><tbody><tr style='display:none' id='srcherr'><td colspan='5'></td></tr><tr><td>"+cNames+"</td><td>"+sOpt+"</td><td>"+sField+"</td><td>"+bSearch+"</td><td>"+bReset+"</td></tr></tbody></table>");
				createModal(IDs,cnt,p,$t.grid.hDiv,$t.grid.hDiv);
				if ( $.isFunction('onInitializeSearch') ) { p.onInitializeSearch( $("#srchcnt"+gID) ); };
				if ( $.isFunction('beforeShowSearch') ) { p.beforeShowSearch($("#srchcnt"+gID)); };
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if($.isFunction('afterShowSearch')) { p.afterShowSearch($("#srchcnt"+gID)); }
				if(p.drag) { DnRModal("#"+IDs.themodal,"#"+IDs.modalhead+" td.modaltext"); }
				$("#sbut","#"+IDs.themodal).click(function(){
					if( $("#sval","#"+IDs.themodal).val() !="" ) {
						var es=[true,"",""];
						$("#srcherr >td","#srchcnt"+gID).html("").hide();
						$t.p.searchdata[p.sField] = $("option[selected]","#snames").val();
						$t.p.searchdata[p.sOper] = $("option[selected]","#sopt").val();
						$t.p.searchdata[p.sValue] = $("#sval","#"+IDs.modalcontent).val();
						if(p.checkInput) {
							for(var i=0; i< cM.length;i++) {
								var sname = (cM[i].index) ? cM[i].index : nm;
								if (sname == $t.p.searchdata[p.sField]) {
									break;
								}
							}
							es = checkValues($t.p.searchdata[p.sValue],i,$t);
						}
						if (es[0]===true) {
							$t.p.search = true; // initialize the search
							// construct array of data which is passed in populate() see jqGrid
							if(p.dirty) { $(".no-dirty-cell",$t.p.pager).addClass("dirty-cell"); }
							$t.p.page= 1;
							$($t).trigger("reloadGrid");
							if(p.closeAfterSearch === true) {
								hideModal("#"+IDs.themodal);
							}
						} else {
							$("#srcherr >td","#srchcnt"+gID).html(es[1]).show();
						}
					}
				});
				$("#sreset","#"+IDs.themodal).click(function(){
					if ($t.p.search) {
						$("#srcherr >td","#srchcnt"+gID).html("").hide();
						$t.p.search = false;
						$t.p.searchdata = {};
						$t.p.page= 1;
						$("#sval","#"+IDs.themodal).val("");
						if(p.dirty) { $(".no-dirty-cell",$t.p.pager).removeClass("dirty-cell"); }
						$($t).trigger("reloadGrid");
					}
				});
			}
		});
	},
	editGridRow : function(rowid, p){
		p = $.extend({
			top : 0,
			left: 0,
			width: 0,
			height: 0,
			modal: false,
			drag: true, 
			closeicon: 'ico-close.gif',
			imgpath: '',
			url: null,
			mtype : "POST",
			closeAfterAdd : false,
			clearAfterAdd : true,
			closeAfterEdit : false,
			reloadAfterSubmit : true,
			onInitializeForm: null,
			beforeInitData: null,
			beforeShowForm: null,
			afterShowForm: null,
			beforeSubmit: null,
			afterSubmit: null,
			onclickSubmit: null,
			afterComplete: null,
			onclickPgButtons : null,
			afterclickPgButtons: null,
			makingForm: null,
			editData : {},
			recreateForm : false,
			addedrow : "first"
		}, $.jgrid.edit, p || {});
		rp_ge = p;
		return this.each(function(){
			var $t = this;
			if (!$t.grid || !rowid) { return; }
			if(!p.imgpath) { p.imgpath= $t.p.imgpath; }
			// I hate to rewrite code, but ...
			var gID = $("table:first",$t.grid.bDiv).attr("id");
			var IDs = {themodal:'editmod'+gID,modalhead:'edithd'+gID,modalcontent:'editcnt'+gID};
			var onBeforeShow = $.isFunction(rp_ge.beforeShowForm) ? rp_ge.beforeShowForm : false;
			var onAfterShow = $.isFunction(rp_ge.afterShowForm) ? rp_ge.afterShowForm : false;
			var onBeforeInit = $.isFunction(rp_ge.beforeInitData) ? rp_ge.beforeInitData : false;
			var onInitializeForm = $.isFunction(rp_ge.onInitializeForm) ? rp_ge.onInitializeForm : false;
			if (rowid=="new") {
				rowid = "_empty";
				p.caption=p.addCaption;
			} else {
				p.caption=p.editCaption;
			};
			var frmgr = "FrmGrid_"+gID;
			var frmtb = "TblGrid_"+gID;
			if(p.recreateForm===true && $("#"+IDs.themodal).html() != null) {
				$("#"+IDs.themodal).remove();
			}
			if ( $("#"+IDs.themodal).html() != null ) {
				$(".modaltext","#"+IDs.modalhead).html(p.caption);
				$("#FormError","#"+frmtb).hide();
				if(onBeforeInit) { onBeforeInit($("#"+frmgr)); }
				fillData(rowid,$t);
				//if(rowid=="_empty") { 
					$("#pData, #nData","#"+frmtb).hide(); //Ian always hide the next prev buttons since the JSON fields don't work well.
				//} else { 
				//	$("#pData, #nData","#"+frmtb).show(); 
				//}
				if(onBeforeShow) { onBeforeShow($("#"+frmgr)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				$("div.loading","#"+IDs.themodal).hide(); //Ian make sure the "processing" is hidden the fade didn't work if the dialog box was already hidden and "processing" would show up next time box was displayed.
				if(onAfterShow) { onAfterShow($("#"+frmgr)); }
			} else {
				var frm = $("<form name='FormPost' id='"+frmgr+"' class='FormGrid'></form>");
				var tbl =$("<table id='"+frmtb+"' class='EditTable' cellspacing='0' cellpading='0' border='0'><tbody></tbody></table>");
				$(frm).append(tbl);
				$(tbl).append("<tr id='FormError' style='display:none'><td colspan='2'>"+"&nbsp;"+"</td></tr>");
				// set the id.
				// use carefull only to change here colproperties.
				if(onBeforeInit) { onBeforeInit($("#"+frmgr)); }
				var valref = createData(rowid,$t,tbl);
				// buttons at footer
				
				// Ian insert a bunch of rows for the new fields.
				if( $.isFunction(rp_ge.makingForm))  { ret = rp_ge.makingForm($(tbl), $t.p.colModel); }
				
				var imp = $t.p.imgpath;
				var bP  ="<img id='pData' src='"+imp+$t.p.previmg+"'/>";
				var bN  ="<img id='nData' src='"+imp+$t.p.nextimg+"'/>";
				var bS  ="<input id='sData' type='button' class='EditButton' value='"+p.bSubmit+"'/>";
				var bC  ="<input id='cData' type='button'  class='EditButton' value='"+p.bCancel+"'/>";
				$(tbl).append("<tr id='Act_Buttons'><td class='navButton'>"+bP+"&nbsp;"+bN+"</td><td class='EditButton'>"+bS+"&nbsp;"+bC+"</td></tr>");
				// beforeinitdata after creation of the form
				
				
				
				createModal(IDs,frm,p,$t.grid.hDiv,$t.grid.hDiv);
				// here initform - only once
				if(onInitializeForm) { onInitializeForm($("#"+frmgr)); }
				if( p.drag ) { DnRModal("#"+IDs.themodal,"#"+IDs.modalhead+" td.modaltext"); }
				//if(rowid=="_empty") { 
					$("#pData,#nData","#"+frmtb).hide(); //Ian hide prev and next buttons 
				//} else { 
				//	$("#pData,#nData","#"+frmtb).show(); 
				//}
				if(onBeforeShow) { onBeforeShow($("#"+frmgr)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if(onAfterShow) { onAfterShow($("#"+frmgr)); }
				$("#sData", "#"+frmtb).click(function(e){
					var postdata = {}, ret=[true,"",""], extpost={};
					$("#FormError","#"+frmtb).hide();
					// all depend on ret array
					//ret[0] - succes
					//ret[1] - msg if not succes
					//ret[2] - the id  that will be set if reload after submit false
					var j =0;
					$(".FormElement", "#"+frmtb).each(function(i){
						var suc =  true;
						switch ($(this).get(0).type) {
							case "checkbox":
								if($(this).attr("checked")) {
									postdata[this.name]= $(this).val();
								}else {
									var ofv = $(this).attr("offval");
									postdata[this.name]= ofv;
									extpost[this.name] = ofv;
								}
							break;
							case "select-one":
								postdata[this.name]= $("option:selected",this).val();
								extpost[this.name]= $("option:selected",this).text();
							break;
							case "select-multiple":
								postdata[this.name]= $(this).val();
								var selectedText = [];
								$("option:selected",this).each(
									function(i,selected){
										selectedText[i] = $(selected).text();
									}
								);
								extpost[this.name]= selectedText.join(",");
							break;								
							case "password":
							case "text":
							case "textarea":
								postdata[this.name] = $(this).val();
								ret = checkValues(postdata[this.name],valref[i],$t);
								if(ret[0] === false) {
									suc=false;
								} else {
									postdata[this.name] = htmlEncode(postdata[this.name]);
								}
							break;
						}
						j++;
						if(!suc) { return false; }
					});
					if(j==0) { ret[0] = false; ret[1] = $.jgrid.errors.norecords; }
					if( $.isFunction( rp_ge.onclickSubmit)) { rp_ge.editData = rp_ge.onclickSubmit(p) || {}; }
					if(ret[0]) {
						if( $.isFunction(rp_ge.beforeSubmit))  { ret = rp_ge.beforeSubmit(postdata,$("#"+frmgr)); }
					}
					var gurl = rp_ge.url ? rp_ge.url : $t.p.editurl;
					if(ret[0]) {
						if(!gurl) { ret[0]=false; ret[1] += " "+$.jgrid.errors.nourl; }
					}
					if(ret[0] === false) {
						$("#FormError>td","#"+frmtb).html(" " + ret[1]);
						$("#FormError","#"+frmtb).show();
					} else {
						if(!p.processing) {
							p.processing = true;
							if (!rp_ge.closeAfterEdit) $("div.loading","#"+IDs.themodal).fadeIn("fast"); //Ian don't display "processing" if are going to hide the dialog box after add anyway
							$(this).attr("disabled",true);
							// we add to pos data array the action - the name is oper
							//postdata.oper = postdata.id == "_empty" ? "add" : "edit"; //Ian - removed the .oper from the post since it confuses the backend.
							postdata = $.extend(postdata,rp_ge.editData);
							$.ajax({
								url:gurl,
								type: rp_ge.mtype,
								data:postdata,
								complete:function(data,Status){
									if(Status != "success") {
										ret[0] = false;
										ret[1] = Status+" Status: "+data.statusText +" Error code: "+data.status;
										//Ian added this function
										if( $.isFunction(rp_ge.afterSubmit) ) {
											ret = rp_ge.afterSubmit(data,postdata);
										}										
									} else {
										// data is posted successful
										// execute aftersubmit with the returned data from server
										if( $.isFunction(rp_ge.afterSubmit) ) {
											ret = rp_ge.afterSubmit(data,postdata);
										}
									}
									if(ret[0] === false) {
										$("#FormError>td","#"+frmtb).html(ret[1]);
										$("#FormError","#"+frmtb).show();
									} else {
										postdata = $.extend(postdata,extpost);
										// the action is add
										if(postdata.id=="_empty" || rp_ge.mtype == 'POST') { //Ian needed to add another way of recognizing add
											//id processing
											// user not set the id ret[2]
											if(!ret[2]) { 
												ret[2] = parseInt($($t).getGridParam('records'))+1; 
											}
											postdata.id = ret[2];
											if(rp_ge.closeAfterAdd) {
												if(rp_ge.reloadAfterSubmit) { $($t).trigger("reloadGrid"); }
												else {
													$($t).addRowData(ret[2],postdata,p.addedrow);
													$($t).setSelection(ret[2]);
												}
												hideModal("#"+IDs.themodal);
											} else if (rp_ge.clearAfterAdd) {
												if(rp_ge.reloadAfterSubmit) { $($t).trigger("reloadGrid"); }
												else { $($t).addRowData(ret[2],postdata,p.addedrow); }
												$(".FormElement", "#"+frmtb).each(function(i){
													switch ($(this).get(0).type) {
													case "checkbox":
														$(this).attr("checked",0);
														break;
													case "select-one":
													case "select-multiple":
														$("option",this).attr("selected","");
														break;
														case "password":
														case "text":
														case "textarea":
															if(this.name =='id') { $(this).val("_empty"); }
															else { $(this).val(""); }
														break;
													}
												});
											} else {
												if(rp_ge.reloadAfterSubmit) { $($t).trigger("reloadGrid"); }
												else { $($t).addRowData(ret[2],postdata,p.addedrow); }
											}
										} else {
											// the action is update
											if(rp_ge.reloadAfterSubmit) {
												$($t).trigger("reloadGrid");
												if( !rp_ge.closeAfterEdit ) { $($t).setSelection(postdata.id); }
											} else {
												if($t.p.treeGrid === true) {
													$($t).setTreeRow(postdata.id,postdata);
												} else {
													$($t).setRowData(postdata.id,postdata);
												}
											}
											if(rp_ge.closeAfterEdit) { hideModal("#"+IDs.themodal); }
										}
										if($.isFunction(rp_ge.afterComplete)) {
											setTimeout(function(){rp_ge.afterComplete(data,postdata,$("#"+frmgr));},500);
										}
									}
									p.processing=false;
									$("#sData", "#"+frmtb).attr("disabled",false);
									$("div.loading","#"+IDs.themodal).fadeOut("fast");
								}
							});
						}
					}
					e.stopPropagation();
				});
				$("#cData", "#"+frmtb).click(function(e){
					hideModal("#"+IDs.themodal);
					e.stopPropagation();
				});
				$("#nData", "#"+frmtb).click(function(e){
					$("#FormError","#"+frmtb).hide();
					var npos = getCurrPos();
					npos[0] = parseInt(npos[0]);
					if(npos[0] != -1 && npos[1][npos[0]+1]) {
						if($.isFunction(p.onclickPgButtons)) {
							p.onclickPgButtons('next',$("#"+frmgr),npos[1][npos[0]]);
						}
						fillData(npos[1][npos[0]+1],$t);
						$($t).setSelection(npos[1][npos[0]+1]);
						if($.isFunction(p.afterclickPgButtons)) {
							p.afterclickPgButtons('next',$("#"+frmgr),npos[1][npos[0]+1]);
						}
						updateNav(npos[0]+1,npos[1].length-1);
					};
					return false;
				});
				$("#pData", "#"+frmtb).click(function(e){
					$("#FormError","#"+frmtb).hide();
					var ppos = getCurrPos();
					if(ppos[0] != -1 && ppos[1][ppos[0]-1]) {
						if($.isFunction(p.onclickPgButtons)) {
							p.onclickPgButtons('prev',$("#"+frmgr),ppos[1][ppos[0]]);
						}
						fillData(ppos[1][ppos[0]-1],$t);
						$($t).setSelection(ppos[1][ppos[0]-1]);
						if($.isFunction(p.afterclickPgButtons)) {
							p.afterclickPgButtons('prev',$("#"+frmgr),ppos[1][ppos[0]-1]);
						}
						updateNav(ppos[0]-1,ppos[1].length-1);
					};
					return false;
				});
			};
			var posInit =getCurrPos();
			updateNav(posInit[0],posInit[1].length-1);
			function updateNav(cr,totr,rid){                
				var imp = $t.p.imgpath;
				if (cr==0) { $("#pData","#"+frmtb).attr("src",imp+"off-"+$t.p.previmg); } else { $("#pData","#"+frmtb).attr("src",imp+$t.p.previmg); }
				if (cr==totr) { $("#nData","#"+frmtb).attr("src",imp+"off-"+$t.p.nextimg); } else { $("#nData","#"+frmtb).attr("src",imp+$t.p.nextimg); }
			};
			function getCurrPos() {
				var rowsInGrid = $($t).getDataIDs();
				var selrow = $("#id_g","#"+frmtb).val();
				var pos = $.inArray(selrow,rowsInGrid);
				return [pos,rowsInGrid];
			};
			function createData(rowid,obj,tb){
				var nm, hc,trdata, tdl, tde, cnt=0,tmp, dc,elc, retpos=[];
				$('#'+rowid+' td',obj.grid.bDiv).each( function(i) {
					nm = obj.p.colModel[i].name;
					// hidden fields are included in the form
					if(obj.p.colModel[i].editrules && obj.p.colModel[i].editrules.edithidden == true) {
						hc = false;
					} else {
						hc = obj.p.colModel[i].hidden === true ? true : false;
					}
					dc = hc ? "style='display:none'" : "";
					if ( nm !== 'cb' && nm !== 'subgrid' && obj.p.colModel[i].editable===true) {
						if(nm == obj.p.ExpandColumn && obj.p.treeGrid === true) {
							tmp = $(this).text();
						} else {
							try {
								tmp =  $.unformat(this,{colModel:obj.p.colModel[i]},i);
							} catch (_) {
								tmp = $.htmlDecode($(this).html());
							}
						}
						var opt = $.extend(obj.p.colModel[i].editoptions || {} ,{id:nm,name:nm});
						if(!obj.p.colModel[i].edittype) obj.p.colModel[i].edittype = "text";
						elc = createEl(obj.p.colModel[i].edittype,opt,tmp);
						$(elc).addClass("FormElement");
						trdata = $("<tr "+dc+"></tr>").addClass("FormData").attr("id","tr_"+nm);
						tdl = $("<td></td>").addClass("CaptionTD");
						tde = $("<td></td>").addClass("DataTD");
						$(tdl).html(obj.p.colNames[i]+": ");
						$(tde).append(elc);
						trdata.append(tdl);
						trdata.append(tde);
						if(tb) { $(tb).append(trdata); }
						else { $(trdata).insertBefore("#Act_Buttons"); }
						retpos[cnt] = i;
						cnt++;
					};
				});
				if( cnt > 0) {
					var idrow = $("<tr class='FormData' style='display:none'><td class='CaptionTD'>"+"&nbsp;"+"</td><td class='DataTD'><input class='FormElement' id='id_g' type='text' name='id' value='"+rowid+"'/></td></tr>");
					if(tb) { $(tb).append(idrow); }
					else { $(idrow).insertBefore("#Act_Buttons"); }
				}
				return retpos;
			};
			function fillData(rowid,obj){
				var nm, hc,cnt=0,tmp;
				$('#'+rowid+' td',obj.grid.bDiv).each( function(i) {
					nm = obj.p.colModel[i].name;
					// hidden fields are included in the form
					if(obj.p.colModel[i].editrules && obj.p.colModel[i].editrules.edithidden === true) {
						hc = false;
					} else {
						hc = obj.p.colModel[i].hidden === true ? true : false;
					}
					if ( nm !== 'cb' && nm !== 'subgrid' && obj.p.colModel[i].editable===true) {
						if(nm == obj.p.ExpandColumn && obj.p.treeGrid === true) {
							tmp = $(this).text();
						} else {
							try {
								tmp =  $.unformat(this,{colModel:obj.p.colModel[i]},i);
							} catch (_) {
								tmp = $.htmlDecode($(this).html());
							}
						}
						nm= nm.replace('.',"\\.");
						switch (obj.p.colModel[i].edittype) {
							case "password":
							case "text":
								tmp = $.htmlDecode(tmp);
								$("#"+nm,"#"+frmtb).val(tmp);
								break;
							case "textarea":
								if(tmp == "&nbsp;" || tmp == "&#160;") {tmp='';}
								$("#"+nm,"#"+frmtb).val(tmp);
								break;
							case "select":
								$("#"+nm+" option","#"+frmtb).each(function(j){
									if (!obj.p.colModel[i].editoptions.multiple && tmp == $(this).text() ){
										this.selected= true;
									} else if (obj.p.colModel[i].editoptions.multiple){
										if(  $.inArray($(this).text(), tmp.split(",") ) > -1  ){
											this.selected = true;
										}else{
											this.selected = false;
										}
									} else {
										this.selected = false;
									}
								});
								break;
							case "checkbox":
								if(tmp==$("#"+nm,"#"+frmtb).val()) {
									$("#"+nm,"#"+frmtb).attr("checked",true);
									$("#"+nm,"#"+frmtb).attr("defaultChecked",true); //ie
								} else {
									$("#"+nm,"#"+frmtb).attr("checked",false);
									$("#"+nm,"#"+frmtb).attr("defaultChecked",""); //ie
								}
								break; 
						}
						if (hc) { $("#"+nm,"#"+frmtb).parents("tr:first").hide(); }
						cnt++;
					}
				});
				if(cnt>0) { $("#id_g","#"+frmtb).val(rowid); }
				else { $("#id_g","#"+frmtb).val(""); }
				return cnt;
			};
		});
	},
	delGridRow : function(rowids,p) {
		p = $.extend({
			top : 0,
			left: 0,
			width: 240,
			height: 90,
			modal: false,
			drag: true, 
			closeicon: 'ico-close.gif',
			imgpath: '',
			url : '',
			mtype : "POST",
			reloadAfterSubmit: true,
			beforeShowForm: null,
			afterShowForm: null,
			beforeSubmit: null,
			onclickSubmit: null,
			afterSubmit: null,
			onclickSubmit: null,
			delData: {}
		}, $.jgrid.del, p ||{});
		return this.each(function(){
			var $t = this;
			if (!$t.grid ) { return; }
			if(!rowids) { return; }
			if(!p.imgpath) { p.imgpath= $t.p.imgpath; }
			var onBeforeShow = typeof p.beforeShowForm === 'function' ? true: false;
			var onAfterShow = typeof p.afterShowForm === 'function' ? true: false;
			if (isArray(rowids)) { rowids = rowids.join(); }
			var gID = $("table:first",$t.grid.bDiv).attr("id");
			var IDs = {themodal:'delmod'+gID,modalhead:'delhd'+gID,modalcontent:'delcnt'+gID};
			var dtbl = "DelTbl_"+gID;
			if ( $("#"+IDs.themodal).html() != null ) {
				$("#DelData>td","#"+dtbl).text(rowids);
				$("#DelError","#"+dtbl).hide();
				if(onBeforeShow) { p.beforeShowForm($("#"+dtbl)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if(onAfterShow) { p.afterShowForm($("#"+dtbl)); }
			} else {
				var tbl =$("<table id='"+dtbl+"' class='DelTable'><tbody></tbody></table>");
				// error data 
				$(tbl).append("<tr id='DelError' style='display:none'><td >"+"&nbsp;"+"</td></tr>");
				$(tbl).append("<tr id='DelData' style='display:none'><td >"+rowids+"</td></tr>");
				$(tbl).append("<tr><td >"+p.msg+"</td></tr>");
				// buttons at footer
				var bS  ="<input id='dData' type='button' value='"+p.bSubmit+"'/>";
				var bC  ="<input id='eData' type='button' value='"+p.bCancel+"'/>";
				$(tbl).append("<tr><td class='DelButton'>"+bS+"&nbsp;"+bC+"</td></tr>");
				createModal(IDs,tbl,p,$t.grid.hDiv,$t.grid.hDiv);
				if( p.drag) { DnRModal("#"+IDs.themodal,"#"+IDs.modalhead+" td.modaltext"); }
				$("#dData","#"+dtbl).click(function(e){
					/*
					Ian this function has a bug. It creates a closure with the delGridRow function so it can access the "p" variable.
					However the second time it is called it still accesses the original "p" variable.
					*/
					var ret=[true,""];
					var postdata = $("#DelData>td","#"+dtbl).text(); //the pair is name=val1,val2,...
					if( typeof p.onclickSubmit === 'function' ) { p.delData = p.onclickSubmit(p) || {}; }
					if( typeof p.beforeSubmit === 'function' ) { ret = p.beforeSubmit(postdata); }
					var gurl = p.url ? p.url : $t.p.editurl;
					if(!gurl) { ret[0]=false;ret[1] += " "+$.jgrid.errors.nourl;}
					if(ret[0] === false) {
						$("#DelError>td","#"+dtbl).html(ret[1]);
						$("#DelError","#"+dtbl).show();
					} else {
						if(!p.processing) {
							p.processing = true;
							$("div.loading","#"+IDs.themodal).fadeIn("fast");
							$(this).attr("disabled",true);
							var postd = $.extend({oper:"del", id:postdata},p.delData);
							$.ajax({
								url:gurl,
								type: p.mtype,
								data:postd,
								complete:function(data,Status){
									if(Status != "success") {
										ret[0] = false;
										ret[1] = Status+" Status: "+data.statusText +" Error code: "+data.status;
										if( typeof p.afterSubmit === 'function' ) {
											ret = p.afterSubmit(data,postdata);
										}										
									} else {
										// data is posted successful
										// execute aftersubmit with the returned data from server
										if( typeof p.afterSubmit === 'function' ) {
											ret = p.afterSubmit(data,postdata);
										}
									}
									if(ret[0] === false) {
										$("#DelError>td","#"+dtbl).html(ret[1]);
										$("#DelError","#"+dtbl).show();
									} else {
										if(p.reloadAfterSubmit) {
											if($t.p.treeGrid) {
												$($t).setGridParam({treeANode:0,datatype:$t.p.treedatatype});
											}
											$($t).trigger("reloadGrid");
										} else {
											var toarr = [];
											toarr = postdata.split(",");
											if($t.p.treeGrid===true){
												try {$($t).delTreeNode(toarr[0])} catch(e){}
											} else {
												for(var i=0;i<toarr.length;i++) {
													$($t).delRowData(toarr[i]);
												}
											}
											$t.p.selrow = null;
											$t.p.selarrrow = [];
										}
										if($.isFunction(p.afterComplete)) {
											setTimeout(function(){p.afterComplete(data,postdata);},500);
										}
									}
									p.processing=false;
									$("#dData", "#"+dtbl).attr("disabled",false);
									$("div.loading","#"+IDs.themodal).hide();
									if(ret[0]) { hideModal("#"+IDs.themodal); }
								}
							});
						}
					}
					return false;
				});
				$("#eData", "#"+dtbl).click(function(e){
					hideModal("#"+IDs.themodal);
					return false;
				});
				if(onBeforeShow) { p.beforeShowForm($("#"+dtbl)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if(onAfterShow) { p.afterShowForm($("#"+dtbl)); }
			}
		});
	},
	navGrid : function (elem, o, pEdit,pAdd,pDel,pSearch) {
		o = $.extend({
			edit: true,
			editicon: "row_edit.gif",

			add: true,
			addicon:"row_add.gif",

			del: true,
			delicon:"row_delete.gif",

			search: true,
			searchicon:"find.gif",

			refresh: true,
			refreshicon:"refresh.gif",
			refreshstate: 'firstpage',

			position : "left",
			closeicon: "ico-close.gif"
		}, $.jgrid.nav, o ||{});
		return this.each(function() {       
			var alertIDs = {themodal:'alertmod',modalhead:'alerthd',modalcontent:'alertcnt'};
			var $t = this;
			if(!$t.grid) { return; }
			if ($("#"+alertIDs.themodal).html() == null) {
				var vwidth;
				var vheight;
				if (typeof window.innerWidth != 'undefined') {
					vwidth = window.innerWidth,
					vheight = window.innerHeight
				} else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
					vwidth = document.documentElement.clientWidth,
					vheight = document.documentElement.clientHeight
				} else {
					vwidth=1024;
					vheight=768;
				}
				createModal(alertIDs,"<div>"+o.alerttext+"</div>",{imgpath:$t.p.imgpath,closeicon:o.closeicon,caption:o.alertcap,top:vheight/2-25,left:vwidth/2-100,width:200,height:50},$t.grid.hDiv,$t.grid.hDiv,true);
				DnRModal("#"+alertIDs.themodal,"#"+alertIDs.modalhead);
			}
			var navTbl = $("<table cellspacing='0' cellpadding='0' border='0' class='navtable'><tbody></tbody></table>").height(20);
			var trd = document.createElement("tr");
			$(trd).addClass("nav-row");
			var imp = $t.p.imgpath;
			var tbd;
			if (o.add) {
				tbd = document.createElement("td");
				$(tbd).append("&nbsp;").css({border:"none",padding:"0px"});
				trd.appendChild(tbd);
				tbd = document.createElement("td");
				tbd.title = o.addtitle || "";
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td><img src='"+imp+o.addicon+"'/></td><td>"+o.addtext+"&nbsp;</td></tr></table>")
				.css("cursor","pointer")
				.addClass("nav-button")
				.click(function(){
					if (typeof o.addfunc == 'function') {
						o.addfunc();
					} else {
						$($t).editGridRow("new",pAdd || {});
					}
					return false;
				})
				.hover(
					function () {
						$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				trd.appendChild(tbd);
				tbd = null;
			}
			if (o.edit) {
				tbd = document.createElement("td");
				$(tbd).append("&nbsp;").css({border:"none",padding:"0px"});
				trd.appendChild(tbd);
				tbd = document.createElement("td");
				tbd.title = o.edittitle || "";
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td><img src='"+imp+o.editicon+"'/></td><td valign='center'>"+o.edittext+"&nbsp;</td></tr></table>")
				.css("cursor","pointer")
				.addClass("nav-button")
				.click(function(){
					var sr = $($t).getGridParam('selrow');
					if (sr) {
						if(typeof o.editfunc == 'function') {
							o.editfunc(sr);
						} else {
							$($t).editGridRow(sr,pEdit || {});
						}
					} else {
						viewModal("#"+alertIDs.themodal);
					}
					return false;
				})
				.hover( function () {
					$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				trd.appendChild(tbd);
				tbd = null;
			}
			if (o.del) {
				tbd = document.createElement("td");
				$(tbd).append("&nbsp;").css({border:"none",padding:"0px"});
				trd.appendChild(tbd);
				tbd = document.createElement("td");
				tbd.title = o.deltitle || "";
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td><img src='"+imp+o.delicon+"'/></td><td>"+o.deltext+"&nbsp;</td></tr></table>")
				.css("cursor","pointer")
				.addClass("nav-button")
				.click(function(){
					var dr;
					if($t.p.multiselect) {
						dr = $($t).getGridParam('selarrrow');
						if(dr.length==0) { dr = null; }
					} else {
						dr = $($t).getGridParam('selrow');
					}
					if (dr) { $($t).delGridRow(dr,pDel || {}); }
					else  { viewModal("#"+alertIDs.themodal); }
					return false;
				})
				.hover(
					function () {
						$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				trd.appendChild(tbd);
				tbd = null;
			}
			if (o.search) {
				tbd = document.createElement("td");
				$(tbd).append("&nbsp;").css({border:"none",padding:"0px"});
				trd.appendChild(tbd);
				tbd = document.createElement("td");
				if( $(elem)[0] == $t.p.pager[0] ) { pSearch = $.extend(pSearch,{dirty:true}); }
				tbd.title = o.searchtitle || "";
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td class='no-dirty-cell'><img src='"+imp+o.searchicon+"'/></td><td>"+o.searchtext+"&nbsp;</td></tr></table>")
				.css({cursor:"pointer"})
				.addClass("nav-button")
				.click(function(){
					$($t).searchGrid(pSearch || {});
					return false;
				})
				.hover(
					function () {
						$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				trd.appendChild(tbd);
				tbd = null;
			}
			if (o.refresh) {
				tbd = document.createElement("td");
				$(tbd).append("&nbsp;").css({border:"none",padding:"0px"});
				trd.appendChild(tbd);
				tbd = document.createElement("td");
				tbd.title = o.refreshtitle || "";
				var dirtycell =  ($(elem)[0] == $t.p.pager[0] ) ? true : false;
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td><img src='"+imp+o.refreshicon+"'/></td><td>"+o.refreshtext+"&nbsp;</td></tr></table>")
				.css("cursor","pointer")
				.addClass("nav-button")
				.click(function(){
					$t.p.search = false;
					switch (o.refreshstate) {
						case 'firstpage':
							$t.p.page=1;
							$($t).trigger("reloadGrid");
							break;
						case 'current':
							var sr = $t.p.multiselect===true ? selarrrow : $t.p.selrow;
							$($t).setGridParam({gridComplete: function() {
								if($t.p.multiselect===true) {
									if(sr.length>0) {
										for(var i=0;i<sr.length;i++){
											$($t).setSelection(sr[i]);
										}
									}
								} else {
									if(sr) {
										$($t).setSelection(sr);
									}
								}
							}});
							$($t).trigger("reloadGrid");
							break;
					}
					if (dirtycell) { $(".no-dirty-cell",$t.p.pager).removeClass("dirty-cell"); }
					if(o.search) {
						var gID = $("table:first",$t.grid.bDiv).attr("id");
						$("#sval",'#srchcnt'+gID).val("");
					}
					return false;
				})
				.hover(
					function () {
						$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				trd.appendChild(tbd);
				tbd = null;
			}
			if(o.position=="left") {
				$(navTbl).append(trd).addClass("nav-table-left");
			} else {
				$(navTbl).append(trd).addClass("nav-table-right");
			}
			$(elem).prepend(navTbl);
		});
	},
	navButtonAdd : function (elem, p) {
		p = $.extend({
			caption : "newButton",
			title: '',
			buttonimg : '',
			onClickButton: null,
			position : "last"
		}, p ||{});
		return this.each(function() {
			if( !this.grid)  { return; }
			if( elem.indexOf("#") != 0) { elem = "#"+elem; }
			var findnav = $(".navtable",elem)[0];
			if (findnav) {
				var tdb, tbd1;
				var tbd1 = document.createElement("td");
				$(tbd1).append("&nbsp;").css({border:"none",padding:"0px"});
				var trd = $("tr:eq(0)",findnav)[0];
				if( p.position !='first' ) {
					trd.appendChild(tbd1);
				}
				tbd = document.createElement("td");
				tbd.title = p.title;
				var im = (p.buttonimg) ? "<img src='"+p.buttonimg+"'/>" : "&nbsp;";
				$(tbd).append("<table cellspacing='0' cellpadding='0' border='0' class='tbutton'><tr><td>"+im+"</td><td>"+p.caption+"&nbsp;</td></tr></table>")
				.css("cursor","pointer")
				.addClass("nav-button")
				.click(function(e){
					if (typeof p.onClickButton == 'function') { p.onClickButton(); }
					e.stopPropagation();
					return false;
				})
				.hover(
					function () {
						$(this).addClass("nav-hover");
					},
					function () {
						$(this).removeClass("nav-hover");
					}
				);
				if(p.position != 'first') {
					trd.appendChild(tbd);
				} else {
					$(trd).prepend(tbd);
					$(trd).prepend(tbd1);
				}
				tbd=null;tbd1=null;
			}
		});
	},
	GridToForm : function( rowid, formid ) {
		return this.each(function(){
			var $t = this;
			if (!$t.grid) { return; } 
			var rowdata = $($t).getRowData(rowid);
			if (rowdata) {
				for(var i in rowdata) {
					if ( $("[name="+i+"]",formid).is("input:radio") )  {
						$("[name="+i+"]",formid).each( function() {
							if( $(this).val() == rowdata[i] ) {
								$(this).attr("checked","checked");
							} else {
								$(this).attr("checked","");
							}
						});
					} else {
					// this is very slow on big table and form.
						$("[name="+i+"]",formid).val(rowdata[i]);
					}
				}
			}
		});
	},
	FormToGrid : function(rowid, formid){
		return this.each(function() {
			var $t = this;
			if(!$t.grid) { return; }
			var fields = $(formid).serializeArray();
			var griddata = {};
			$.each(fields, function(i, field){
				griddata[field.name] = field.value;
			});
			$($t).setRowData(rowid,griddata);
		});
	}
});
})(jQuery);
;(function($){
/**
 * jqGrid extension for manipulating Grid Data
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
$.fn.extend({
//Editing
	editRow : function(rowid,keys,oneditfunc,succesfunc, url, extraparam, aftersavefunc,errorfunc) {
		return this.each(function(){
			var $t = this, nm, tmp, editable, cnt=0, focus=null, svr=[], ind;
			if (!$t.grid ) { return; }
			var sz, ml,hc;
			if( !$t.p.multiselect ) {
				ind = $($t).getInd($t.rows,rowid);
				if( ind === false ) {return;}
				editable = $($t.rows[ind]).attr("editable") || "0";
				if (editable == "0") {
					$('td',$t.rows[ind]).each( function(i) {
						nm = $t.p.colModel[i].name;
						hc = $t.p.colModel[i].hidden===true ? true : false;
						try {
							tmp =  $.unformat(this,{colModel:$t.p.colModel[i]},i);
						} catch (_) {
							tmp = $.htmlDecode($(this).html());
						}
						svr[nm]=tmp;
						if ( nm !== 'cb' && nm !== 'subgrid' && $t.p.colModel[i].editable===true && !hc) {
							if(focus===null) { focus = i; }
							$(this).html("");
							var opt = $.extend($t.p.colModel[i].editoptions || {} ,{id:rowid+"_"+nm,name:nm});
							if(!$t.p.colModel[i].edittype) { $t.p.colModel[i].edittype = "text"; }
							var elc = createEl($t.p.colModel[i].edittype,opt,tmp,$(this));
							$(elc).addClass("editable");
							$(this).append(elc);
							//Agin IE
							if($t.p.colModel[i].edittype == "select" && $t.p.colModel[i].editoptions.multiple===true && $.browser.msie) {
								$(elc).width($(elc).width());
							}
							cnt++;
						}
					});
					if(cnt > 0) {
						svr['id'] = rowid; $t.p.savedRow.push(svr);
						$($t.rows[ind]).attr("editable","1");
						$("td:eq("+focus+") input",$t.rows[ind]).focus();
						if(keys===true) {
							$($t.rows[ind]).bind("keydown",function(e) {
								if (e.keyCode === 27) { $($t).restoreRow(rowid);}
								if (e.keyCode === 13) {
									$($t).saveRow(rowid,succesfunc, url, extraparam, aftersavefunc,errorfunc);
									return false;
								}
								e.stopPropagation();
							});
						}
						if( $.isFunction(oneditfunc)) { oneditfunc(rowid); }
					}
				}
			}
		});
	},
	saveRow : function(rowid, succesfunc, url, extraparam, aftersavefunc,errorfunc) {
		return this.each(function(){
		var $t = this, nm, tmp={}, tmp2={}, editable, fr, cv, ms, ind;
		if (!$t.grid ) { return; }
		ind = $($t).getInd($t.rows,rowid);
		if(ind === false) {return;}
		editable = $($t.rows[ind]).attr("editable");
		url = url ? url : $t.p.editurl;
		if (editable==="1" && url) {
			$("td",$t.rows[ind]).each(function(i) {
				nm = $t.p.colModel[i].name;
				if ( nm !== 'cb' && nm !== 'subgrid' && $t.p.colModel[i].editable===true) {
					if( $t.p.colModel[i].hidden===true) { tmp[nm] = $(this).html(); }
					else {
						switch ($t.p.colModel[i].edittype) {
							case "checkbox":
								var cbv = ["Yes","No"];
								if($t.p.colModel[i].editoptions ) {
									cbv = $t.p.colModel[i].editoptions.value.split(":");
								}
								tmp[nm]=  $("input",this).attr("checked") ? cbv[0] : cbv[1]; 
								break;
							case 'text':
							case 'password':
							case 'textarea':
								tmp[nm]= htmlEncode($("input, textarea",this).val());
								break;
							case 'select':
								if(!$t.p.colModel[i].editoptions.multiple) {
									tmp[nm] = $("select>option:selected",this).val();
									tmp2[nm] = $("select>option:selected", this).text();
								} else {
									var sel = $("select",this);
									tmp[nm] = $(sel).val();
									var selectedText = [];
									$("select > option:selected",this).each(
										function(i,selected){
											selectedText[i] = $(selected).text();
										}
									);
									tmp2[nm] = selectedText.join(",");
								}
								break;
						}
						cv = checkValues(tmp[nm],i,$t);
						if(cv[0] === false) {
							cv[1] = tmp[nm] + " " + cv[1];
							return false;
						}
					}
				}
			});
			if (cv[0] === false){
				try {
					info_dialog($.jgrid.errors.errcap,cv[1],$.jgrid.edit.bClose, $t.p.imgpath);
				} catch (e) {
					alert(cv[1]);
				}
				return;
			}
			if(tmp) { tmp["id"] = rowid; if(extraparam) { tmp = $.extend({},tmp,extraparam);} }
			if(!$t.grid.hDiv.loading) {
				$t.grid.hDiv.loading = true;
				$("div.loading",$t.grid.hDiv).fadeIn("fast");
				if (url == 'clientArray') {
					tmp = $.extend({},tmp, tmp2);
					$($t).setRowData(rowid,tmp);
					$($t.rows[ind]).attr("editable","0");
					for( var k=0;k<$t.p.savedRow.length;k++) {
						if( $t.p.savedRow[k].id===rowid) {fr = k; break;}
					}
					if(fr >= 0) { $t.p.savedRow.splice(fr,1); }
					if( $.isFunction(aftersavefunc) ) { aftersavefunc(rowid); } //Ian removed the res.responseText parameter which will always be undefined since AJAX call is never made for "clientArray"
				} else {
					$.ajax({url:url,
						data: tmp,
						type: "POST",
						complete: function(res,stat){
							if (stat === "success"){
								var ret;
								if( $.isFunction(succesfunc)) { ret = succesfunc(res);}
								else ret = true;
								if (ret===true) {
									tmp = $.extend({},tmp, tmp2);
									$($t).setRowData(rowid,tmp);
									$($t.rows[ind]).attr("editable","0");
									for( var k=0;k<$t.p.savedRow.length;k++) {
										if( $t.p.savedRow[k].id===rowid) {fr = k; break;}
									};
									if(fr >= 0) { $t.p.savedRow.splice(fr,1); }
									if( $.isFunction(aftersavefunc) ) { aftersavefunc(rowid,res.responseText); }
								} else { $($t).restoreRow(rowid); }
							}
						},
						error:function(res,stat){
							if($.isFunction(errorfunc) ) {
								errorfunc(res,stat);
							} else {
								alert("Error Row: "+rowid+" Result: " +res.status+":"+res.statusText+" Status: "+stat);
							}
						}
					});
				}
				$t.grid.hDiv.loading = false;
				$("div.loading",$t.grid.hDiv).fadeOut("fast");
				$($t.rows[ind]).unbind("keydown");
			}
		}
		});
	},
	restoreRow : function(rowid) {
		return this.each(function(){
			var $t= this, nm, fr,ind;
			if (!$t.grid ) { return; }
			ind = $($t).getInd($t.rows,rowid);
			if(ind === false) {return;}
			for( var k=0;k<$t.p.savedRow.length;k++) {
				if( $t.p.savedRow[k].id===rowid) {fr = k; break;}
			}
			if(fr >= 0) {
				$($t).setRowData(rowid,$t.p.savedRow[fr]);
				$($t.rows[ind]).attr("editable","0");
				$t.p.savedRow.splice(fr,1);
			}
		});
	}
//end inline edit
});
})(jQuery);
;(function($){
/*
**
 * jqGrid extension for cellediting Grid Data
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
/**
 * all events and options here are aded anonynous and not in the base grid
 * since the array is to big. Here is the order of execution.
 * From this point we use jQuery isFunction
 * formatCell
 * beforeEditCell,
 * onSelectCell (used only for noneditable cels)
 * afterEditCell,
 * beforeSaveCell, (called before validation of values if any)
 * beforeSubmitCell (if cellsubmit remote (ajax))
 * afterSubmitCell(if cellsubmit remote (ajax)),
 * afterSaveCell,
 * errorCell,
 * Options
 * cellsubmit (remote,clientArray) (added in grid options)
 * cellurl
* */
$.fn.extend({
	editCell : function (iRow,iCol, ed, fg){
		return this.each(function (){
			var $t = this, nm, tmp,cc;
			if (!$t.grid || $t.p.cellEdit !== true) {return;}
			var currentFocus = null;
			// I HATE IE
			if ($.browser.msie && $.browser.version <=7 && ed===true && fg===true) {
				iCol = getAbsoluteIndex($t.rows[iRow],iCol);
			}
			iCol = parseInt(iCol,10);
			// select the row that can be used for other methods
			$t.p.selrow = $t.rows[iRow].id;
			if (!$t.p.knv) {$($t).GridNav();}
			// check to see if we have already edited cell
			if ($t.p.savedRow.length>0) {
				// prevent second click on that field and enable selects
				if (ed===true ) {
					if(iRow == $t.p.iRow && iCol == $t.p.iCol){
						return;
					}
				}
				// if so check to see if the content is changed
				var vl = $("td:eq("+$t.p.savedRow[0].ic+")>#"+$t.p.savedRow[0].id+"_"+$t.p.savedRow[0].name.replace('.',"\\."),$t.rows[$t.p.savedRow[0].id]).val();
				if ($t.p.savedRow[0].v !=  vl) {
					// save it
					$($t).saveCell($t.p.savedRow[0].id,$t.p.savedRow[0].ic)
				} else {
					// restore it
					$($t).restoreCell($t.p.savedRow[0].id,$t.p.savedRow[0].ic);
				}
			} else {
				window.setTimeout(function () { $("#"+$t.p.knv).attr("tabindex","-1").focus();},0);
			}
			nm = $t.p.colModel[iCol].name;
			if (nm=='subgrid') {return;}
			if ($t.p.colModel[iCol].editable===true && ed===true) {
				cc = $("td:eq("+iCol+")",$t.rows[iRow]);
				if(parseInt($t.p.iCol)>=0  && parseInt($t.p.iRow)>=0) {
					$("td:eq("+$t.p.iCol+")",$t.rows[$t.p.iRow]).removeClass("edit-cell");
					$($t.rows[$t.p.iRow]).removeClass("selected-row");
				}
				$(cc).addClass("edit-cell");
				$($t.rows[iRow]).addClass("selected-row");
				try {
					tmp =  $.unformat(cc,{colModel:$t.p.colModel[iCol]},iCol);
				} catch (_) {
					tmp = $.htmlDecode($(cc).html());
				}
				var opt = $.extend($t.p.colModel[iCol].editoptions || {} ,{id:iRow+"_"+nm,name:nm});
				if (!$t.p.colModel[iCol].edittype) {$t.p.colModel[iCol].edittype = "text";}
				$t.p.savedRow[0] = {id:iRow,ic:iCol,name:nm,v:tmp};
				if($.isFunction($t.p.formatCell)) {
					var tmp2 = $t.p.formatCell($t.rows[iRow].id,nm,tmp,iRow,iCol);
					if(tmp2) {tmp = tmp2;}
				}
				var elc = createEl($t.p.colModel[iCol].edittype,opt,tmp,cc);
				if ($.isFunction($t.p.beforeEditCell)) {
					$t.p.beforeEditCell($t.rows[iRow].id,nm,tmp,iRow,iCol);
				}
				$(cc).html("").append(elc);
				window.setTimeout(function () { $(elc).focus();},0);
				$("input, select, textarea",cc).bind("keydown",function(e) { 
					if (e.keyCode === 27) {$($t).restoreCell(iRow,iCol);} //ESC
					if (e.keyCode === 13) {$($t).saveCell(iRow,iCol);}//Enter
					if (e.keyCode == 9)  {
						if (e.shiftKey) {$($t).prevCell(iRow,iCol);} //Shift TAb
						else {$($t).nextCell(iRow,iCol);} //Tab
					}
					e.stopPropagation();
				});
				if ($.isFunction($t.p.afterEditCell)) {
					$t.p.afterEditCell($t.rows[iRow].id,nm,tmp,iRow,iCol);
				}
			} else {
				if (parseInt($t.p.iCol)>=0  && parseInt($t.p.iRow)>=0) {
					$("td:eq("+$t.p.iCol+")",$t.rows[$t.p.iRow]).removeClass("edit-cell");
					$($t.rows[$t.p.iRow]).removeClass("selected-row");
				}
				$("td:eq("+iCol+")",$t.rows[iRow]).addClass("edit-cell");
				$($t.rows[iRow]).addClass("selected-row"); 
				if ($.isFunction($t.p.onSelectCell)) {
					tmp = $("td:eq("+iCol+")",$t.rows[iRow]).html().replace(/\&nbsp\;/ig,'');
					$t.p.onSelectCell($t.rows[iRow].id,nm,tmp,iRow,iCol);
				}
			}
			$t.p.iCol = iCol; $t.p.iRow = iRow;
			// IE 6 bug 
			function getAbsoluteIndex(t,relIndex) 
			{ 
				var countnotvisible=0; 
				var countvisible=0; 
				for (i=0;i<t.cells.length;i++) { 
					var cell=t.cells(i); 
					if (cell.style.display=='none') countnotvisible++; else countvisible++; 
					if (countvisible>relIndex) return i; 
				} 
				return i; 
			}
		});
	},
	saveCell : function (iRow, iCol){
		return this.each(function(){
			var $t= this, nm, fr;
			if (!$t.grid || $t.p.cellEdit !== true) {return;}
			if ( $t.p.savedRow.length == 1) {fr = 0;} else {fr=null;} 
			if(fr != null) {
				var cc = $("td:eq("+iCol+")",$t.rows[iRow]),v,v2;
				nm = $t.p.colModel[iCol].name;
				switch ($t.p.colModel[iCol].edittype) {
					case "select":
						v = $("#"+iRow+"_"+nm.replace('.',"\\.")+">option:selected",$t.rows[iRow]).val();
						v2 = $("#"+iRow+"_"+nm.replace('.',"\\.")+">option:selected",$t.rows[iRow]).text();
						break;
					case "checkbox":
						var cbv  = ["Yes","No"];
						if($t.p.colModel[iCol].editoptions){
							cbv = $t.p.colModel[iCol].editoptions.value.split(":");
						}
						v = $("#"+iRow+"_"+nm.replace('.',"\\."),$t.rows[iRow]).attr("checked") ? cbv[0] : cbv[1];
						v2=v;
						break;
					case "password":
					case "text":
					case "textarea":
						v = htmlEncode($("#"+iRow+"_"+nm.replace('.',"\\."),$t.rows[iRow]).val());
						v2=v;
						break;
				}
				// The common approach is if nothing changed do not do anything
				if (v2 != $t.p.savedRow[fr].v){
					if ($.isFunction($t.p.beforeSaveCell)) {
						var vv = $t.p.beforeSaveCell($t.rows[iRow].id,nm, v, iRow,iCol);
						if (vv) {v = vv;}
					}				
					var cv = checkValues(v,iCol,$t);
					if(cv[0] === true) {
						var addpost = {};
						if ($.isFunction($t.p.beforeSubmitCell)) {
							addpost = $t.p.beforeSubmitCell($t.rows[iRow].id,nm, v, iRow,iCol);
							if (!addpost) {addpost={};}
						}
						if ($t.p.cellsubmit == 'remote') {
							if ($t.p.cellurl) {
								var postdata = {};
								v = htmlEncode(v);
								v2 = htmlEncode(v2);
								postdata[nm] = v;
								postdata["id"] = $t.rows[iRow].id;
								postdata = $.extend(addpost,postdata);
								$.ajax({
									url: $t.p.cellurl,
									data :postdata,
									type: "POST",
									complete: function (result, stat) {
										if (stat == 'success') {
											if ($.isFunction($t.p.afterSubmitCell)) {
												var ret = $t.p.afterSubmitCell(result,postdata.id,nm,v,iRow,iCol);
												if(ret[0] === true) {
													$(cc).empty();
													$($t).setCell($t.rows[iRow].id, iCol, v2);
													$(cc).addClass("dirty-cell");
													$($t.rows[iRow]).addClass("edited");
													if ($.isFunction($t.p.afterSaveCell)) {
														$t.p.afterSaveCell($t.rows[iRow].id,nm, v, iRow,iCol);
													}
													$t.p.savedRow = [];
												} else {
													info_dialog($.jgrid.errors.errcap,ret[1],$.jgrid.edit.bClose, $t.p.imgpath);
													$($t).restoreCell(iRow,iCol);
												}
											} else {
												$(cc).empty();
												$($t).setCell($t.rows[iRow].id, iCol, v2);
												$(cc).addClass("dirty-cell");
												$($t.rows[iRow]).addClass("edited");
												if ($.isFunction($t.p.afterSaveCell)) {
													$t.p.afterSaveCell($t.rows[iRow].id,nm, v, iRow,iCol);
												}
												$t.p.savedRow = [];
											}
										}
									},
									error:function(res,stat){
										if ($.isFunction($t.p.errorCell)) {
											$t.p.errorCell(res,stat);
											$($t).restoreCell(iRow,iCol);
										} else {
											info_dialog($.jgrid.errors.errcap,res.status+" : "+res.statusText+"<br/>"+stat,$.jgrid.edit.bClose, $t.p.imgpath);
											$($t).restoreCell(iRow,iCol);
										}
									}
								});
							} else {
								try {
									info_dialog($.jgrid.errors.errcap,$.jgrid.errors.nourl,$.jgrid.edit.bClose, $t.p.imgpath);
									$($t).restoreCell(iRow,iCol);
								} catch (e) {}
							}
						}
						if ($t.p.cellsubmit == 'clientArray') {
							v = htmlEncode(v);
							v2 = htmlEncode(v2);
							$(cc).empty();
							$($t).setCell($t.rows[iRow].id,iCol, v2);
							$(cc).addClass("dirty-cell");
							$($t.rows[iRow]).addClass("edited");
							if ($.isFunction($t.p.afterSaveCell)) {
								$t.p.afterSaveCell($t.rows[iRow].id,nm, v, iRow,iCol);
							}
							$t.p.savedRow = [];
						}
					} else {
						try {
							window.setTimeout(function(){info_dialog($.jgrid.errors.errcap,v+" "+cv[1],$.jgrid.edit.bClose, $t.p.imgpath)},100);
							$($t).restoreCell(iRow,iCol);
						} catch (e) {}
					}
				} else {
					$($t).restoreCell(iRow,iCol);
				}
			}
			if ($.browser.opera) {
				$("#"+$t.p.knv).attr("tabindex","-1").focus();
			} else {
				window.setTimeout(function () { $("#"+$t.p.knv).attr("tabindex","-1").focus();},0);
			}
		});
	},
	restoreCell : function(iRow, iCol) {
		return this.each(function(){
			var $t= this, nm, fr;
			if (!$t.grid || $t.p.cellEdit !== true ) {return;}
			if ( $t.p.savedRow.length == 1) {fr = 0;} else {fr=null;}
			if(fr != null) {
				var cc = $("td:eq("+iCol+")",$t.rows[iRow]);
				if($.isFunction($.fn['datepicker'])) {
				try {
					$.datepicker('hide');
				} catch (e) {
					try {
						$.datepicker.hideDatepicker();
					} catch (e) {}
				}
				}
				$(cc).empty();
				$($t).setCell($t.rows[iRow].id, iCol, $t.p.savedRow[fr].v);
				$t.p.savedRow = [];
				
			}
			window.setTimeout(function () { $("#"+$t.p.knv).attr("tabindex","-1").focus();},0);
		});
	},
	nextCell : function (iRow,iCol) {
		return this.each(function (){
			var $t = this, nCol=false, tmp;
			if (!$t.grid || $t.p.cellEdit !== true) {return;}
			// try to find next editable cell
			for (var i=iCol+1; i<$t.p.colModel.length; i++) {
				if ( $t.p.colModel[i].editable ===true) {
					nCol = i; break;
				}
			}
			if(nCol !== false) {
				$($t).saveCell(iRow,iCol);
				$($t).editCell(iRow,nCol,true);
			} else {
				if ($t.p.savedRow.length >0) {
					$($t).saveCell(iRow,iCol);
				}
			}
		});
	},
	prevCell : function (iRow,iCol) {
		return this.each(function (){
			var $t = this, nCol=false, tmp;
			if (!$t.grid || $t.p.cellEdit !== true) {return;}
			// try to find next editable cell
			for (var i=iCol-1; i>=0; i--) {
				if ( $t.p.colModel[i].editable ===true) {
					nCol = i; break;
				}
			}
			if(nCol !== false) {
				$($t).saveCell(iRow,iCol);
				$($t).editCell(iRow,nCol,true);
			} else {
				if ($t.p.savedRow.length >0) {
					$($t).saveCell(iRow,iCol);
				}
			}
		});
	},
	GridNav : function() {
		return this.each(function () {
			var  $t = this;
			if (!$t.grid || $t.p.cellEdit !== true ) {return;}
			// trick to process keydown on non input elements
			$t.p.knv = $("table:first",$t.grid.bDiv).attr("id") + "_kn";
			var selection = $("<span style='width:0px;height:0px;background-color:black;' tabindex='0'><span tabindex='-1' style='width:0px;height:0px;background-color:grey' id='"+$t.p.knv+"'></span></span>");
			$(selection).insertBefore($t.grid.cDiv);
			$("#"+$t.p.knv).focus();
			$("#"+$t.p.knv).keydown(function (e){
				switch (e.keyCode) {
					case 38:
						if ($t.p.iRow-1 >=1 ) {
							scrollGrid($t.p.iRow-1,$t.p.iCol,'vu');
							$($t).editCell($t.p.iRow-1,$t.p.iCol,false);
						}
					break;
					case 40 :
						if ($t.p.iRow+1 <=  $t.rows.length-1) {
							scrollGrid($t.p.iRow+1,$t.p.iCol,'vd');
							$($t).editCell($t.p.iRow+1,$t.p.iCol,false);
						}
					break;
					case 37 :
						if ($t.p.iCol -1 >=  0) {
							var i = findNextVisible($t.p.iCol-1,'lft');
							scrollGrid($t.p.iRow, i,'h');
							$($t).editCell($t.p.iRow, i,false);
						}
					break;
					case 39 :
						if ($t.p.iCol +1 <=  $t.p.colModel.length-1) {
							var i = findNextVisible($t.p.iCol+1,'rgt');
							scrollGrid($t.p.iRow,i,'h');
							$($t).editCell($t.p.iRow,i,false);
						}
					break;
					case 13:
						if (parseInt($t.p.iCol,10)>=0 && parseInt($t.p.iRow,10)>=0) {
							$($t).editCell($t.p.iRow,$t.p.iCol,true);
						}
					break;
				}
				return false;
			});
			function scrollGrid(iR, iC, tp){
				if (tp.substr(0,1)=='v') {
					var ch = $($t.grid.bDiv)[0].clientHeight,
					st = $($t.grid.bDiv)[0].scrollTop,
					nROT = $t.rows[iR].offsetTop+$t.rows[iR].clientHeight,
					pROT = $t.rows[iR].offsetTop;
					if(tp == 'vd') {
						if(nROT >= ch) {
							$($t.grid.bDiv)[0].scrollTop = $($t.grid.bDiv)[0].scrollTop + $t.rows[iR].clientHeight;
						}
					}
					if(tp == 'vu'){
						if (pROT < st) {
							$($t.grid.bDiv)[0].scrollTop = $($t.grid.bDiv)[0].scrollTop - $t.rows[iR].clientHeight;
						}
					}
				}
				if(tp=='h') {
					var cw = $($t.grid.bDiv)[0].clientWidth,
					sl = $($t.grid.bDiv)[0].scrollLeft,
					nCOL = $t.rows[iR].cells[iC].offsetLeft+$t.rows[iR].cells[iC].clientWidth,
					pCOL = $t.rows[iR].cells[iC].offsetLeft;
					if(nCOL >= cw+parseInt(sl)) {
						$($t.grid.bDiv)[0].scrollLeft = $($t.grid.bDiv)[0].scrollLeft + $t.rows[iR].cells[iC].clientWidth;
					} else if (pCOL < sl) {
						$($t.grid.bDiv)[0].scrollLeft = $($t.grid.bDiv)[0].scrollLeft - $t.rows[iR].cells[iC].clientWidth;
					}
				}
			};
			function findNextVisible(iC,act){
				var ind, i;
				if(act == 'lft') {
					ind = iC+1;
					for (i=iC;i>=0;i--){
						if ($t.p.colModel[i].hidden !== true) {
							ind = i;
							break;
						}
					}
				}
				if(act == 'rgt') {
					ind = iC-1;
					for (i=iC; i<$t.p.colModel.length;i++){
						if ($t.p.colModel[i].hidden !== true) {
							ind = i;
							break;
						}						
					}
				}
				return ind;
			};
		});
	},
	getChangedCells : function (mthd) {
		var ret=[];
		if (!mthd) {mthd='all';}
		this.each(function(){
			var $t= this;
			if (!$t.grid || $t.p.cellEdit !== true ) {return;}
			$($t.rows).slice(1).each(function(j){
				var res = {};
				if ($(this).hasClass("edited")) {
					$('td',this).each( function(i) {
						nm = $t.p.colModel[i].name;
						if ( nm !== 'cb' && nm !== 'subgrid') {
							if (mthd=='dirty') {
								if ($(this).hasClass('dirty-cell')) {
									res[nm] = $.htmlDecode($(this).html());
								}
							} else {
								res[nm] = $.htmlDecode($(this).html());
							}
						}
					});
					res["id"] = this.id;
					ret.push(res);
				}
			})
		});
		return ret;
	}
/// end  cell editing
});
})(jQuery);
;(function($){
/**
 * jqGrid extension for SubGrid Data
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.fn.extend({
addSubGrid : function(t,row,pos,rowelem) {
	return this.each(function(){
		var ts = this;
		if (!ts.grid ) {
			return;
		}
		var td, res,_id, pID, nhc, bfsc;
		td = document.createElement("td");
		$(td,t).html("<img src='"+ts.p.imgpath+"plus.gif'/>").addClass("sgcollapsed")
		.click( function(e) {
			if($(this).hasClass("sgcollapsed")) {
				pID = $("table:first",ts.grid.bDiv).attr("id");
				res = $(this).parent();
				var atd= pos==1?'<td></td>':'';
				_id = $(res).attr("id");
				bfsc =true;
				if($.isFunction(ts.p.subGridBeforeExpand)) {
					bfsc = ts.p.subGridBeforeExpand(pID+"_"+_id,_id);
				}
				if(bfsc === false) {return false;}
				nhc = 0;
				$.each(ts.p.colModel,function(i,v){
					if(this.hidden === true) {
						nhc++;
					}
				});
				var subdata = "<tr class='subgrid'>"+atd+"<td><img src='"+ts.p.imgpath+"line3.gif'/></td><td colspan='"+parseInt(ts.p.colNames.length-1-nhc)+"'><div id="+pID+"_"+_id+" class='tablediv'>";
				$(this).parent().after( subdata+ "</div></td></tr>" );
				$(".tablediv",ts).css("width", ts.grid.width-20+"px");
				if( $.isFunction(ts.p.subGridRowExpanded) ) {
					ts.p.subGridRowExpanded(pID+"_"+ _id,_id);
				} else {
					populatesubgrid(res);
				}
				$(this).html("<img src='"+ts.p.imgpath+"minus.gif'/>").removeClass("sgcollapsed").addClass("sgexpanded");
			} else if($(this).hasClass("sgexpanded")) {
				bfsc = true;
				if( $.isFunction(ts.p.subGridRowColapsed)) {
					res = $(this).parent();
					_id = $(res).attr("id");
					bfsc = ts.p.subGridRowColapsed(pID+"_"+_id,_id );
				};
				if(bfsc===false) {return false;}
				$(this).parent().next().remove(".subgrid");
				$(this).html("<img src='"+ts.p.imgpath+"plus.gif'/>").removeClass("sgexpanded").addClass("sgcollapsed");
			}
			return false;
			});
		row.appendChild(td);
		//-------------------------
		var populatesubgrid = function( rd ) {
			var res,sid,dp;
			sid = $(rd).attr("id");
			dp = {id:sid, nd_: (new Date().getTime())};
			if(!ts.p.subGridModel[0]) {
				return false;
			}
			if(ts.p.subGridModel[0].params) {
				for(var j=0; j < ts.p.subGridModel[0].params.length; j++) {
					for(var i=0; i<ts.p.colModel.length; i++) {
						if(ts.p.colModel[i].name == ts.p.subGridModel[0].params[j]) {
							dp[ts.p.colModel[i].name]= $("td:eq("+i+")",rd).text().replace(/\&nbsp\;/ig,'');
						}
					}
				}
			}
			if(!ts.grid.hDiv.loading) {
				ts.grid.hDiv.loading = true;
				$("div.loading",ts.grid.hDiv).fadeIn("fast");
				if(!ts.p.subgridtype) ts.p.subgridtype = ts.p.datatype;
				if($.isFunction(ts.p.subgridtype)) {
					ts.p.subgridtype(dp);
				}
				switch(ts.p.subgridtype) {
					case "xml":
					$.ajax({
						type:ts.p.mtype,
						url: ts.p.subGridUrl,
						dataType:"xml",
						data: dp,
						complete: function(sxml) {
							subGridXml(sxml.responseXML, sid);
						}
					});
					break;
					case "json":
					$.ajax({
						type:ts.p.mtype,
						url: ts.p.subGridUrl,
						dataType:"json",
						data: dp,
						complete: function(JSON) {
							subGridJson(eval("("+JSON.responseText+")"),sid);
						}
					});
					break;
				}
			}
			return false;
		};
		var subGridCell = function(trdiv,cell,pos){
			var tddiv = document.createElement("div");
			tddiv.className = "celldiv";
			$(tddiv).html(cell);
			$(tddiv).width( ts.p.subGridModel[0].width[pos] || 80);
			trdiv.appendChild(tddiv);
		};
		var subGridXml = function(sjxml, sbid){
			var trdiv, tddiv,result = "", i,cur, sgmap, dummy = document.createElement("span");
			trdiv = document.createElement("div");
			trdiv.className="rowdiv";
			for (i = 0; i<ts.p.subGridModel[0].name.length; i++) {
				tddiv = document.createElement("div");
				tddiv.className = "celldivth";
				$(tddiv).html(ts.p.subGridModel[0].name[i]);
				$(tddiv).width( ts.p.subGridModel[0].width[i]);
				trdiv.appendChild(tddiv);
			}
			dummy.appendChild(trdiv);
			if (sjxml){
				sgmap = ts.p.xmlReader.subgrid;
				$(sgmap.root+">"+sgmap.row, sjxml).each( function(){
					trdiv = document.createElement("div");
					trdiv.className="rowdiv";
					if(sgmap.repeatitems === true) {
						$(sgmap.cell,this).each( function(i) {
							subGridCell(trdiv, this.textContent || this.text || '&nbsp;',i);						});
					} else {
						var f = ts.p.subGridModel[0].mapping;
						if (f) {
							for (i=0;i<f.length;i++) {
								subGridCell(trdiv, $(f[i],this).text() || '&nbsp;',i);
							}
						}
					}
					dummy.appendChild(trdiv);
				});
				var pID = $("table:first",ts.grid.bDiv).attr("id")+"_";
				$("#"+pID+sbid).append($(dummy).html());
				sjxml = null;
				ts.grid.hDiv.loading = false;
				$("div.loading",ts.grid.hDiv).fadeOut("fast");
			}
			return false;
		};
		var subGridJson = function(sjxml, sbid){
			var trdiv, tddiv,result = "", i,cur, sgmap,	dummy = document.createElement("span");
			trdiv = document.createElement("div");
			trdiv.className="rowdiv";
			for (i = 0; i<ts.p.subGridModel[0].name.length; i++) {
				tddiv = document.createElement("div");
				tddiv.className = "celldivth";
				$(tddiv).html(ts.p.subGridModel[0].name[i]);
				$(tddiv).width( ts.p.subGridModel[0].width[i]);
				trdiv.appendChild(tddiv);
			}
			dummy.appendChild(trdiv);
			if (sjxml){
				//sjxml = eval("("+sjxml.responseText+")");
				sgmap = ts.p.jsonReader.subgrid;
				for (i=0;i<sjxml[sgmap.root].length;i++) {
					cur = sjxml[sgmap.root][i];
					trdiv = document.createElement("div");
					trdiv.className="rowdiv";
					if(sgmap.repeatitems === true) {
						if(sgmap.cell) { cur=cur[sgmap.cell]; }
						for (var j=0;j<cur.length;j++) {
							subGridCell(trdiv, cur[j] || '&nbsp;',j);
						}
					} else {
						var f = ts.p.subGridModel[0].mapping;
						if(f.length) {
							for (var j=0;j<f.length;j++) {
								subGridCell(trdiv, cur[f[j]] || '&nbsp;',j);
							}
						}
					}
					dummy.appendChild(trdiv);
				}
				var pID = $("table:first",ts.grid.bDiv).attr("id")+"_";
				$("#"+pID+sbid).append($(dummy).html());
				sjxml = null;
				ts.grid.hDiv.loading = false;
				$("div.loading",ts.grid.hDiv).fadeOut("fast");
			}
			return false;
		};
		ts.subGridXml = function(xml,sid) {subGridXml(xml,sid);};
		ts.subGridJson = function(json,sid) {subGridJson(json,sid);};
	});
},
expandSubGridRow : function(rowid) {
	return this.each(function () {
		var $t = this;
		if(!$t.grid && !rowid) {return;}
		if($t.p.subGrid===true) {
			var rc = $(this).getInd($t.rows,rowid,true);
			if(rc) {
				var sgc = $("td.sgcollapsed",rc)[0];
				if(sgc) {
					$(sgc).trigger("click");
				}
			}
		}
	});
},
collapseSubGridRow : function(rowid) {
	return this.each(function () {
		var $t = this;
		if(!$t.grid && !rowid) {return;}
		if($t.p.subGrid===true) {
			var rc = $(this).getInd($t.rows,rowid,true);
			if(rc) {
				var sgc = $("td.sgexpanded",rc)[0];
				if(sgc) {
					$(sgc).trigger("click");
				}
			}
		}
	});
},
toggleSubGridRow : function(rowid) {
	return this.each(function () {
		var $t = this;
		if(!$t.grid && !rowid) {return;}
		if($t.p.subGrid===true) {
			var rc = $(this).getInd($t.rows,rowid,true);
			if(rc) {
				var sgc = $("td.sgcollapsed",rc)[0];
				if(sgc) {
					$(sgc).trigger("click");
				} else {
					sgc = $("td.sgexpanded",rc)[0];
					if(sgc) {
						$(sgc).trigger("click");
					}
				}
			}
		}
	});
}
});
})(jQuery);
;(function($) {
/*
**
 * jqGrid extension - Tree Grid
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
$.fn.extend({
	setTreeNode : function(rd, row){
		return this.each(function(){
			var $t = this;
			if( !$t.grid || !$t.p.treeGrid ) { return; }
			var expCol=0,i=0;
			if(!$t.p.expColInd) {
				for (var key in $t.p.colModel){
					if($t.p.colModel[key].name == $t.p.ExpandColumn) {
						expCol = i;
						$t.p.expColInd = expCol;
						break;
					}
					i++;
				}
				if(!$t.p.expColInd ) {$t.p.expColInd = expCol;}
			} else {
				expCol = $t.p.expColInd;
			}
			var expanded = $t.p.treeReader.expanded_field;
			var isLeaf = $t.p.treeReader.leaf_field;
			var level = $t.p.treeReader.level_field;
			row.level = rd[level];
			
			if($t.p.treeGridModel == 'nested') {
				row.lft = rd[$t.p.treeReader.left_field];
				row.rgt = rd[$t.p.treeReader.right_field];
				if(!rd[isLeaf]) {
				// NS Model
					rd[isLeaf] = (parseInt(row.rgt,10) === parseInt(row.lft,10)+1) ? 'true' : 'false';
				}
			} else {
				row.parent_id = rd[$t.p.treeReader.parent_id_field];
			}
			
			var curExpand = (rd[expanded] && rd[expanded] == "true") ? true : false;
			var curLevel = parseInt(row.level,10);
			var ident,lftpos;
			if($t.p.tree_root_level === 0) {
				ident = curLevel+1;
				lftpos = curLevel;
			} else {
				ident = curLevel;
				lftpos = curLevel -1;
			}
			var twrap = document.createElement("div");
			$(twrap).addClass("tree-wrap").width(ident*18);
			var treeimg = document.createElement("div");
			$(treeimg).css("left",lftpos*18);
			twrap.appendChild(treeimg);

			if(rd[isLeaf] == "true") {
				$(treeimg).addClass("tree-leaf");
				row.isLeaf = true;
			} else {
				if(rd[expanded] == "true") {
					$(treeimg).addClass("tree-minus treeclick");
					row.expanded = true;
				} else {
					$(treeimg).addClass("tree-plus treeclick");
					row.expanded = false;
				}
			}
			if(parseInt(rd[level],10) !== parseInt($t.p.tree_root_level,10)) {                
				if(!$($t).isVisibleNode(row)){ 
					$(row).css("display","none");
				}
			}
			var mhtm = $("td:eq("+expCol+")",row).html();
			var thecell = $("td:eq("+expCol+")",row).html("<span>"+mhtm+"</span>").prepend(twrap);
			$(".treeclick",thecell).click(function(e){
				var target = e.target || e.srcElement;
				var ind =$(target,$t.rows).parents("tr:first")[0].rowIndex;
				if(!$t.rows[ind].isLeaf){
					if($t.rows[ind].expanded){
						$($t).collapseRow($t.rows[ind]);
						$($t).collapseNode($t.rows[ind]);
					} else {
						$($t).expandRow($t.rows[ind]);
						$($t).expandNode($t.rows[ind]);
					}
				}
				//e.stopPropagation();
				return false;
			});
			//if($t.p.ExpandColClick === true) {
			$("span", thecell).css("cursor","pointer").click(function(e){
				var target = e.target || e.srcElement;
				var ind =$(target,$t.rows).parents("tr:first")[0].rowIndex;
				if(!$t.rows[ind].isLeaf){
					if($t.rows[ind].expanded){
						$($t).collapseRow($t.rows[ind]);
						$($t).collapseNode($t.rows[ind]);
					} else {
						$($t).expandRow($t.rows[ind]);
						$($t).expandNode($t.rows[ind]);
					}
				}
				$($t).setSelection($t.rows[ind].id);
				return false;
			});
			//}
		});
	},
	setTreeGrid : function() {
		return this.each(function (){
			var $t = this;
			if(!$t.p.treeGrid) { return; }
			$.extend($t.p,{treedatatype: null});
			if($t.p.treeGridModel == 'nested') {
				$t.p.treeReader = $.extend({
					level_field: "level",
					left_field:"lft",
					right_field: "rgt",
					leaf_field: "isLeaf",
					expanded_field: "expanded"
				},$t.p.treeReader);
			} else
				if($t.p.treeGridModel == 'adjacency') {
				$t.p.treeReader = $.extend({
						level_field: "level",
						parent_id_field: "parent",
						leaf_field: "isLeaf",
						expanded_field: "expanded"
				},$t.p.treeReader );
			}
		});
	},
	expandRow: function (record){
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			var childern = $($t).getNodeChildren(record);
			//if ($($t).isVisibleNode(record)) {
			$(childern).each(function(i){
				$(this).css("display","");
				if(this.expanded) {
					$($t).expandRow(this);
				}
			});
			//}
		});
	},
	collapseRow : function (record) {
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			var childern = $($t).getNodeChildren(record);
			$(childern).each(function(i){
				$(this).css("display","none");
				$($t).collapseRow(this);
			});
		});
	},
	// NS ,adjacency models
	getRootNodes : function() {
		var result = [];
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			switch ($t.p.treeGridModel) {
				case 'nested' :
					var level = $t.p.treeReader.level_field;
					$($t.rows).each(function(i){
						if(parseInt(this[level],10) === parseInt($t.p.tree_root_level,10)) {
							result.push(this);
						}
					});
					break;
				case 'adjacency' :
					$($t.rows).each(function(i){
						if(this.parent_id.toLowerCase() == "null") {
							result.push(this);
						}
					});
					break;
			}
		});
		return result;
	},
	getNodeDepth : function(rc) {
		var ret = null;
		this.each(function(){
			var $t = this;
			if(!this.grid || !this.p.treeGrid) { return; }
			switch ($t.p.treeGridModel) {
				case 'nested' :
					ret = parseInt(rc.level,10) - parseInt(this.p.tree_root_level,10);
					break;
				case 'adjacency' :
					ret = $($t).getNodeAncestors(rc);
					break;
			}
		});
		return ret;
	},
	getNodeParent : function(rc) {
		var result = null;
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			switch ($t.p.treeGridModel) {
				case 'nested' :
					var lft = parseInt(rc.lft,10), rgt = parseInt(rc.rgt,10), level = parseInt(rc.level,10);
					$(this.rows).each(function(){
						if(parseInt(this.level,10) === level-1 && parseInt(this.lft) < lft && parseInt(this.rgt) > rgt) {
							result = this;
							return false;
						}
					});
					break;
				case 'adjacency' :
					$(this.rows).each(function(){
						if(this.id === rc.parent_id ) {
							result = this;
							return false;
						}
					});
					break;
			}
		});
		return result;
	},
	getNodeChildren : function(rc) {
		var result = [];
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			switch ($t.p.treeGridModel) {
				case 'nested' :
					var lft = parseInt(rc.lft,10), rgt = parseInt(rc.rgt,10), level = parseInt(rc.level,10);
					var ind = rc.rowIndex;
					$(this.rows).slice(1).each(function(i){
						if(parseInt(this.level,10) === level+1 && parseInt(this.lft,10) > lft && parseInt(this.rgt,10) < rgt) {
							result.push(this);
						}
					});
					break;
				case 'adjacency' :
					$(this.rows).slice(1).each(function(i){
						if(this.parent_id == rc.id) {
							result.push(this);
						}
					});
					break;
			}
		});
		return result;
	},
	// End NS, adjacency Model
	getNodeAncestors : function(rc) {
		var ancestors = [];
		this.each(function(){
			if(!this.grid || !this.p.treeGrid) { return; }
			var parent = $(this).getNodeParent(rc);
			while (parent) {
				ancestors.push(parent);
				parent = $(this).getNodeParent(parent);	
			}
		});
		return ancestors;
	},
	isVisibleNode : function(rc) {
		var result = true;
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			var ancestors = $($t).getNodeAncestors(rc);
			$(ancestors).each(function(){
				result = result && this.expanded;
				if(!result) {return false;}
			});
		});
		return result;
	},
	isNodeLoaded : function(rc) {
		var result;
		this.each(function(){
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			if(rc.loaded !== undefined) {
				result = rc.loaded;
			} else if( rc.isLeaf || $($t).getNodeChildren(rc).length > 0){
				result = true;
			} else {
				result = false;
			}
		});
		return result;
	},
	expandNode : function(rc) {
		return this.each(function(){
			if(!this.grid || !this.p.treeGrid) { return; }
			if(!rc.expanded) {
				if( $(this).isNodeLoaded(rc) ) {
					rc.expanded = true;
					$("div.treeclick",rc).removeClass("tree-plus").addClass("tree-minus");
				} else {
					rc.expanded = true;
					$("div.treeclick",rc).removeClass("tree-plus").addClass("tree-minus");
					this.p.treeANode = rc.rowIndex;
					this.p.datatype = this.p.treedatatype;
					if(this.p.treeGridModel == 'nested') {
						$(this).setGridParam({postData:{nodeid:rc.id,n_left:rc.lft,n_right:rc.rgt,n_level:rc.level}});
					} else {
						$(this).setGridParam({postData:{nodeid:rc.id,parentid:rc.parent_id,n_level:rc.level}});
					}
					$(this).trigger("reloadGrid");
					if(this.p.treeGridModel == 'nested') {
						$(this).setGridParam({postData:{nodeid:'',n_left:'',n_right:'',n_level:''}});
					} else {
						$(this).setGridParam({postData:{nodeid:'',parentid:'',n_level:''}});
					}
				}
			}
		});
	},
	collapseNode : function(rc) {
		return this.each(function(){
			if(!this.grid || !this.p.treeGrid) { return; }
			if(rc.expanded) {
				rc.expanded = false;
				$("div.treeclick",rc).removeClass("tree-minus").addClass("tree-plus");
			}
		});
	},
	SortTree : function( newDir) {
		return this.each(function(){
			if(!this.grid || !this.p.treeGrid) { return; }
			var i, len,
			rec, records = [],
			roots = $(this).getRootNodes();
			// Sorting roots
			roots.sort(function(a, b) {
				if (a.sortKey < b.sortKey) {return -newDir;}
				if (a.sortKey > b.sortKey) {return newDir;}
				return 0;
			});
			// Sorting children
			for (i = 0, len = roots.length; i < len; i++) {
				rec = roots[i];
				records.push(rec);
				$(this).collectChildrenSortTree(records, rec, newDir);
			}
			var $t = this;
			$.each(records, function(index, row) {
				$('tbody',$t.grid.bDiv).append(row);
				row.sortKey = null;
			});
		});
	},
	collectChildrenSortTree : function(records, rec, newDir) {
		return this.each(function(){
			if(!this.grid || !this.p.treeGrid) { return; }
			var i, len,
			child, 
			children = $(this).getNodeChildren(rec);
			children.sort(function(a, b) {
				if (a.sortKey < b.sortKey) {return -newDir;}
				if (a.sortKey > b.sortKey) {return newDir;}
				return 0;
			});
			for (i = 0, len = children.length; i < len; i++) {
				child = children[i];
				records.push(child);
				$(this).collectChildrenSortTree(records, child,newDir); 
			}
		});
	},
	// experimental 
	setTreeRow : function(rowid, data) {
		var nm, success=false;
		this.each(function(){
			var t = this;
			if(!t.grid || !t.p.treeGrid) { return; }
			success = $(t).setRowData(rowid,data);
		});
		return success;
	},
	delTreeNode : function (rowid) {
		return this.each(function () {
			var $t = this;
			if(!$t.grid || !$t.p.treeGrid) { return; }
			var rc = $($t).getInd($t.rows,rowid,true);
			if (rc) {
				var dr = $($t).getNodeChildren(rc);
				if(dr.length>0){
					for (var i=0;i<dr.length;i++){
						$($t).delRowData(dr[i].id);
					}
				}
				$($t).delRowData(rc.id);
			}
		});
	}
});
})(jQuery);;(function($){
/**
 * jqGrid extension for custom methods
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
$.fn.extend({
	getColProp : function(colname){
		var ret ={}, $t = this[0];
		if ( !$t.grid ) { return; }
		var cM = $t.p.colModel;
		for ( var i =0;i<cM.length;i++ ) {
			if ( cM[i].name == colname ) {
				ret = cM[i];
				break;
			}
		};
		return ret;
	},
	setColProp : function(colname, obj){
		//do not set width will not work
		return this.each(function(){
			if ( this.grid ) {
				if ( obj ) {
					var cM = this.p.colModel;
					for ( var i =0;i<cM.length;i++ ) {
						if ( cM[i].name == colname ) {
							$.extend(this.p.colModel[i],obj);
							break;
						}
					}
				}
			}
		});
	},
	sortGrid : function(colname,reload){
		return this.each(function(){
			var $t=this,idx=-1;
			if ( !$t.grid ) { return;}
			if ( !colname ) { colname = $t.p.sortname; }
			for ( var i=0;i<$t.p.colModel.length;i++ ) {
				if ( $t.p.colModel[i].index == colname || $t.p.colModel[i].name==colname ) {
					idx = i;
					break;
				}
			}
			if ( idx!=-1 ){
				var sort = $t.p.colModel[idx].sortable;
				if ( typeof sort !== 'boolean' ) { sort =  true; }
				if ( typeof reload !=='boolean' ) { reload = false; }
				if ( sort ) { $t.sortData(colname, idx, reload); }
			}
		});
	},
	GridDestroy : function () {
		return this.each(function(){
			if ( this.grid ) { 
				if ( this.p.pager ) {
					$(this.p.pager).remove();
				}
				var gid = this.id;
				$("#lui_"+gid).remove();
				try {
					$("#editmod"+gid).remove();
					$("#delmod"+gid).remove();
					$("#srchmod"+gid).remove();
				} catch (_) {}
				$(this.grid.bDiv).remove();
				$(this.grid.hDiv).remove();
				$(this.grid.cDiv).remove();
				if(this.p.toolbar[0]) { $(this.grid.uDiv).remove(); }
				this.p = null;
				this.grid =null;
			}
		});
	},
	GridUnload : function(){
		return this.each(function(){
			if ( !this.grid ) {return;}
			var defgrid = {id: $(this).attr('id'),cl: $(this).attr('class')};
			if (this.p.pager) {
				$(this.p.pager).empty();
			}
			var newtable = document.createElement('table');
			$(newtable).attr({id:defgrid['id']});
			newtable.className = defgrid['cl'];
			var gid = this.id;
			$("#lui_"+gid).remove();
			try {
				$("#editmod"+gid).remove();
				$("#delmod"+gid).remove();
				$("#srchmod"+gid).remove();
			} catch (_) {}
			if(this.p.toolbar[0]) { $(this.grid.uDiv).remove(); }
			$(this.grid.cDiv).remove();
			$(this.grid.bDiv).remove();
			$(this.grid.hDiv).before(newtable).remove();
			// here code to remove modals of form editing
			this.p = null;
			this.grid =null;
		});
	},
	filterGrid : function(gridid,p){
		p = $.extend({
			gridModel : false,
			gridNames : false,
			gridToolbar : false,
			filterModel: [], // label/name/stype/defval/surl/sopt
			formtype : "horizontal", // horizontal/vertical
			autosearch: true, // if set to false a serch button should be enabled.
			formclass: "filterform",
			tableclass: "filtertable",
			buttonclass: "filterbutton",
			searchButton: "Search",
			clearButton: "Clear",
			enableSearch : false,
			enableClear: false,
			beforeSearch: null,
			afterSearch: null,
			beforeClear: null,
			afterClear: null,
			url : '',
			marksearched: true
		},p  || {});
		return this.each(function(){
			var self = this;
			this.p = p;
			if(this.p.filterModel.length == 0 && this.p.gridModel===false) { alert("No filter is set"); return;}
			if( !gridid) {alert("No target grid is set!"); return;}
			this.p.gridid = gridid.indexOf("#") != -1 ? gridid : "#"+gridid;
			var gcolMod = $(this.p.gridid).getGridParam('colModel');
			if(gcolMod) {
				if( this.p.gridModel === true) {
					var thegrid = $(this.p.gridid)[0];
					var sh;
					// we should use the options search, edittype, editoptions
					// additionally surl and defval can be added in grid colModel
					$.each(gcolMod, function (i,n) {
						var tmpFil = [];
						this.search = this.search === false ? false : true;
						if(this.editrules && this.editrules.searchhidden === true) {
							sh = true;
						} else {
							if(this.hidden === true ) {
								sh = false;
							} else {
								sh = true;
							}
						}
						if( this.search === true && sh === true) {
							if(self.p.gridNames===true) {
								tmpFil.label = thegrid.p.colNames[i];
							} else {
								tmpFil.label = '';
							}
							tmpFil.name = this.name;
							tmpFil.index = this.index || this.name;
							// we support only text and selects, so all other to text
							tmpFil.stype = this.edittype || 'text';
							if(tmpFil.stype != 'select' || tmpFil.stype != 'select') {
								tmpFil.stype = 'text';
							}
							tmpFil.defval = this.defval || '';
							tmpFil.surl = this.surl || '';
							tmpFil.sopt = this.editoptions || {};
							tmpFil.width = this.width;
							self.p.filterModel.push(tmpFil);
						}
					});
				} else {
					$.each(self.p.filterModel,function(i,n) {
						for(var j=0;j<gcolMod.length;j++) {
							if(this.name == gcolMod[j].name) {
								this.index = gcolMod[j].index || this.name;
								break;
							}
						}
						if(!this.index) {
							this.index = this.name;
						}
					});
				}
			} else {
				alert("Could not get grid colModel"); return;
			}
			var triggerSearch = function() {
				var sdata={}, j=0, v;
				var gr = $(self.p.gridid)[0];
				if($.isFunction(self.p.beforeSearch)){self.p.beforeSearch();}
				$.each(self.p.filterModel,function(i,n){
					switch (this.stype) {
						case 'select' :
							v = $("select[name="+this.name+"]",self).val();
							if(v) {
								sdata[this.index] = v;
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).addClass("dirty-cell");
								}
								j++;
							} else {
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).removeClass("dirty-cell");
								}
								// remove from postdata
								try {
									delete gr.p.postData[this.index];
								} catch(e) {}
							}
							break;
						default:
							v = $("input[name="+this.name+"]",self).val();
							if(v) {
								sdata[this.index] = v;
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).addClass("dirty-cell");
								}
								j++;
							} else {
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).removeClass("dirty-cell");
								}
								// remove from postdata
								try {
									delete gr.p.postData[this.index];
								} catch (e) {}
							}
					}
				});
				var sd =  j>0 ? true : false;
				gr.p.postData = $.extend(gr.p.postData,sdata);
				var saveurl;
				if(self.p.url) {
					saveurl = $(gr).getGridParam('url');
					$(gr).setGridParam({url:self.p.url});
				}
				$(gr).setGridParam({search:sd,page:1}).trigger("reloadGrid");
				if(saveurl) {$(gr).setGridParam({url:saveurl});}
				if($.isFunction(self.p.afterSearch)){self.p.afterSearch();}
			};
			var clearSearch = function(){
				var sdata={}, v, j=0;
				var gr = $(self.p.gridid)[0];
				if($.isFunction(self.p.beforeClear)){self.p.beforeClear();}
				$.each(self.p.filterModel,function(i,n){
					v = (this.defval) ? this.defval : "";
					if(!this.stype){this.stype=='text';}
					switch (this.stype) {
						case 'select' :
							if(v) {
								var v1;
								$("select[name="+this.name+"] option",self).each(function (){
									if ($(this).text() == v) {
										this.selected = true;
										v1 = $(this).val();
										return false;
									}
								});
								// post the key and not the text
								sdata[this.index] = v1 || "";
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).addClass("dirty-cell");
								}
								j++;
							} else {
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).removeClass("dirty-cell");
								}
								// remove from postdata
								try {
									delete gr.p.postData[this.index];
								} catch(e) {}
							}
							break;
						case 'text':
							$("input[name="+this.name+"]",self).val(v);
							if(v) {
								sdata[this.index] = v;
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).addClass("dirty-cell");
								}
								j++;
							} else {
								if(self.p.marksearched){
									$("#jqgh_"+this.name,gr.grid.hDiv).removeClass("dirty-cell");
								}
								// remove from postdata
								try {
									delete gr.p.postData[this.index];
								} catch(e) {}
							}
					}
				});
				var sd =  j>0 ? true : false;
				gr.p.postData = $.extend(gr.p.postData,sdata);
				var saveurl;
				if(self.p.url) {
					saveurl = $(gr).getGridParam('url');
					$(gr).setGridParam({url:self.p.url});
				}
				$(gr).setGridParam({search:sd,page:1}).trigger("reloadGrid");
				if(saveurl) {$(gr).setGridParam({url:saveurl});}
				if($.isFunction(self.p.afterClear)){self.p.afterClear();}
			};
			var formFill = function(){
				var tr = document.createElement("tr");
				var tr1, sb, cb,tl,td, td1;
				if(self.p.formtype=='horizontal'){
					$(tbl).append(tr);
				}
				$.each(self.p.filterModel,function(i,n){
					tl = document.createElement("td");
					$(tl).append("<label for='"+this.name+"'>"+this.label+"</label>");
					td = document.createElement("td");
					var $t=this;
					if(!this.stype) { this.stype='text';}
					switch (this.stype)
					{
					case "select":
						if(this.surl) {
							// data returned should have already constructed html select
							$(td).load(this.surl,function(){
								if($t.defval) $("select",this).val($t.defval);
								$("select",this).attr({name:$t.name, id: "sg_"+$t.name});
								if($t.sopt) $("select",this).attr($t.sopt);
								if(self.p.gridToolbar===true && $t.width) {
									$("select",this).width($t.width);
								}
								if(self.p.autosearch===true){
									$("select",this).change(function(e){
										triggerSearch();
										return false;
									});
								}
							});
						} else {
							// sopt to construct the values
							if($t.sopt.value) {
								var so = $t.sopt.value.split(";"), sv, ov;
								var elem = document.createElement("select");
								$(elem).attr({name:$t.name, id: "sg_"+$t.name}).attr($t.sopt);
								for(var k=0; k<so.length;k++){
									sv = so[k].split(":");
									ov = document.createElement("option");
									ov.value = sv[0]; ov.innerHTML = sv[1];
									if (sv[1]==$t.defval) ov.selected ="selected";
									elem.appendChild(ov);
								}
								if(self.p.gridToolbar===true && $t.width) {
									$(elem).width($t.width);
								}
								$(td).append(elem);
								if(self.p.autosearch===true){
									$(elem).change(function(e){
										triggerSearch();
										return false;
									});
								}
							}
						}
						break;
					case 'text':
						var df = this.defval ? this.defval: "";
						$(td).append("<input type='text' name='"+this.name+"' id='sg_"+this.name+"' value='"+df+"'/>");
						if($t.sopt) $("input",td).attr($t.sopt);
						if(self.p.gridToolbar===true && $t.width) {
							if($.browser.msie) {
								$("input",td).width($t.width-4);
							} else {
								$("input",td).width($t.width-2);
							}
						}
						if(self.p.autosearch===true){
							$("input",td).keypress(function(e){
								var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
								if(key == 13){
									triggerSearch();
									return false;
								}
								return this;
							});
						}
						break;
					}
					if(self.p.formtype=='horizontal'){
						if(self.p.grodToolbar===true && self.p.gridNames===false) {
							$(tr).append(td);
						} else {
							$(tr).append(tl).append(td);
						}
						$(tr).append(td);
					} else {
						tr1 = document.createElement("tr");
						$(tr1).append(tl).append(td);
						$(tbl).append(tr1);
					}
				});
				td = document.createElement("td");
				if(self.p.enableSearch === true){
					sb = "<input type='button' id='sButton' class='"+self.p.buttonclass+"' value='"+self.p.searchButton+"'/>";
					$(td).append(sb);
					$("input#sButton",td).click(function(){
						triggerSearch();
						return false;
					});
				}
				if(self.p.enableClear === true) {
					cb = "<input type='button' id='cButton' class='"+self.p.buttonclass+"' value='"+self.p.clearButton+"'/>";
					$(td).append(cb);
					$("input#cButton",td).click(function(){
						clearSearch();
						return false;
					});
				}
				if(self.p.enableClear === true || self.p.enableSearch === true) {
					if(self.p.formtype=='horizontal') {
						$(tr).append(td);
					} else {
						tr1 = document.createElement("tr");
						$(tr1).append("<td>&nbsp;</td>").append(td);
						$(tbl).append(tr1);
					}
				}
			};
			var frm = $("<form name='SearchForm' style=display:inline;' class='"+this.p.formclass+"'></form>");
			var tbl =$("<table class='"+this.p.tableclass+"' cellspacing='0' cellpading='0' border='0'><tbody></tbody></table>");
			$(frm).append(tbl);
			formFill();
			$(this).append(frm);
			this.triggerSearch = function () {triggerSearch();};
			this.clearSearch = function () {clearSearch();};
		});
	}
});
})(jQuery);;(function($){
/**
 * jqGrid extension
 * Paul Tiseo ptiseo@wasteconsultants.com
 * 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
$.fn.extend({
	getPostData : function(){
		var $t = this[0];
		if(!$t.grid) { return; }
		return $t.p.postData;
	},
	setPostData : function( newdata ) {
		var $t = this[0];
		if(!$t.grid) { return; }
		// check if newdata is correct type
		if ( typeof(newdata) === 'object' ) {
			$t.p.postData = newdata;
		}
		else {
			alert("Error: cannot add a non-object postData value. postData unchanged.");
		}
	},
	appendPostData : function( newdata ) { 
		var $t = this[0];
		if(!$t.grid) { return; }
		// check if newdata is correct type
		if ( typeof(newdata) === 'object' ) {
			$.extend($t.p.postData, newdata);
		}
		else {
			alert("Error: cannot append a non-object postData value. postData unchanged.");
		}
	},
	setPostDataItem : function( key, val ) {
		var $t = this[0];
		if(!$t.grid) { return; }
		$t.p.postData[key] = val;
	},
	getPostDataItem : function( key ) {
		var $t = this[0];
		if(!$t.grid) { return; }
		return $t.p.postData[key];
	},
	removePostDataItem : function( key ) {
		var $t = this[0];
		if(!$t.grid) { return; }
		delete $t.p.postData[key];
	},
	getUserData : function(){
		var $t = this[0];
		if(!$t.grid) { return; }
		return $t.p.userData;
	},
	getUserDataItem : function( key ) {
		var $t = this[0];
		if(!$t.grid) { return; }
		return $t.p.userData[key];
	}
});
})(jQuery);/*
 Transform a table to a jqGrid.
 Peter Romianowski <peter.romianowski@optivo.de> 
 If the first column of the table contains checkboxes or
 radiobuttons then the jqGrid is made selectable.
*/
// Addition - selector can be a class or id
function tableToGrid(selector) {
$(selector).each(function() {
	if(this.grid) {return;} //Adedd from Tony Tomov
	// This is a small "hack" to make the width of the jqGrid 100%
	$(this).width("99%");
	var w = $(this).width();

	// Text whether we have single or multi select
	var inputCheckbox = $('input[type=checkbox]:first', $(this));
	var inputRadio = $('input[type=radio]:first', $(this));
	var selectMultiple = inputCheckbox.length > 0;
	var selectSingle = !selectMultiple && inputRadio.length > 0;
	var selectable = selectMultiple || selectSingle;
	var inputName = inputCheckbox.attr("name") || inputRadio.attr("name");

	// Build up the columnModel and the data
	var colModel = [];
	var colNames = [];
	$('th', $(this)).each(function() {
		if (colModel.length == 0 && selectable) {
			colModel.push({
				name: '__selection__',
				index: '__selection__',
				width: 0,
				hidden: true
			});
			colNames.push('__selection__');
		} else {
			colModel.push({
				name: $(this).html(),
				index: $(this).html(),
				width: $(this).width() || 150
			});
			colNames.push($(this).html());
		}
	});
	var data = [];
	var rowIds = [];
	var rowChecked = [];
	$('tbody > tr', $(this)).each(function() {
		var row = {};
		var rowPos = 0;
		data.push(row);
		$('td', $(this)).each(function() {
			if (rowPos == 0 && selectable) {
				var input = $('input', $(this));
				var rowId = input.attr("value");
				rowIds.push(rowId || data.length);
				if (input.attr("checked")) {
					rowChecked.push(rowId);
				}
				row[colModel[rowPos].name] = input.attr("value");
			} else {
				row[colModel[rowPos].name] = $(this).html();
			}
			rowPos++;
		});
	});

	// Clear the original HTML table
	$(this).empty();

	// Mark it as jqGrid
	$(this).addClass("scroll");

	$(this).jqGrid({
		datatype: "local",
		width: w,
		colNames: colNames,
		colModel: colModel,
		multiselect: selectMultiple
		//inputName: inputName,
		//inputValueCol: imputName != null ? "__selection__" : null
	});

	// Add data
	for (var a = 0; a < data.length; a++) {
		var id = null;
		if (rowIds.length > 0) {
			id = rowIds[a];
			if (id && id.replace) {
				// We have to do this since the value of a checkbox
				// or radio button can be anything 
				id = encodeURIComponent(id).replace(/[.\-%]/g, "_");
			}
		}
		if (id == null) {
			id = a + 1;
		}
		$(this).addRowData(id, data[a]);
	}

	// Set the selection
	for (var a = 0; a < rowChecked.length; a++) {
		$(this).setSelection(rowChecked[a]);
	}
});
};
;(function($){
/**
 * jqGrid extension for manipulating columns properties
 * Piotr Roznicki roznicki@o2.pl
 * http://www.roznicki.prv.pl
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/
$.fn.extend({
	setColumns : function(p) {
		p = $.extend({
			top : 0,
			left: 0,
			width: 200,
			height: 195,
			modal: false,
			drag: true,
			closeicon: 'ico-close.gif',
			beforeShowForm: null,
			afterShowForm: null,
			afterSubmitForm: null
		}, $.jgrid.col, p ||{});
		return this.each(function(){
			var $t = this;
			if (!$t.grid ) { return; }
			var onBeforeShow = typeof p.beforeShowForm === 'function' ? true: false;
			var onAfterShow = typeof p.afterShowForm === 'function' ? true: false;
			var onAfterSubmit = typeof p.afterSubmitForm === 'function' ? true: false;			
			if(!p.imgpath) { p.imgpath= $t.p.imgpath; } // Added From Tony Tomov
			var gID = $("table:first",$t.grid.bDiv).attr("id");
			var IDs = {themodal:'colmod'+gID,modalhead:'colhd'+gID,modalcontent:'colcnt'+gID};
			var dtbl = "ColTbl_"+gID;
			if ( $("#"+IDs.themodal).html() != null ) {
				if(onBeforeShow) { p.beforeShowForm($("#"+dtbl)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if(onAfterShow) { p.afterShowForm($("#"+dtbl)); }
			} else {
				var tbl =$("<table id='"+dtbl+"' class='ColTable'><tbody></tbody></table>");
				for(i=0;i<this.p.colNames.length;i++){
					if(!$t.p.colModel[i].hidedlg) { // added from T. Tomov
						$(tbl).append("<tr><td ><input type='checkbox' id='col_" + this.p.colModel[i].name + "' class='cbox' value='T' " + 
						((this.p.colModel[i].hidden==undefined)?"checked":"") + "/>" +  "<label for='col_" + this.p.colModel[i].name + "'>" + this.p.colNames[i] + "(" + this.p.colModel[i].name + ")</label></td></tr>");
					}
				}
				var bS  ="<input id='dData' type='button' value='"+p.bSubmit+"'/>";
				var bC  ="<input id='eData' type='button' value='"+p.bCancel+"'/>";
				$(tbl).append("<tr><td class='ColButton'>"+bS+"&nbsp;"+bC+"</td></tr>");
				createModal(IDs,tbl,p,$t.grid.hDiv,$t.grid.hDiv);
				if( p.drag) { DnRModal("#"+IDs.themodal,"#"+IDs.modalhead+" td.modaltext"); }
				$("#dData","#"+dtbl).click(function(e){
					for(i=0;i<$t.p.colModel.length;i++){
						if(!$t.p.colModel[i].hidedlg) { // added from T. Tomov
							if($("#col_" + $t.p.colModel[i].name).attr("checked")) {
								$($t).showCol($t.p.colModel[i].name);
								$("#col_" + $t.p.colModel[i].name).attr("defaultChecked",true); // Added from T. Tomov IE BUG
							} else {
								$($t).hideCol($t.p.colModel[i].name);
								$("#col_" + $t.p.colModel[i].name).attr("defaultChecked",""); // Added from T. Tomov IE BUG
							}
						}
					}
					$("#"+IDs.themodal).jqmHide();
					if (onAfterSubmit) { p.afterSubmitForm($("#"+dtbl)); }
					return false;
				});
				$("#eData", "#"+dtbl).click(function(e){
					$("#"+IDs.themodal).jqmHide();
					return false;
				});
				if(onBeforeShow) { p.beforeShowForm($("#"+dtbl)); }
				viewModal("#"+IDs.themodal,{modal:p.modal});
				if(onAfterShow) { p.afterShowForm($("#"+dtbl)); }
			}
		});
	}
});
})(jQuery);;(function($){
/*
 * jqGrid extension for constructing Grid Data from external file
 * Tony Tomov tony@trirand.com
 * http://trirand.com/blog/ 
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
**/ 
    $.fn.extend({
        jqGridImport : function(o) {
            o = $.extend({
                imptype : "xml", // xml, json, xmlstring, jsonstring
                impstring: "",
                impurl: "",
                mtype: "GET",
                impData : {},
                xmlGrid :{
                    config : "roots>grid",
                    data: "roots>rows"
                },
                jsonGrid :{
                    config : "grid",
                    data: "data"
                }
            }, o || {});
            return this.each(function(){
                var $t = this;
                var XmlConvert = function (xml,o) {
                    var cnfg = $(o.xmlGrid.config,xml)[0];
                    var xmldata = $(o.xmlGrid.data,xml)[0];
                    if(xmlJsonClass.xml2json && JSON.parse) {
                        var jstr = xmlJsonClass.xml2json(cnfg," ");
                        var jstr = JSON.parse(jstr);
                        for(var key in jstr) { var jstr1=jstr[key];}
                        if(xmldata) {
                        // save the datatype
                            var svdatatype = jstr.grid.datatype;
                            jstr.grid.datatype = 'xmlstring';
                            jstr.grid.datastr = xml;
                            $($t).jqGrid( jstr1 ).setGridParam({datatype:svdatatype});
                        } else {
                            $($t).jqGrid( jstr1 );
                        }
                        jstr = null;jstr1=null;
                    } else {
                        alert("xml2json or json.parse are not present");
                    }
                };
                var JsonConvert = function (jsonstr,o){
                    if (jsonstr && typeof jsonstr == 'string' && JSON.parse) {
                        var json = JSON.parse(jsonstr);
                        var gprm = json[o.jsonGrid.config];
                        var jdata = json[o.jsonGrid.data];
                        if(jdata) {
                            var svdatatype = gprm.datatype;
                            gprm.datatype = 'jsonstring';
                            gprm.datastr = jdata;
                            $($t).jqGrid( gprm ).setGridParam({datatype:svdatatype});
                        } else {
                            $($t).jqGrid( gprm );
                        }
                    }
                };
                switch (o.imptype){
                    case 'xml':
                        $.ajax({
                            url:o.impurl,
                            type:o.mtype,
                            data: o.impData,
                            dataType:"xml",
                            complete: function(xml,stat) {
                                if(stat == 'success') {
                                    XmlConvert(xml.responseXML,o);
                                    xml=null;
                                }
                            }
                        });
                        break;
                    case 'xmlstring' :
                        // we need to make just the conversion and use the same code as xml
                        if(o.impstring && typeof o.impstring == 'string') {
                            var xmld = xmlJsonClass.parseXml(o.impstring);
                            if(xmld) {
                                XmlConvert(xmld,o);
                                xmld = null;
                            }
                        }
                        break;
                    case 'json':
                        $.ajax({
                            url:o.impurl,
                            type:o.mtype,
                            data: o.impData,
                            dataType:"json",
                            complete: function(json,stat) {
                                if(stat == 'success') {
                                    JsonConvert(json.responseText,o );
                                    json=null;
                                }
                            }
                        });
                        break;
                    case 'jsonstring' :
                        if(o.impstring && typeof o.impstring == 'string') {
                            JsonConvert(o.impstring,o );
                        }
                        break;
                }
            });
        },
        jqGridExport : function(o) {
            o = $.extend({
                exptype : "xmlstring"
            }, o || {});
            var ret = null;
            this.each(function () {
                if(!this.grid) { return;}
                var gprm = $(this).getGridParam();
                switch (o.exptype) {
                    case 'xmlstring' :
                        ret = xmlJsonClass.json2xml(gprm," ");
                        break;
                    case 'jsonstring' :
                        ret = JSON.stringify(gprm);
                        break;
                }
            });
            return ret;
        }
    });
})(jQuery);/*
**
 * formatter for values but most of the values if for jqGrid
 * Some of this was inspired and based on how YUI does the table datagrid but in jQuery fashion
 * we are trying to keep it as light as possible
 * Joshua Burnett josh@9ci.com	
 * http://www.greenbill.com
 *
 * Changes from Tony Tomov tony@trirand.com
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * 
**/

;(function($) {
	$.fmatter = {};
	//opts can be id:row id for the row, rowdata:the data for the row, colmodel:the column model for this column
	//example {id:1234,}
	$.fn.fmatter = function(formatType, cellval, opts, act) {
		//debug(this);
		//debug(cellval);
		// build main options before element iteration
		opts = $.extend({}, $.jgrid.formatter, opts);
		return this.each(function() {
			//debug("in the each");
			$this = $(this);
			//for the metaplugin if it exists
			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
			//debug("firing formatter");
			fireFormatter($this,formatType,cellval, opts, act); 
		});
	};
	$.fmatter.util = {
		// Taken from YAHOO utils
		NumberFormat : function(nData,opts) {
			if(!isNumber(nData)) {
				nData *= 1;
			}
			if(isNumber(nData)) {
		        var bNegative = (nData < 0);
				var sOutput = nData + "";
				var sDecimalSeparator = (opts.decimalSeparator) ? opts.decimalSeparator : ".";
				var nDotIndex;
				if(isNumber(opts.decimalPlaces)) {
					// Round to the correct decimal place
					var nDecimalPlaces = opts.decimalPlaces;
					var nDecimal = Math.pow(10, nDecimalPlaces);
					sOutput = Math.round(nData*nDecimal)/nDecimal + "";
					nDotIndex = sOutput.lastIndexOf(".");
					if(nDecimalPlaces > 0) {
                    // Add the decimal separator
						if(nDotIndex < 0) {
							sOutput += sDecimalSeparator;
							nDotIndex = sOutput.length-1;
						}
						// Replace the "."
						else if(sDecimalSeparator !== "."){
							sOutput = sOutput.replace(".",sDecimalSeparator);
						}
                    // Add missing zeros
						while((sOutput.length - 1 - nDotIndex) < nDecimalPlaces) {
						    sOutput += "0";
						}
	                }
	            }
	            if(opts.thousandsSeparator) {
	                var sThousandsSeparator = opts.thousandsSeparator;
	                nDotIndex = sOutput.lastIndexOf(sDecimalSeparator);
	                nDotIndex = (nDotIndex > -1) ? nDotIndex : sOutput.length;
	                var sNewOutput = sOutput.substring(nDotIndex);
	                var nCount = -1;
	                for (var i=nDotIndex; i>0; i--) {
	                    nCount++;
	                    if ((nCount%3 === 0) && (i !== nDotIndex) && (!bNegative || (i > 1))) {
	                        sNewOutput = sThousandsSeparator + sNewOutput;
	                    }
	                    sNewOutput = sOutput.charAt(i-1) + sNewOutput;
	                }
	                sOutput = sNewOutput;
	            }
	            // Prepend prefix
	            sOutput = (opts.prefix) ? opts.prefix + sOutput : sOutput;
	            // Append suffix
	            sOutput = (opts.suffix) ? sOutput + opts.suffix : sOutput;
	            return sOutput;
				
			} else {
				return nData;
			}
		},
		// Tony Tomov
		// PHP implementation. Sorry not all options are supported.
		// Feel free to add them if you want
		DateFormat : function (format, date, newformat, opts)  {
			var	token = /\\.|[dDjlNSwzWFmMntLoYyaABgGhHisueIOPTZcrU]/g,
			timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
			timezoneClip = timezoneClip = /[^-+\dA-Z]/g,
			pad = function (value, length) {
				value = String(value);
				length = parseInt(length) || 2;
				while (value.length < length) value = '0' + value;
				return value;
			},
		    ts = {m : 1, d : 1, y : 1970, h : 0, i : 0, s : 0},
		    timestamp=0,
		    dateFormat=["i18n"];
			// Internationalization strings
		    dateFormat["i18n"] = {
				dayNames:   opts.dayNames,
		    	monthNames: opts.monthNames
			};
			format = format.toLowerCase();
			date = date.split(/[\\\/:_;.tT\s-]/);
			format = format.split(/[\\\/:_;.tT\s-]/);
			// !!!!!!!!!!!!!!!!!!!!!!
			// Here additional code to parse for month names
			// !!!!!!!!!!!!!!!!!!!!!!
		    for(var i=0;i<format.length;i++){
		        ts[format[i]] = parseInt(date[i],10);
		    }
		    ts.m = parseInt(ts.m)-1;
		    var ty = ts.y;
		    if (ty >= 70 && ty <= 99) ts.y = 1900+ts.y;
		    else if (ty >=0 && ty <=69) ts.y= 2000+ts.y;
		    timestamp = new Date(ts.y, ts.m, ts.d, ts.h, ts.i, ts.s,0);
			if( opts.masks.newformat )  {
				newformat = opts.masks.newformat;
			} else if ( !newformat ) {
				newformat = 'Y-m-d';
			}
		    var 
		        G = timestamp.getHours(),
		        i = timestamp.getMinutes(),
		        j = timestamp.getDate(),
				n = timestamp.getMonth() + 1,
				o = timestamp.getTimezoneOffset(),
				s = timestamp.getSeconds(),
				u = timestamp.getMilliseconds(),
				w = timestamp.getDay(),
				Y = timestamp.getFullYear(),
				N = (w + 6) % 7 + 1,
				z = (new Date(Y, n - 1, j) - new Date(Y, 0, 1)) / 86400000,
				flags = {
					// Day
					d: pad(j),
					D: dateFormat.i18n.dayNames[w],
					j: j,
					l: dateFormat.i18n.dayNames[w + 7],
					N: N,
					S: opts.S(j),
					//j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th',
					w: w,
					z: z,
					// Week
					W: N < 5 ? Math.floor((z + N - 1) / 7) + 1 : Math.floor((z + N - 1) / 7) || ((new Date(Y - 1, 0, 1).getDay() + 6) % 7 < 4 ? 53 : 52),
					// Month
					F: dateFormat.i18n.monthNames[n - 1 + 12],
					m: pad(n),
					M: dateFormat.i18n.monthNames[n - 1],
					n: n,
					t: '?',
					// Year
					L: '?',
					o: '?',
					Y: Y,
					y: String(Y).substring(2),
					// Time
					a: G < 12 ? opts.AmPm[0] : opts.AmPm[1],
					A: G < 12 ? opts.AmPm[2] : opts.AmPm[3],
					B: '?',
					g: G % 12 || 12,
					G: G,
					h: pad(G % 12 || 12),
					H: pad(G),
					i: pad(i),
					s: pad(s),
					u: u,
					// Timezone
					e: '?',
					I: '?',
					O: (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
					P: '?',
					T: (String(timestamp).match(timezone) || [""]).pop().replace(timezoneClip, ""),
					Z: '?',
					// Full Date/Time
					c: '?',
					r: '?',
					U: Math.floor(timestamp / 1000)
				};	
			return newformat.replace(token, function ($0) {
				return $0 in flags ? flags[$0] : $0.substring(1);
			});			
		}
	};
	$.fn.fmatter.defaultFormat = function(el, cellval, opts) {
		$(el).html((isValue(cellval) && cellval!=="" ) ?  cellval : "&#160;");
	};
	$.fn.fmatter.email = function(el, cellval, opts) {
		if(!isEmpty(cellval)) {
            $(el).html("<a href=\"mailto:" + cellval + "\">" + cellval + "</a>");
        }else {
           $.fn.fmatter.defaultFormat(el, cellval);
        }
	};
	$.fn.fmatter.checkbox =function(el,cval,opts) {
		cval=cval+""; cval=cval.toLowerCase();
		var bchk = cval.search(/(false|0|no|off)/i)<0 ? " checked=\"checked\"" : "";
        $(el).html("<input type=\"checkbox\"" + bchk  + " value=\""+ cval+"\" offval=\"no\" disabled/>");
    },
	$.fn.fmatter.link = function(el,cellval,opts) {
        if(!isEmpty(cellval)) {
           $(el).html("<a href=\"" + cellval + "\">" + cellval + "</a>");
        }else {
            $(el).html(isValue(cellval) ? cellval : "");
        }
    };
	$.fn.fmatter.showlink = function(el,cellval,opts) {
		var op = {baseLinkUrl: opts.baseLinkUrl,showAction:opts.showAction, addParam: opts.addParam };
		if(!isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		idUrl = op.baseLinkUrl+op.showAction + '?id='+opts.rowId+op.addParam;
        if(isString(cellval)) {	//add this one even if its blank string
			$(el).html("<a href=\"" + idUrl + "\">" + cellval + "</a>");
        }else {
			$.fn.fmatter.defaultFormat(el, cellval);
	    }
    };
	$.fn.fmatter.integer = function(el,cellval,opts) {
		var op = $.extend({},opts.integer);
		if(!isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		if(isEmpty(cellval)) {
			cellval = op.defaultValue || 0;
		}
		$(el).html($.fmatter.util.NumberFormat(cellval,op));
	};
	$.fn.fmatter.number = function (el,cellval, opts) {
		var op = $.extend({},opts.number);
		if(!isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		if(isEmpty(cellval)) {
			cellval = op.defaultValue || 0;
		}
		$(el).html($.fmatter.util.NumberFormat(cellval,op));
	};
	$.fn.fmatter.currency = function (el,cellval, opts) {
		var op = $.extend({},opts.currency);
		if(!isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		if(isEmpty(cellval)) {
			cellval = op.defaultValue || 0;
		}
		$(el).html($.fmatter.util.NumberFormat(cellval,op));
	};
	$.fn.fmatter.date = function (el, cellval, opts, act) {
		var op = $.extend({},opts.date);
		if(!isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		if(!op.reformatAfterEdit && act=='edit'){
			$.fn.fmatter.defaultFormat(el,cellval);
		} else if(!isEmpty(cellval)) {
			var ndf = $.fmatter.util.DateFormat(op.srcformat,cellval,op.newformat,op);
			$(el).html(ndf);
		} else {
			$.fn.fmatter.defaultFormat(el,cellval);
		}
	};
	$.fn.fmatter.select = function (el, cellval,opts, act) {
		// jqGrid specific
		if(act=='edit') {
			$.fn.fmatter.defaultFormat(el,cellval);
		} else if (!isEmpty(cellval)) {
			var oSelect = false;
			if(!isUndefined(opts.colModel.editoptions)){
				oSelect= opts.colModel.editoptions.value;
			}
			if (oSelect) {
				var ret = [];
				var msl =  opts.colModel.editoptions.multiple === true ? true : false;
				var scell = [];
				if(msl) { scell = cellval.split(","); scell = $.map(scell,function(n){return $.trim(n);})}
				if (isString(oSelect)) {
					// mybe here we can use some caching with care ????
					var so = oSelect.split(";"), j=0;
					for(var i=0; i<so.length;i++){
						sv = so[i].split(":");
						if(msl) {
							if(jQuery.inArray(sv[0],scell)>-1) {
								ret[j] = sv[1];
								j++;
							}
						} else if($.trim(sv[0])==$.trim(cellval)) {
							ret[0] = sv[1];
							break;
						}
					}
				} else if(isObject(oSelect)) {
					// this is quicker
					if(msl) {
						ret = jQuery.map(scel, function(n, i){
							return oSelect[n];
						});
					}
					ret[0] = oSelect[cellval] || "";
				}
				$(el).html(ret.join(", "));
			} else {
				$.fn.fmatter.defaultFormat(el,cellval);
			}
		}
	};
	$.unformat = function (cellval,options,pos,cnt) {
		// specific for jqGrid only
		var ret, formatType = options.colModel.formatter, op =options.colModel.formatoptions || {};
		if(formatType !== 'undefined' && isString(formatType) ) {
			var opts = $.jgrid.formatter || {}, stripTag;
			switch(formatType) {
				case 'link' :
				case 'showlink' :
				case 'email' :
					ret= $(cellval).text();
					break;
				case 'integer' :
					op = $.extend({},opts.integer,op);
					stripTag = eval("/"+op.thousandsSeparator+"/g");
					ret = $(cellval).text().replace(stripTag,'');
					break;
				case 'number' :
					op = $.extend({},opts.number,op);
					stripTag = eval("/"+op.thousandsSeparator+"/g");
					ret = $(cellval).text().replace(op.decimalSeparator,'.').replace(stripTag,"");
					break;
				case 'currency':
					op = $.extend({},opts.currency,op);
					stripTag = eval("/"+op.thousandsSeparator+"/g");
					ret = $(cellval).text().replace(op.decimalSeparator,'.').replace(op.prefix,'').replace(op.suffix,'').replace(stripTag,'');
					break;
				case 'checkbox' :
					var cbv = (options.colModel.editoptions) ? options.colModel.editoptions.value.split(":") : ["Yes","No"];
					ret = $('input',cellval).attr("checked") ? cbv[0] : cbv[1];
					break;
			}
		}
		//else {
			// Here aditional code to run custom unformater
		//}
		return ret ? ret : cnt===true ? $(cellval).text() : $.htmlDecode($(cellval).html());
	};
	function fireFormatter(el,formatType,cellval, opts, act) {
		//debug("in formatter with " +formatType);
	    formatType = formatType.toLowerCase();
	    switch (formatType) {
	        case 'link': $.fn.fmatter.link(el, cellval, opts); break;
			case 'showlink': $.fn.fmatter.showlink(el, cellval, opts); break;
	        case 'email': $.fn.fmatter.email(el, cellval, opts); break;
			case 'currency': $.fn.fmatter.currency(el, cellval, opts); break;
	        case 'date': $.fn.fmatter.date(el, cellval, opts, act); break;
	        case 'number': $.fn.fmatter.number(el, cellval, opts) ; break;
	        case 'integer': $.fn.fmatter.integer(el, cellval, opts) ; break;
	        case 'checkbox': $.fn.fmatter.checkbox(el, cellval, opts); break;
	        case 'select': $.fn.fmatter.select(el, cellval, opts,act); break;
	        //case 'textbox': s.transparent = false; break;
	    }
	};
	//private methods and data
	function debug($obj) {
		if (window.console && window.console.log) window.console.log($obj);
	};
	/**
     * A convenience method for detecting a legitimate non-null value.
     * Returns false for null/undefined/NaN, true for other values, 
     * including 0/false/''
	 *  --taken from the yui.lang
     */
    isValue= function(o) {
		return (isObject(o) || isString(o) || isNumber(o) || isBoolean(o));
    };
	isBoolean= function(o) {
        return typeof o === 'boolean';
    };
    isNull= function(o) {
        return o === null;
    };
    isNumber= function(o) {
        return typeof o === 'number' && isFinite(o);
    };
    isString= function(o) {
        return typeof o === 'string';
    };
	/**
	* check if its empty trim it and replace \&nbsp and \&#160 with '' and check if its empty ===""
	* if its is not a string but has a value then it returns false, Returns true for null/undefined/NaN
	essentailly this provdes a way to see if it has any value to format for things like links
	*/
 	isEmpty= function(o) {
		if(!isString(o) && isValue(o)) {
			return false;
		}else if (!isValue(o)){
			return true;
		}
		o = $.trim(o).replace(/\&nbsp\;/ig,'').replace(/\&#160\;/ig,'');
        return o==="";
		
    };
    isUndefined= function(o) {
        return typeof o === 'undefined';
    };
	isObject= function(o) {
		return (o && (typeof o === 'object' || isFunction(o))) || false;
    };
	isFunction= function(o) {
        return typeof o === 'function';
    };

})(jQuery);/*
org: 'http://www.JSON.org',
    copyright: '(c)2005 JSON.org',
    license: 'http://www.crockford.com/JSON/license.html',
    
    Some modifications and additions from Tony Tomov
    Added parse function to prevent JSON Hijacking
    Read below
*/
var JSON = {
    stringify: function stringify(arg) {
        var c, i, l, s = '', v;
        switch (typeof arg) {
        case 'object':
            if (arg) {
                if (arg.constructor == Array) {
                    for (i = 0; i < arg.length; ++i) {
                        v = stringify(arg[i]);
                        if (s) {
                            s += ',';
                        }
                        s += v;
                    }
                    return '[' + s + ']';
                } else if (typeof arg.toString != 'undefined') {
                    for (i in arg) {
                        v = stringify(arg[i]);
                        if (typeof v != 'function') {
                            if (s) {
                                s += ',';
                            }
                            s += stringify(i) + ':' + v;
                        }
                    }
                    return '{' + s + '}';
                }
            }
            return 'null';
        case 'number':
            return isFinite(arg) ? String(arg) : 'null';
        case 'string':
            l = arg.length;
            s = '"';
            for (i = 0; i < l; i += 1) {
                c = arg.charAt(i);
                if (c >= ' ') {
                    if (c == '\\' || c == '"') {
                        s += '\\';
                    }
                    s += c;
                } else {
                    switch (c) {
                        case '\b':
                            s += '\\b';
                            break;
                        case '\f':
                            s += '\\f';
                            break;
                        case '\n':
                            s += '\\n';
                            break;
                        case '\r':
                            s += '\\r';
                            break;
                        case '\t':
                            s += '\\t';
                            break;
                        default:
                            c = c.charCodeAt();
                            s += '\\u00' + Math.floor(c / 16).toString(16) +
                                (c % 16).toString(16);
                    }
                }
            }
            return s + '"';
        case 'boolean':
            return String(arg);
        case 'function' :
			// Added for use of jqGrid T. Tomov
         	return arg.toString();
        default:
            return 'null';
        }
    },
	// Read this if you want to protect your json return string
	// http://safari.oreilly.com/9780596514839/recipe-1107
	//
	// 1.The while(1); construct, located at the beginning of JSON text,
	// 2.Comments at the beginning and end of the text.
	// JSON data providers are encouraged to use one or both of these methods
	// to prevent data execution. Such JSON response may then look like this:
	// while(1);/*{[
    //    {"name":"safe value 1"},
    //    {"name":"safe value 2"},
    //    ...
	// ]}*/
	parse : function(jsonString) {
		// filter out while statement 
		var js = jsonString;
		if (js.substr(0,9) == "while(1);") { js = js.substr(9); }
		if (js.substr(0,2) == "/*") { js = js.substr(2,js.length-4); }
		return eval('('+js+')');
	}
}
/*
	The below work is licensed under Creative Commons GNU LGPL License.

	Original work:

	License:     http://creativecommons.org/licenses/LGPL/2.1/
	Author:      Stefan Goessner/2006
	Web:         http://goessner.net/ 

	Modifications made:

	Version:     0.9-p5
	Description: Restructured code, JSLint validated (no strict whitespaces),
	             added handling of empty arrays, empty strings, and int/floats values.
	Author:      Michael Schøler/2008-01-29
	Web:         http://michael.hinnerup.net/blog/2008/01/26/converting-json-to-xml-and-xml-to-json/
	
	Description: json2xml added support to convert functions as CDATA
	             so it will be easy to write characters that cause some problems when convert
	Author:      Tony Tomov
*/

/*global alert */
var xmlJsonClass = {
	// Param "xml": Element or document DOM node.
	// Param "tab": Tab or indent string for pretty output formatting omit or use empty string "" to supress.
	// Returns:     JSON string
	xml2json: function(xml, tab) {
		if (xml.nodeType === 9) {
			// document node
			xml = xml.documentElement;
		}
		var nws = this.removeWhite(xml);
		var obj = this.toObj(nws);
		var json = this.toJson(obj, xml.nodeName, "\t");
		return "{\n" + tab + (tab ? json.replace(/\t/g, tab) : json.replace(/\t|\n/g, "")) + "\n}";
	},

	// Param "o":   JavaScript object
	// Param "tab": tab or indent string for pretty output formatting omit or use empty string "" to supress.
	// Returns:     XML string
	json2xml: function(o, tab) {
		var toXml = function(v, name, ind) {
			var xml = "";
			var i, n;
			if (v instanceof Array) {
				if (v.length === 0) {
					xml += ind + "<"+name+">__EMPTY_ARRAY_</"+name+">\n";
				}
				else {
					for (i = 0, n = v.length; i < n; i += 1) {
						var sXml = ind + toXml(v[i], name, ind+"\t") + "\n";
						xml += sXml;
					}
				}
			}
			else if (typeof(v) === "object") {
				var hasChild = false;
				xml += ind + "<" + name;
				var m;
				for (m in v) if (v.hasOwnProperty(m)) {
					if (m.charAt(0) === "@") {
						xml += " " + m.substr(1) + "=\"" + v[m].toString() + "\"";
					}
					else {
						hasChild = true;
					}
				}
				xml += hasChild ? ">" : "/>";
				if (hasChild) {
					for (m in v) if (v.hasOwnProperty(m)) {
						if (m === "#text") {
							xml += v[m];
						}
						else if (m === "#cdata") {
							xml += "<![CDATA[" + v[m] + "]]>";
						}
						else if (m.charAt(0) !== "@") {
							xml += toXml(v[m], m, ind+"\t");
						}
					}
					xml += (xml.charAt(xml.length - 1) === "\n" ? ind : "") + "</" + name + ">";
				}
			}
			else if (typeof(v) === "function") {
				xml += ind + "<" + name + ">" + "<![CDATA[" + v + "]]>" + "</" + name + ">";
			}
			else {
				if (v.toString() === "\"\"" || v.toString().length === 0) {
					xml += ind + "<" + name + ">__EMPTY_STRING_</" + name + ">";
				} 
				else {
					xml += ind + "<" + name + ">" + v.toString() + "</" + name + ">";
				}
			}
			return xml;
		};
		var xml = "";
		var m;
		for (m in o) if (o.hasOwnProperty(m)) {
			xml += toXml(o[m], m, "");
		}
		return tab ? xml.replace(/\t/g, tab) : xml.replace(/\t|\n/g, "");
	},
	// Added by Tony Tomov
	// parses xml string and convert it to xml Document
	parseXml : function (xmlString) {
		var xmlDoc;
		try	{
			var parser = new DOMParser();
			xmlDoc = parser.parseFromString(xmlString,"text/xml");
		}
		catch(e) {
			xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async=false;
			xmlDoc["loadXM"+"L"](xmlString);
		}
		return (xmlDoc && xmlDoc.documentElement && xmlDoc.documentElement.tagName != 'parsererror') ? xmlDoc : null;
	},
	// Internal methods
	toObj: function(xml) {
		var o = {};
		var FuncTest = /function/i;
		if (xml.nodeType === 1) {
			// element node ..
			if (xml.attributes.length) {
				// element with attributes ..
				var i;
				for (i = 0; i < xml.attributes.length; i += 1) {
					o["@" + xml.attributes[i].nodeName] = (xml.attributes[i].nodeValue || "").toString();
				}
			}
			if (xml.firstChild) {
				// element has child nodes ..
				var textChild = 0, cdataChild = 0, hasElementChild = false;
				var n;
				for (n = xml.firstChild; n; n = n.nextSibling) {
					if (n.nodeType === 1) {
						hasElementChild = true;
					}
					else if (n.nodeType === 3 && n.nodeValue.match(/[^ \f\n\r\t\v]/)) {
						// non-whitespace text
						textChild += 1;
					}
					else if (n.nodeType === 4) {
						// cdata section node
						cdataChild += 1;
					}
				}
				if (hasElementChild) {
					if (textChild < 2 && cdataChild < 2) {
						// structured element with evtl. a single text or/and cdata node ..
						this.removeWhite(xml);
						for (n = xml.firstChild; n; n = n.nextSibling) {
							if (n.nodeType === 3) {
								// text node
								o["#text"] = this.escape(n.nodeValue);
							}
							else if (n.nodeType === 4) {
								// cdata node
								if (FuncTest.test(n.nodeValue)) {
									o[n.nodeName] = [o[n.nodeName], n.nodeValue];
								} else {
									o["#cdata"] = this.escape(n.nodeValue);
								}
							}
							else if (o[n.nodeName]) {
								// multiple occurence of element ..
								if (o[n.nodeName] instanceof Array) {
									o[n.nodeName][o[n.nodeName].length] = this.toObj(n);
								}
								else {
									o[n.nodeName] = [o[n.nodeName], this.toObj(n)];
								}
							}
							else {
								// first occurence of element ..
								o[n.nodeName] = this.toObj(n);
							}
						}
					}
					else {
						// mixed content
						if (!xml.attributes.length) {
							o = this.escape(this.innerXml(xml));
						}
						else {
							o["#text"] = this.escape(this.innerXml(xml));
						}
					}
				}
				else if (textChild) {
					// pure text
					if (!xml.attributes.length) {
						o = this.escape(this.innerXml(xml));
						if (o === "__EMPTY_ARRAY_") {
							o = "[]";
						} else if (o === "__EMPTY_STRING_") {
							o = "";
						}
					}
					else {
						o["#text"] = this.escape(this.innerXml(xml));
					}
				}
				else if (cdataChild) {
					// cdata
					if (cdataChild > 1) {
						o = this.escape(this.innerXml(xml));
					}
					else {
						for (n = xml.firstChild; n; n = n.nextSibling) {
							if(FuncTest.test(xml.firstChild.nodeValue)) {
								o = xml.firstChild.nodeValue;
								break;
							} else {
								o["#cdata"] = this.escape(n.nodeValue);
							}
						}
					}
				}
			}
			if (!xml.attributes.length && !xml.firstChild) {
				o = null;
			}
		}
		else if (xml.nodeType === 9) {
			// document.node
			o = this.toObj(xml.documentElement);
		}
		else {
			alert("unhandled node type: " + xml.nodeType);
		}
		return o;
	},
	toJson: function(o, name, ind) {
		var json = name ? ("\"" + name + "\"") : "";
		if (o === "[]") {
			json += (name ? ":[]" : "[]");
		}
		else if (o instanceof Array) {
			var n, i;
			for (i = 0, n = o.length; i < n; i += 1) {
				o[i] = this.toJson(o[i], "", ind + "\t");
			}
			json += (name ? ":[" : "[") + (o.length > 1 ? ("\n" + ind + "\t" + o.join(",\n" + ind + "\t") + "\n" + ind) : o.join("")) + "]";
		}
		else if (o === null) {
			json += (name && ":") + "null";
		}
		else if (typeof(o) === "object") {
			var arr = [];
			var m;
			for (m in o) if (o.hasOwnProperty(m)) {
				arr[arr.length] = this.toJson(o[m], m, ind + "\t");
			}
			json += (name ? ":{" : "{") + (arr.length > 1 ? ("\n" + ind + "\t" + arr.join(",\n" + ind + "\t") + "\n" + ind) : arr.join("")) + "}";
		}
		else if (typeof(o) === "string") {
			var objRegExp  = /(^-?\d+\.?\d*$)/;
			var FuncTest = /function/i;
			o = o.toString();
			if (objRegExp.test(o) || FuncTest.test(o) || o==="false" || o==="true") {
				// int or float
				json += (name && ":") + o;
			} 
			else {
				json += (name && ":") + "\"" + o + "\"";
			}
		}
		else {
			json += (name && ":") + o.toString();
		}
		return json;
	},
	innerXml: function(node) {
		var s = "";
		if ("innerHTML" in node) {
			s = node.innerHTML;
		}
		else {
			var asXml = function(n) {
				var s = "", i;
				if (n.nodeType === 1) {
					s += "<" + n.nodeName;
					for (i = 0; i < n.attributes.length; i += 1) {
						s += " " + n.attributes[i].nodeName + "=\"" + (n.attributes[i].nodeValue || "").toString() + "\"";
					}
					if (n.firstChild) {
						s += ">";
						for (var c = n.firstChild; c; c = c.nextSibling) {
							s += asXml(c);
						}
						s += "</" + n.nodeName + ">";
					}
					else {
						s += "/>";
					}
				}
				else if (n.nodeType === 3) {
					s += n.nodeValue;
				}
				else if (n.nodeType === 4) {
					s += "<![CDATA[" + n.nodeValue + "]]>";
				}
				return s;
			};
			for (var c = node.firstChild; c; c = c.nextSibling) {
				s += asXml(c);
			}
		}
		return s;
	},
	escape: function(txt) {
		return txt.replace(/[\\]/g, "\\\\").replace(/[\"]/g, '\\"').replace(/[\n]/g, '\\n').replace(/[\r]/g, '\\r');
	},
	removeWhite: function(e) {
		e.normalize();
		var n;
		for (n = e.firstChild; n; ) {
			if (n.nodeType === 3) {
				// text node
				if (!n.nodeValue.match(/[^ \f\n\r\t\v]/)) {
					// pure whitespace text node
					var nxt = n.nextSibling;
					e.removeChild(n);
					n = nxt;
				}
				else {
					n = n.nextSibling;
				}
			}
			else if (n.nodeType === 1) {
				// element node
				this.removeWhite(n);
				n = n.nextSibling;
			}
			else {
				// any other node
				n = n.nextSibling;
			}
		}
		return e;
	}
};