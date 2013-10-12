<link rel="stylesheet" href="../common/css/slick.grid.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="../common/css/smoothness/jquery-ui-1.8.2.custom.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="./examples.css" type="text/css" media="screen" charset="utf-8" />


<style>
	html,body { margin:0; padding:0; background-color:White; overflow:auto; }
	body { font:11px Helvetica,Arial,sans-serif; }
	#container { position:absolute; top:0; left:0; right:0; bottom:0; }
	#description { position:fixed; top:30px; right:30px; width:25em; background-color:beige; border:solid 1px gray; }
	#description h2 { padding-left:0.5em; }
</style>




<div id="container" style="width:800px;height:500px;"></div>

<script language="JavaScript" src="../common/js/lib/jquery-1.4.2.min.js"></script>
<script language="JavaScript" src="../common/js/lib/jquery.event.drag-2.0.min.js"></script>
<script language="JavaScript" src="../common/js/slick.editors.js"></script>
<script language="JavaScript" src="../common/js/slick.grid.js"></script>


<script>
	function requiredFieldValidator(value) {
		if (value == null || value == undefined || !value.length)
			return {valid:false, msg:"This is a required field"};
		else
			return {valid:true, msg:null};
	}

	var grid,
		data = [],
		columns = [
			{ id: "weight", name: "Weight", field: "weight", width: 80, editor:TextCellEditor, sortable: true },
			{id:"title", name:"Title", field:"title", width:320, cssClass:"cell-title", sortable: true, editor:TextCellEditor, validator:requiredFieldValidator},
			{ id: "rate", name: "Rate", field: "rate", width: 150, editor:TextCellEditor, sortable: true },
			{ id: "comments", name: "Comments", field: "comments", width: 250, editor:TextCellEditor, sortable: true }
		],
		options = {
			enableColumnReorder: false,
			editable: true,
			enableAddRow: true,
			enableCellNavigation: true,
			asyncEditorLoading: false
		}, numberOfItems = 10, items = [], indices, isAsc = true, currentSortCol = { id: "weight" }, i;


	function getData(items) {
		/// <summary>
		/// Copies and shuffles the specified array and returns a new shuffled array.
		/// </summary>
		var randomItems = $.extend(true, null, items), randomIndex, temp, index;
		for (index = items.length; index-- > 0;) {
			randomIndex = Math.round(Math.random() * items.length - 1);
			if (randomIndex > -1) {
				temp = randomItems[randomIndex];
				randomItems[randomIndex] = randomItems[index];
				randomItems[index] = temp;
			}
		}
		return randomItems;
	}

	
	
	/// Build the items and indices.
	for (i = numberOfItems; i-- > 0;) {
		items[i] = i;
		data[i] = {
			weight: "Task ".concat(i + 1)
		};
	}
	indices = { weight: items, title: getData(items), rate: getData(items), comments: getData(items) };

	// Assign values to the data.
	for (i = numberOfItems; i-- > 0;) {
		data[indices.title[i]].title = "Value ".concat(i + 1);
		data[indices.rate[i]].rate = "";
		data[indices.comments[i]].comments = "";
	}

	// Define function used to get the data and sort it.
	function getItem(index) {
		return isAsc ? data[indices[currentSortCol.id][index]] : data[indices[currentSortCol.id][(data.length - 1) - index]];
	}
	function getLength() {
		return data.length;
	}

	grid = new Slick.Grid($("#container"), {getLength: getLength, getItem: getItem}, columns, options);
	grid.onSort = function (sortCol, sortAsc) {
		currentSortCol = sortCol;
		isAsc = sortAsc;
		grid.removeAllRows();
		grid.render();
	};
</script>
