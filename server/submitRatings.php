<?php
	require_once('ratingClass.php');

   $handler = new maxRatingHandler();

   if ((isset($_GET['rating'])) && (isset($_GET['item']))) {
      $rate = isset($_GET['rating']) ? $_GET['rating'] : -1;
      $item = isset($_GET['item']) ? $_GET['item'] : -1;
      $max  = isset($_GET['max']) ? $_GET['max'] : -1;
      $handler->writeResult($item,$rate);
      echo $handler->getRating($item).":::"
           .$handler->getTotalNumberOfRatings($item).":::"
           .$max;
   }

?>