/**************************************************************
 *           M A X   A J A X   R A T I N G              
 *       
 * Script name: Max's Ajax Rating
 * 
 * Version: 1.0
 * Release date: 2008-02-15
 *
 * Warranty: No warranty use it for your own risk.
 *
 ***************************************************************/ 

Install Max's Ajax Rating:

1. Import submitRating.php at the beginning of your file
      require_once('submitRating.php'); 
2. Import maxrating.js in the head section of your page
      <script language="javascript" type="text/javascript" src="maxrating.js"></script>   
3. Call displayRating function of the handler class with an identifier and the value of the rate maximum.
      <?php $handler->displayRating('Book1',5); ?>
   If you want more rating on one page please take care to use unique identifiers.
4. You can display the actual rating points in textual format by using the displayRateValue function
      with the identifier as parameter.
      <?php echo $handler->displayRateValue('Book1'); ?>
   Similar to this you also can display the number of total votes until now with displayTotalNumberOfRatings function.
      <?php echo $handler->displayTotalNumberOfRatings('Book1'); ?>

See index.php for a single rating and index2.php for more rating on one page example.      
