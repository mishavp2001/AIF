<html>
<head>
		<link rel="stylesheet" href="css/global.css" type="text/css" media="all" />
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui.css" type="text/css" media="all" />
		
		<script language="javascript" type="text/javascript" src="./js/maxrating.js"></script>
   
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui.min.js"></script>

	<style>
		.rate-val, .rate-weight{
			color: lightgrey;
			font-size: 10px;
		}
		.rate-val img, .rate-weight img{
			width: 12px;
		}
	</style>
	
	<script type="text/javascript">
		$(document).ready(function(){
		
		// Ghost Text
		function addTextHint(elem, hintText){           
			
			if (elem.val() == '')   
			{               
				elem.val(hintText);
				elem.addClass('ghost');
			}

			elem.focus(function(){                       
				if (elem.val() == hintText)                     
				{
						elem.val('');
						elem.removeClass('ghost').addClass('normal');
				}
			});
				

			elem.blur(function (){
				if (elem.val() == '')
				{
						elem.val(hintText);
						elem.removeClass('normal').addClass('ghost');
				}
			});                       
		}
		
			function calcWeightedRate(rateWeightDiv) {
				var weighted = 0;
				  
				var rates = $(rateWeightDiv[0]).find('input.rate');
				var rateWeights = $(rateWeightDiv[0]).find('input.weight');
				
				var i=0;
				rateVal=0;
				rateWeight=0;
				rateTotal=0;
				rateWeightTotal=0;
				
				
				for(i=0; i<rates.length; i++){
					rateVal = parseInt($(rates[i]).val()); // Value of rating
					rateWeight = parseInt($(rateWeights[i]).val()); // Waight of rating
					rateTotal = rateTotal + rateVal*rateWeight;
					rateWeightTotal = rateWeightTotal + rateWeight;			
				}	
			    return Math.ceil(rateTotal/rateWeightTotal);
			}

			function displayRate() {
			  var weightedRate = calcWeightedRate($('#rateWeight'));
			  $("#weightedRate").html(weightedRate);
			}
			
			
			function getRatings(topic, type, id) {
				$.ajax({
					url: "../server/getRatings.php", 
					data:{'item': topic + '-' + type,
						  'type': type,	
						  'max': 10 },
					success: function(data) {
						$('#' + id).html(data);
					}
				});
			}
			
			function loadRates() {
				var ratableLinks = $('#rateWeight').find("a");
				for(i=0; i<ratableLinks.length; i++){
					var id = $(ratableLinks[i]).text();
					var inpiutRateid = i + "-rate";
					var inpiutWeightid = i + "-rate-weight";
					var rateInputVal = $("<span id='" + inpiutRateid + "' class='rate-val' />");
					var rateInputWeight = $("<span id='" + inpiutWeightid + "' class='rate-weight' />");
					$(ratableLinks[i]).after(rateInputWeight).after("<span>Weight:</span>").after(rateInputVal).after("<span>Rate:</span>");
					//addTextHint($('#'+ inpiutRateid),'Enter Rate');
					//addTextHint($('#'+ inpiutWeightid),'Enter Rates Weight');
					getRatings(id,"rate", inpiutRateid);
					getRatings(id, "weight", inpiutWeightid);
				}	
			}

			loadRates();
			
			
			$("#calculateRate").click(function(){
				displayRate();
			});
			
			
			$("#rateOverlay").dialog({
				autoOpen: false,
				title: 'Enter your Rating'
			}); 
			
			$("#saveRate").click(function(){
				var id = $("#rateId").val();
				var inpiutRateid = id + "-rate-input";
				var inpiutWeightid = id + "-rate-input";
				
				var rateInputVal = $("<input id='" + inpiutRateid + "' class='rate-val' />").val($("#1r").val());
				var rateInputWeight = $("<input id='" + inpiutWeightid + "' class='rate-weight' />").val($("#1w").val());
				
				var spanid = id + "-span";
				var rateDiv = $("<span id='" + spanid + "'>*** Rate:" + $("#1r").val() + "Weight:" + $("#1w").val()	+ "****</span>");

				$("#" + spanid).remove();
				$("#" + inpiutRateid).remove();
				$("#" + inpiutWeightid).remove();
				$("#" + id).append(rateDiv).append(rateInputVal).append(rateInputWeight);
				$("#rateOverlay").dialog('close');
				// prevent the default action, e.g., following a link
				return false;
			}); 
			$("a.rate").click(function(){
				$("#rateOverlay").dialog('open');
				$("#rateId").val($(this)[0].id);
				// prevent the default action, e.g., following a link
				return false;
			}); 
			
			
		});	
	</script>
</head>

<body>


	<div id="rateWeight"> 	
		1. Argumnet: <a href="www.yahoo.com/">test1</a><br/>
		2. Argumnet: <a href="www.yahoo.com/">test2</a><br/>
		3. Argumnet: <a href="www.yahoo.com/">test3</a><br/>
		4. Argumnet: <a href="www.yahoo.com/">test4</a><br/>
		Weighted Rate: <span id="weightedRate"></span> 
	</div>	
	<div id="rateOverlay">
		Rate:<input class="rate-val" type="text" id="1r" />
		Weight:<input class="rate-weight" type="text" id="1w" /><br>
		<input type="submit" id="saveRate" value="Save" />
		<input type="hidden" id="rateId" value="" />
	</div>	
	<input type="submit" id="calculateRate" value="Calculate" />
</body>	