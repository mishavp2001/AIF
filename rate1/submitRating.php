<?php
   class maxRatingHandler {

      var $RATES_RESULT_FILE = "results.txt";
      
      /**
       * This function reads all relevant rates for the given item
       *
       * @param string $item : The name of the item we are looking for.
       * @return array : An array of the relevant ips and rates
       */
      function readRatingList($item) {
         $i = 0;
         $output = array();
         
         // Convert item value to lowercase to make it case insensitive
         $item = strtolower($item);

         // Open the file contains the ratings until now
         $fileContent = @file($this->RATES_RESULT_FILE);
         
         // Check if there is at least 1 record
         if (sizeof($fileContent) > 0){
            
            // Analyze the records one by one
            foreach ($fileContent as $line) {
               
               // Split the actual record into parts
            	$itemData = explode(':::',$line);
            	
            	// Check if all 3 parameter exists
            	if (sizeof($itemData) == 3) {
            	   
            	   //Get the item name in lowercase
            	   $actItem = strtolower($itemData[0]);
            	   
            	   // Check if the actual item from the file is the same as the  
            	   // the item we are looking for
            	   if ($actItem == $item){
            	      
            	      // Add the item to the output array
            	      $output[$i]['ip']   = $itemData[1];
            	      $output[$i]['rate'] = $itemData[2];
            	      $i++;
            	   }
            	}
            }
         }

         return $output;
      }
      
      function getTotalNumberOfRatings($item){
         $data = $this->readRatingList($item);
         return sizeof($data);
      }
      
      function getTotalPoints($item){
         $total = 0;
         
         $data = $this->readRatingList($item);
         foreach ($data as $value) {
            $total += $value['rate'];	
         }
         
         return $total;
      }
      
      function getRating($item){
         $totalRatings = $this->getTotalNumberOfRatings($item);
         $totalPoints  = $this->getTotalPoints($item);
         if ($totalRatings == 0) $rating = 0;
         else $rating = round(($totalPoints / $totalRatings),2);
         
         return $rating;
      }
      
      function displayRateValue($item){
         $rating = $this->getRating($item);
         echo '<span id="'.$item.'_ir">'.$rating.'</span>';
      }
      
      function displayTotalNumberOfRatings($item){
         $total = $this->getTotalNumberOfRatings($item);
         echo '<span id="'.$item.'_tr">'.$total.'</span>';
      }
      
      function isAlreadyRated($item){
         $result = false;
         $ip     = getenv('REMOTE_ADDR'); 
         $ip = 1;
         
         $data = $this->readRatingList($item);
         foreach ($data as $value) {
            if ($ip == $value['ip']) {
               $result = true;
               break;
            }
         }
         
         return $result;
      }
      
      function writeResult($item,$rate){
         $ip     = getenv('REMOTE_ADDR'); 

         $f = fopen($this->RATES_RESULT_FILE,"a+");   
         if ($f != null) {      
            fwrite($f,$item.':::'.$ip.':::'.$rate."\n");
            fclose($f);
         }
      }
      
      function displayRating($item,$max){
         $alreadyRated = $this->isAlreadyRated($item);
         $totalRatings = $this->getTotalNumberOfRatings($item);
         $totalPoints  = $this->getTotalPoints($item);
         if ($totalRatings == 0) $rating = 0;
         else $rating = round(($totalPoints / $totalRatings));

         // Set JavaScript variables
         
         
         for($i=1;$i<=$rating;$i++){
            echo '<img src="style/images/y.gif" alt="'.$i.'" id="'.$item.'_'.$i.'"';
            
            // If not rated yet then add JavaScript effects
            if (!$alreadyRated){
               echo ' onmouseover="showIt(\''.$item.'\','.$i.','.$rating.','.$max.');"';
               echo ' onmouseout="showOriginal('.$rating.','.$max.');"';
               echo ' onclick="submitRating(\''.$item.'\','.$i.','.$max.');"';   
            }
            
            echo ' />';
         }
         
         for($i=$rating+1;$i<=$max;$i++){
            echo '<img src="style/images/w.gif" alt="'.$i.'" id="'.$item.'_'.$i.'"';
            
            // If not rated yet then add JavaScript effects
            if (!$alreadyRated){
               echo ' onmouseover="showIt(\''.$item.'\','.$i.','.$rating.','.$max.');"';
               echo ' onmouseout="showOriginal('.$rating.','.$max.');"';
               echo ' onclick="submitRating(\''.$item.'\','.$i.','.$max.');"';   
            }
            
            echo ' />';
         }         
      }
   }

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