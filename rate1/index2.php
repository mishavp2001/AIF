<?php require_once('submitRating.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>Max's AJAX Rating</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Language" content="en" />
   <meta name="robots" content="index,follow" />
   <link rel="stylesheet" href="style/style.css" type="text/css" />
   <script language="javascript" type="text/javascript" src="maxrating.js"></script>
</head>
<body>
       <div id="container">
            <div id="header"><div id="header_left"></div>
            <div id="header_main">Max's AJAX Rating</div><div id="header_right"></div></div>
            <div id="content">
               <p align="center">Select your rating for this book: 
                  (
                     <?php 
                        echo $handler->displayRateValue('Book1');
                        echo " / ";
                        echo $handler->displayTotalNumberOfRatings('Book1'); 
                     ?>
                  )
               </p>
               <p class="ratingbox" align="center">
                  <?php $handler->displayRating('Book1',5); ?>
               </p><br/><br/><br/><hr size="1" /><br/>


               <p align="center">Select your rating for this car: 
                  (
                     <?php 
                        echo $handler->displayRateValue('Car1');
                        echo " / ";
                        echo $handler->displayTotalNumberOfRatings('Car1'); 
                     ?>
                  )
               </p>
               <p class="ratingbox" align="center">
                  <?php $handler->displayRating('Car1',5); ?>
               </p><br/><br/><br/><hr size="1" /><br/>


               <p align="center">Select your rating for this TV: 
                  (
                     <?php 
                        echo $handler->displayRateValue('TV1');
                        echo " / ";
                        echo $handler->displayTotalNumberOfRatings('TV1'); 
                     ?>
                  )
               </p>
               <p class="ratingbox" align="center">
                  <?php $handler->displayRating('TV1',5); ?>
               </p><br/><br/><br/>


               </div>
             <div id="footer"><a href="http://www.ajaxf1.com" target="_blank">Powered by AJAX F1</a></div>
         </div>
<p id="res"> </p>
</body>   
