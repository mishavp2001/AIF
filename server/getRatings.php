<?php
	require_once('ratingClass.php');
	$handler = new maxRatingHandler();
	
	if ((isset($_GET['max'])) && (isset($_GET['item']))) {
	  $item = isset($_GET['item']) ? $_GET['item'] : -1;
	  $type = isset($_GET['type']) ? $_GET['type'] : -1;
	  $max  = isset($_GET['max']) ? $_GET['max'] : -1;
	  echo $handler->displayRating($item,$max);
	  $curRate = $handler->getRating($item);
	  $numRatings = $handler->getTotalNumberOfRatings($item);
	  $returncontext = '<p class="rating-description">The actual rating is '.$curRate.' after '. $numRatings.' votes</p>'; 
	  $returncontext = $returncontext."<input class='".$type."' value='".$curRate."' type='hidden' />";
	  echo $returncontext;
	}

?>