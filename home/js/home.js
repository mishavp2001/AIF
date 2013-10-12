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
    addTextHint($('#search'),'SEARCH');
	addTextHint($('#searchAdd'),'Type topic for your new research here.');
		
	// Colapse events to side menues
	$('.topic').click(function() {
		$(this).next().toggle();
		return false;
	}).next().hide();
	$('.topic:first').next().toggle();
	$('.topic #bookmarksDiv').toggle();
	
	// Colapse events to side menues
	$('.topic-filter span').click(function() {
		switch (this.className) {
			case "categoryFltr":
				removeSelectedfilter(this);
				break;
			case "latestFltr":
				removeSelectedfilter(this);
				break;
			case "popularFltr":
				removeSelectedfilter(this);
				break;
		}
		return false;
	});

	var prevent_bust = 0  
	window.onbeforeunload = function() { prevent_bust++ }  
	setInterval(function() {  
	if (prevent_bust > 0) {  
	   prevent_bust -= 2  
	   window.top.location = ''  
	 }  
	}, 1)  
	
	function loadTab(ui){
		$iFrame = $('<iframe></iframe>');
		$iFrame.attr('src', "http://www.google.com");
		$iFrame.css('width', "100%");
		$iFrame.css('height', "100%");
		if($(ui.tab).text() == "Google"){
			$iFrame.attr('src', "http://www.google.com");
		}
		if($(ui.tab).text() == "Yahoo"){
			$iFrame.attr('src', "http://www.yahoo.com");
		}
		if($(ui.tab).text() == "Ask"){
			$iFrame.attr('src', "http://www.ask.com");
		}
		 $iFrame.load();

		if($iFrame){
			$(ui.panel).empty();
			$(ui.panel).prepend($iFrame);	
		}
	}	
	
	
	
	//Hide submit mnew message form
	$("#cancelRef").click( function () {
		// Cancel submit form
		$("#chatForm").toggle();
		$("#messagewindowDiv").toggle();
	});
	$("#addArguments, #addNewDebates, #addNewArguments, #addAnswers, #addNewQuestions").click( function () {
		//add statment/argument flag
		var statmentFlag = (this.id =='addNewArguments')?'S':'A';
		statmentFlag = (this.id =='addNewQuestions')?'Q':statmentFlag;
		
		$("#statments").val(statmentFlag);
		$("#messagewindowDiv").toggle();
		// Show submit form
		$("#chatForm").toggle();
	});
	
	/*function getNextStatmentId() {
		$.getJSON("../server/getnextStatmentIdJson.php", {
			action: "getNextStatmentId" },
			function(json) {
			$("#statmentId").val(json.nextStatmentId);
		});
	}*/
	
	$("#generated1").click( function () {
		// Show Debate
		$("#debateDiv").toggle();
	});
	
	currentID = 0;
	timestampStatments  = 0;
	timestampArguments  = 0;
	
	
	
	function addArguments(json) {
		if(json.status == "2") return;
		timestampArguments = json.time;
		
		// 
		
		/*$(json.statments).each(function(id) {
			var winTemp = $("#messagewindowDiv");
			winTemp.prepend("<div style='float: left; width: 20%;'><a href='javascript:void(0)' class = 'userRef' id = '" +
										this.user + "'>" +
										this.user + 
										":</a></div>"  +			
										"<div style='float: left; width: 78%;'><a href='javascript:void(0)' class = 'statmentRef draggable' id = '" + 
										this.statmentId + "'>" +
										this.statment +  
										"</a></div>"  +
										"<div style='clear: both;'/>");
										
		});
		*/
		
		
		populateGrid(json.data);
		
		$(".statmentRef").click( function () {
			if($("#chatForm").is(":visible")){
				$("#chatForm").toggle();
			}	
			if(!$("#messagewindowDiv").is(":visible")){
				$("#messagewindowDiv").toggle();
			}	
			var temp = $(this);
			if ($(temp).next('.descriptionDiv').length !== 0){
				$(temp).next('.descriptionDiv').remove();
			} else {
				$.getJSON("../server/fetchDescriptionJson.php",{ statmentId: this.id }, 
					function(jsonDesc) {
						showDescription(jsonDesc, temp)
					}	
				);
				function showDescription(jsonDesc, temp) {
					$.each(jsonDesc.statments, function(key, val) { 
						if (this.description){
							addDescription(temp, this.description);
						}
					});
					function addDescription(temp, desc) {
						$(temp).after( "<div class='descriptionDiv'>" + desc + 
								"<a href='javascript:void(0)' class='rateRef'>"  +
								"Like It." +
							"</a>"	+
						"</div>");	
					}
				}
		
			}
		});			

	}

	function updateArguments(id, time, topic) {
		if( id != currentID) return false;
		time = (!time)? timestampArguments: time;
		$.getJSON("../server/fetchArgumentsJson.php",{ time: time, statmentId: id }, function(json) {
			$(".loading").remove();
			// Add selected topic
			if(topic){
				$("#topicSpan").html("'" + topic + "'");
			}
			getRatings(topic);
			addArguments(json);
		});
		setTimeout(function(){updateArguments(id, null, topic)}, 4000);
	}
	
	function getRatings(topic) {
		$.ajax({
			url: "../server/getRatings.php", 
			data:{'item': topic, 'max': 10 },
			success: function(data) {
				$(".ratingbox").html(data);
			}
		});
	}	

	function updateStatments() {
		$.getJSON("../server/getStatmentsJson.php", 
			{time: timestampStatments, count: 100, type: "_"},
			function(json) {
				addStatments(json);
			}
		);
	}	

	function updateQuestions() {
		$.getJSON("../server/getStatmentsJson.php", 
			{time: timestampStatments, count: 100, type: "q"},
			function(json) {
				addStatments(json);
			}
	);
}	


function addStatments(json){
	timestampStatments = json.time;
	
	$.each(json.statments, function(id) { 
		switch (this.type) {
			case 's':
				$("#statmentsDiv").prepend("<a href='javascript:void(0)' class='blockRef statment draggable'" + "id='" + this.statmentId + "' >" + this.statment + "</a>");
				break;		
			case 'q':
				$("#questionsDiv").prepend("<a href='javascript:void(0)' class='blockRef question draggable'" + "id='" + this.statmentId + "' >" + this.statment + "</a>");	
				break;
		}
	});
	
	$(".blockRef").click( function () {
		$(".blockRef").removeClass('blockRefClicked');
		if( $(this).hasClass('question')){
			$("#addArguments").html("Add Answers");
			$("#addArguments").addClass("addAnswers");
		} else {
			$("#addArguments").html("Add Arguments");
			$("#addArguments").removeClass("addAnswers");
		}
		$(this).addClass('blockRefClicked');
		
		if(!$("#messagewindowDiv").is(":visible")){
			$("#messagewindowDiv").toggle();
			if($("#chatForm").is(":visible")){
				$("#chatForm").toggle();
			}	
		}			
		// Clear Chat room
		$("#messagewindowDiv").empty();
		//('.blockRef, .descriptionDiv').remove();
		// Load context into context div.
		currentID = this.id;
		updateArguments(this.id, 1, $(this).html());
	});
	// Initialize
	$(".blockRef").removeClass('blockRefClicked');
	$(".blockRef:first").addClass('blockRefClicked');
	currentID = $(".blockRef:first")[0].id;
	updateArguments(currentID, 1, $(".blockRef:first").html());	
}	

updateStatments();

$("#submitID").click( function () {
	// Cancel submit form
	$("#chatForm").submit();
	$("#messagewindowDiv").toggle();
});
$("#chatForm").submit(function(){
	switch ($('#statments').val()) {
		case 'S':
				$.getJSON("../server/insertStatmentJson.php",{
					debateId: currentID,
					statment: $("#msg").val(),
					description: $("#description").val(),
					user: $("#author").val(),
					action: "postmsg",
					time: timestampStatments
				}, function(json) {
					$("#chatDiv, #chatForm").toggle();
					updateStatments();
				});
				break;
		case "A":
			$.getJSON("../server/insertArgumentsJson.php",{
					debateId: currentID,
					statment: $("#msg").val(),
					description: $("#description").val(),
					user: $("#author").val(),
					agree: ($("#yes").is(':checked'))?'Y':'N',
					action: "postmsg",
					time: timestampArguments
				}, function(json, temp, temp, topic) {
					$("#msg").empty();
					$("#chatDiv, #chatForm").toggle();
					updateArguments(currentID, null, null);
				});
				break;
		case "Q":
			$.getJSON("../server/insertQuestionsJson.php",{
					debateId: currentID,
					statment: $("#msg").val(),
					description: $("#description").val(),
					user: $("#author").val(),
					agree: ($("#yes").is(':checked'))?'Y':'N',
					action: "postmsg",
					time: timestampStatments
				}, function(json) {
					$("#msg").empty();
					$("#chatDiv, #chatForm").toggle();
					updateStatments();
				});		
				break;
		default:
			alert("Unknown type");
	}
	
	return false;
	});
	$("form#save").submit( function(){
			$("input[name='data']").val($.toJSON(data));
		}
	);
	
	
	
		function requiredFieldValidator(value) {
			if (value == null || value == undefined || !value.length)
				return {valid:false, msg:"This is a required field"};
			else
				return {valid:true, msg:null};
		}
		
		var grid,
			editedRows = {},
			data = [],
			columns = [
				{ id: "user", name: "User", field: "user", width: 80, editor:TextCellEditor, sortable: true },
				{ id: "type", name: "Type", field: "type", width: 60, editor:TextCellEditor, sortable: true },
				{ id: "weight", name: "Weight", field: "weight", width: 80, editor:TextCellEditor, sortable: true },
				{id:"statment", name:"Argument", field:"statment", width:420, cssClass:"", sortable: true, editor:LongTextCellEditor, validator:requiredFieldValidator},
				{ id: "rate", name: "Rate", field: "rate", width: 140, editor:TextCellEditor, sortable: true }
			],
			options = {
				editable: true,
				enableAddRow: true,
				enableCellNavigation: true,
				asyncEditorLoading: false,
				autoHeight: true,
				autoEdit: false
			}, numberOfItems = 5, items = [], indices, isAsc = true, currentSortCol = { id: "weight" }, i;

		  
		// Define function used to get the data and sort it.
		function getItem(index) {
			return isAsc ? data[indices[currentSortCol.id][index]] : data[indices[currentSortCol.id][(data.length - 1) - index]];
		}
		function getLength() {
			return data.length;
		}

		function sortText(a, b) {
			var compA = $(a.statment).text().toUpperCase();
			var compB = $(b.statment).text().toUpperCase();
			return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
		}

		data.sort(sortText);
		for (i = getLength(); i-- > 0;) {
			items[i]= i; 
		}
	
		//indices = { weight: items, statment: items, rate: items, user: items, type: items  };
		grid = new Slick.Grid($("#messagewindowDiv"), data, columns, options);
			
			grid.onSort = function (sortCol, sortAsc) {
				currentSortCol = sortCol;
				isAsc = sortAsc;
				grid.render();
			};
			grid.onAddNewRow.subscribe(function(e, args) {
				var item = args.item;
				var column = args.column;
				grid.invalidateRow(data.length);
				data.push(item);
				grid.updateRowCount();
				grid.render();
			});
		
		function populateGrid(dataIn){
			data = dataIn;
			data.sort(sortText);
			grid.invalidateAllRows();
			grid = new Slick.Grid($("#messagewindowDiv"), data, columns, options);
				grid.onSort = function (sortCol, sortAsc) {
				currentSortCol = sortCol;
				isAsc = sortAsc;
				grid.render();
			};
			grid.onAddNewRow.subscribe(function(e, args) {
				var item = args.item;
				var column = args.column;
				grid.invalidateRow(data.length);
				data.push(item);
				grid.updateRowCount();
				grid.render();
			});
		}	
			
	
});
	
