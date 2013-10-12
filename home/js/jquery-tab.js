//By ilovecolors.com.ar
//www.ilovecolors.com.ar/multiple-jquery-tabs/

//arrays of objects to collect previous and current tab
var previous = [];
var current = [];
//array to store IDs of our tabs
//store setInterval reference
var tablist = [];

//change tab and highlight current tab title
function change(block){
	//show proper tab, catch IE6 bug
	if (jQuery.browser.msie && jQuery.browser.version.substr(0,3) == "6.0")
		jQuery(block + ' .tab#' + current[block].reference).show();
	else 
		jQuery(block + ' .tab#' + current[block].reference).fadeIn();
	
   
	
	//clear highlight from previous tab title
	jQuery(block + ' .htabs a[href=#' + previous[block].reference + ']').removeClass('select');
	
	//highlight currenttab title
	jQuery(block + ' .htabs a[href=#' + current[block].reference + ']').addClass('select');
	
	//hide the other tabs
	jQuery("#" + previous[block].reference).hide();
	previous[block].reference = current[block].reference;
}
function Tab(blockid){
	var z = 0;
	this.block = blockid;
	this.next = function (){
		previous[this.block].reference = jQuery(this.block + ' .htabs a').get()[z].href.split('#')[1];
		if(z >= jQuery(this.block + ' .htabs a').get().length-1) z = 0; else z++;
		current[this.block].reference  = jQuery(this.block + ' .htabs a').get()[z].href.split('#')[1];
		change(this.block);
	};
}

function Reference(reference){ this.reference = reference; }
function tabs(tobj){

		for (key in tobj) {
			var params = tobj[key].split('&');
			var block = params[0];
			
			//initialize tabs, display the current tab
			jQuery(block + " .tab:not(:first)").hide();
		
            file = jQuery(block + " .tab:first")[0].id + '.html';
            $.get(file, function(data) {
                $("#" + jQuery(block + " .tab:first")[0].id ).html(data);
            });
            
            jQuery(block + " .tab:first").show();
            
            
			//highlight the current tab title
			jQuery(block + ' .htabs a:first').addClass('select');
			
			previous[block] = new Reference(jQuery(block + " .htabs a:first").attr("href").split('#')[1]);
			
			//is actually a reference to the second tab
			current[block]  = new Reference(jQuery(block + ' .htabs a').get()[1].href.split('#')[1]);
			
			//create new Tab to store values for rotation and setInterval id
			tablist[block] = new Tab(block);
			
			if (params[1] != undefined) {
				//set interval to repeat - next line commented
				interid = setInterval("tablist['" + block + "'].next()", params[1]);
				//store in - next line commented
				tablist[block].intervalid = interid;
			}
			
			//handler for clicking on tabs
			jQuery(block + " .htabs a").click(function(event){
				
				//store reference to clicked tab
				target = "#"+event.target.getAttribute("href").split('#')[1];
                file = event.target.getAttribute("href").split('#')[1] + '.html';
                tblock = "#"+jQuery(target).parent().parent().attr("id");
			
				current[tblock].reference = jQuery(this).attr("href").split('#')[1];  
				
                 // Ajax for the selected TAB
                /*$.ajax({
                    url: url,
                    data: data,
                    success: success,
                    dataType: dataType
                });*/
                //alert(tblock);
                $.get(file, function(data) {
                    $("#" + event.target.getAttribute("href").split('#')[1]).html(data);
                    });
                           
				//display referenced tab
				change(tblock);
				
				//if tab is clicked, stop rotating 
				clearInterval(tablist[tblock].intervalid);
				
				return false;
			});
		}
	}