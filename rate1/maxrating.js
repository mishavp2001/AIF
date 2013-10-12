function showIt(item,i,j,max){
   var id;
   actualItem = item;
   
   // Show the selected boxes
   for (var x=1;x<=i;x++){
      id = item + "_" + x;
      document.getElementById(id).src = "style/images/b.gif";
   }
   
   // Display the not selected ones
   for (var x=i+1;x<=max;x++){
      id = item + "_" + x;
      if (x<=j) document.getElementById(id).src = "style/images/y.gif";
      else document.getElementById(id).src = "style/images/w.gif";
   }
}

function showOriginal(i,max){
   for (var x=1;x<=max;x++){
      id = actualItem + "_" + x;
      if (x<=i) document.getElementById(id).src = "style/images/y.gif";
      else document.getElementById(id).src = "style/images/w.gif";
   }
}

// Get the HTTP Object
function getHTTPObject(){
   if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
   else if (window.XMLHttpRequest) return new XMLHttpRequest();
   else {
      alert("Your browser does not support AJAX.");
      return null;
   }
}   

// Change the value of the outputText field
function setOutput(){
   var result;
   var data;
   var rating;
   var totalRates;
   var max;
   if(httpObject.readyState == 4){
      result = httpObject.responseText;
      data = result.split(':::');
      rating     = data[0];
      totalRates = data[1];
      max        = data[2];
      
      removeActions(Math.round(rating),max);
      updateTextRating(actualItem,rating,totalRates);
   }
}

function removeActions(rating,max){
      showOriginal(rating,max);
      var t;
      for (var x=1;x<=max;x++){
         id = actualItem + "_" + x;
         t = document.getElementById(id);
         t.onmouseover = null;
         t.onmouseout  = null;
         t.onclick     = null;
      }  
}

function updateTextRating(item,rating,total){
   var itemRating;
   var totalRating;
   var id;
   
   id = item + "_ir";
   itemRating = document.getElementById(id);
   id = item + "_tr";
   totalRating = document.getElementById(id);
   
   if (itemRating != null) itemRating.innerHTML = rating;
   if (totalRating != null) totalRating.innerHTML = total;
   
}

// Implement business logic
function submitRating(item,rate,max){
   httpObject = getHTTPObject();
   actualItem = item;
   if (httpObject != null) {
      httpObject.open("GET", "submitRating.php?item="+item+"&rating="+rate+"&max="+max, true);
      httpObject.send(null);
      httpObject.onreadystatechange = setOutput;
   }
}
 
var httpObject = null;
var actualItem = null;
