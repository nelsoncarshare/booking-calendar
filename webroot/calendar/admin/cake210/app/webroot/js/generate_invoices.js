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
    
    ncal.admin.geninv = {
            year: 1901,
            month: -1,
            validating: true,
            newInvoiceNumber: -1,
            trans_id: -1,
            list_of_ids: [],
            billing: null,
            idx: ""
            };

	ncal.admin.geninv._checkNextCasualUser = function(){
                    var i = ncal.admin.checkCasualUsers.idx;
                    ncal.admin.checkCasualUsers.idx++;
                    if (i >= ncal.admin.checkCasualUsers.list_of_ids.length){
                        jQuery('#progressMessage').html("Done");
                        return;
                    }
                    invoicable_id = ncal.admin.checkCasualUsers.list_of_ids[i];
                    jQuery('#progressMessage').html("Checking casual user " + (i + 1) + " of " + ncal.admin.checkCasualUsers.list_of_ids.length);
                    jQuery.ajax({
                      dataType:'json',
                      url: CAKE_ROOT + 'generateinvoices/check_casual_user/' + invoicable_id + 
                                                                                             '/' + ncal.admin.geninv.year + 
                                                                                             '/' + ncal.admin.geninv.month,
                      success: function(data) {
                        var invoicable_id = data.invoicable_id;
                        if (data.success){
							
                            jQuery("div#invoicable_message_" + invoicable_id).html(data.message).addClass("successClass");
							if (data.foundBooking == "true"){
								jQuery("input#" + invoicable_id).attr('checked','checked');
							}
                        } else {
                            var errorStr = data.message + '<br/>';
                            for (i = 0; i < data.errors.length; i++){
                                item = data.errors[i];
                                errorStr += "&nbsp;&nbsp;&nbsp;"+ item + "<br/>";
                            }
                            jQuery("div#invoicable_message_" + invoicable_id).html(errorStr).addClass("errorClass");
                        }
                        ncal.admin.geninv._checkNextCasualUser();
                      },
                      error: function(data) {
						var message = "Error checking casual user.";
						if (!data.success){
							message += data.message;
						}
                        jQuery("div#invoicable_message_" + invoicable_id).html(message).addClass("error");
                        ncal.admin.geninv._checkNextCasualUser();
                      }
                    });
	};
	
    ncal.admin.geninv._generateNextInvoice = function(){
                    var i = ncal.admin.geninv.idx;
                    ncal.admin.geninv.idx++;
                    if (i >= ncal.admin.geninv.list_of_ids.length){
                        jQuery('#progressMessage').html("Done");
                        return;
                    }
                    invoicable_id = ncal.admin.geninv.list_of_ids[i];
                    ncal.admin.geninv.newInvoiceNumber = parseInt(ncal.admin.geninv.billing.invoice_num_to_start_at) + i;
                    ncal.admin.geninv.transId = i + 1;
                    jQuery('#progressMessage').html("Working on invoice " + (i + 1) + " of " + ncal.admin.geninv.list_of_ids.length);
                    jQuery.ajax({
                      dataType:'json',
                      url: CAKE_ROOT + '/generateinvoices/geninvoice/' + invoicable_id + 
                                                                                             '/' + ncal.admin.geninv.year + 
                                                                                             '/' + ncal.admin.geninv.month + 
                                                                                             '/' + ncal.admin.geninv.newInvoiceNumber + 
                                                                                             '/' + ncal.admin.geninv.transId + 
                                                                                             '/' + ncal.admin.geninv.validating,
                      success: function(data) {
                        var invoicable_id = data.invoicable_id;
                        if (data.success){
                            jQuery("div#invoicable_message_" + invoicable_id).html(data.message).addClass("successClass");
                        } else {
                            var errorStr = data.message + '<br/>';
                            for (i = 0; i < data.errors.length; i++){
                                item = data.errors[i];
                                errorStr += "&nbsp;&nbsp;&nbsp;"+ item + "<br/>";
                            }
//                            for each (var item in data.errors){
//                                errorStr += "&nbsp;&nbsp;&nbsp;"+ item + "<br/>";
//                            }
                            jQuery("div#invoicable_message_" + invoicable_id).html(errorStr).addClass("errorClass");
                        }
                        ncal.admin.geninv._generateNextInvoice();
                      },
                      error: function(data) {
						var message = "Error generating invoice.";
						if (!data.success){
							message += data.message;
						}
                        jQuery("div#invoicable_message_" + invoicable_id).html(message).addClass("error");
                        ncal.admin.geninv._generateNextInvoice();
                      }
                    });    
    };   
    
	ncal.admin.geninv.checkCasualUsersThatUsedThisMonth = function(){
        var year = jQuery("input[name='year']").val();
        var month = jQuery("input[name='month']").val();
        ncal.admin.geninv.year = year;
        ncal.admin.geninv.month = month;
		ncal.admin.checkCasualUsers = new Object();
        ncal.admin.checkCasualUsers.list_of_ids = [];
        ncal.admin.checkCasualUsers.idx = 0;
		jQuery("input[type='checkbox'][isMember='0']").each(function(i){
			invoiceable_id = this.id
			ncal.admin.checkCasualUsers.list_of_ids.push(invoiceable_id);
		});
		ncal.admin.geninv._checkNextCasualUser();
	};
	
    ncal.admin.geninv.generateInvoicesForSlected = function(validating){
        var year = jQuery("input[name='year']").val();
        var month = jQuery("input[name='month']").val();

        ncal.admin.geninv.year = year;
        ncal.admin.geninv.month = month;
        ncal.admin.geninv.validating = validating;
                     
        //erase old messages
        ncal.admin.geninv.list_of_ids = [];
        ncal.admin.geninv.idx = 0;
        jQuery('#clearAllUsersIIFMessage').html("").removeClass("successClass").removeClass("errorClass");
        jQuery('div.message').html("").removeClass("successClass").removeClass("errorClass");
        
        //clear all users iif file and get billing object
        jQuery.ajax({
          dataType:'json',
          url: CAKE_ROOT + 'generateinvoices/clearAllUsersiifFile/' + month + "/" + year + "/" + validating,
          success: function(data){
            if (data.success){
                jQuery('#clearAllUsersIIFMessage').html(data.message).addClass("successClass");
                ncal.admin.geninv.billing = data.billing;

                jQuery("input[type='checkbox'][name^='invoicable_']:checked").each(function(i){
                    invoiceable_id = this.id
                    ncal.admin.geninv.list_of_ids.push(invoiceable_id);
                });
                ncal.admin.geninv._generateNextInvoice();
            } else {
                jQuery('#clearAllUsersIIFMessage').html( String(data.message) ).addClass("errorClass");
                ncal.admin.geninv.billing = null;
            }
          },
          error: function(data) {
            ncal.admin.geninv.billing = null;
			var ms;
			if ("message" in data){
				ms = String(data.message);
			} else if ("responseXML" in data) {
				ms = String(data.responseXML);
			} else {
				ms = String(data);
			}
			alert(ms);
            jQuery('#clearAllUsersIIFMessage').html( ms ).addClass("errorClass");
          }
        });
    }; //end 

//-------------------

    ncal.admin.geninv._mailNextInvoice = function(){
            var i = ncal.admin.geninv.idx;

            ncal.admin.geninv.idx++;
            if (i >= ncal.admin.geninv.list_of_ids.length){
                jQuery('#progressMessage').html("Done");
                return;
            }
            invoicable_id = ncal.admin.geninv.list_of_ids[i];
            jQuery('#progressMessage').html("Sending email for " + (i + 1) + " of " + ncal.admin.geninv.list_of_ids.length);
            jQuery.ajax({
              dataType:'json',
			  			  
              url: CAKE_ROOT + 'generateinvoices/sendmailforuser/' + invoicable_id + 
                                                                                     '/' + ncal.admin.geninv.year + 
                                                                                     '/' + ncal.admin.geninv.month, 
              success: function(data) {
                var invoicable_id = data.invoicable_id;
                if (data.success){
//					alert(data.message);
                    jQuery("div#invoicable_message_" + invoicable_id).html(data.message).addClass("successClass");
                } else {
//					alert(data.message);
                    var errorStr = data.message + '<br/>';
                    for (i = 0; i < data.errors.length; i++){
                        item = data.errors[i];
                        errorStr += "&nbsp;&nbsp;&nbsp;"+ item + "<br/>";
                    }
                    jQuery("div#invoicable_message_" + invoicable_id).html(errorStr).addClass("errorClass");
                }
                ncal.admin.geninv._mailNextInvoice();
              },
              error: function(data) {          
                jQuery("div#invoicable_message_" + invoicable_id).html("Error mailing invoice.").addClass("errorClass");
                ncal.admin.geninv._mailNextInvoice();
              }
            });    
    };  
    
    ncal.admin.geninv.mailInvoicesForSlected = function(){
        var year = jQuery("input[name='year']").val();
        var month = jQuery("input[name='month']").val();

        ncal.admin.geninv.year = year;
        ncal.admin.geninv.month = month;
                     
        //erase old messages
        ncal.admin.geninv.list_of_ids = [];
        ncal.admin.geninv.idx = 0;
        jQuery('#clearAllUsersIIFMessage').html("").removeClass("successClass").removeClass("errorClass");
        jQuery('div.message').html("").removeClass("successClass").removeClass("errorClass");
        
        jQuery("input[type='checkbox'][name^='invoicable_']:checked").each(function(i){
            invoiceable_id = this.id
            ncal.admin.geninv.list_of_ids.push(invoiceable_id);
        });
        ncal.admin.geninv._mailNextInvoice();
    }; //end 

//-------------------

    jQuery("a[name='validate_invoices']").click(function(){
        ncal.admin.geninv.generateInvoicesForSlected(true); 
    });    
	
	jQuery("a[name='check_casual_users_used_this_month']").click(function(){
        ncal.admin.geninv.checkCasualUsersThatUsedThisMonth(); 
    });    
	
    jQuery("a[name='gen_invoices']").click(function(){
        ncal.admin.geninv.generateInvoicesForSlected(false);
    });

    jQuery("a[name='mail_invoices']").click(function(){
        ncal.admin.geninv.mailInvoicesForSlected();
    });  
    
    jQuery("a[id='checkAll']").click(function(){
        jQuery("input[type='checkbox']").attr('checked', true);
    });

    jQuery("a[id='checkNone']").click(function(){
        jQuery("input[type='checkbox']").attr('checked', false);
    });        
});


