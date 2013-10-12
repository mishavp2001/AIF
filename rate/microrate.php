<?php
/*************************************************
 * Micro Rate
 *
 * Version: 1.0
 * Date: 2007-07-17
 *
 ****************************************************/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
   <title>Micro Rate</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div id="main">
    <div id="caption">Micro Rate</div>
    <div id="icon">&nbsp;</div>
    
    <?php if ( (!isset($_POST['submit'])) ) { ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <table width="100%">
              <tr><td>Your rating:</td><td><select name="rate">
              <?php for ($i = 1; $i <= 10; $i++) { echo "<option value=\"$i\">$i</option>"; } ?>
      </select></td></tr>
              <tr><td colspan="2" align="center"><input type="submit" value="Rate it!" name="submit"/></td></tr>
            </table>
       </form> 
       <?php } else  { 
            $rate = isset ($_POST['rate']) ? $_POST['rate'] : 0;
            $filename = "ratings";
            $alreadyRated = false;
            $totalRates = 0;
            $totalPoints = 0;
                        
            $ip = getenv('REMOTE_ADDR');
            $oldResults = file('results/'.$filename.'.txt');
            foreach ($oldResults as $value) {
            	$oneRate = explode(':',$value);
            	if ($ip == $oneRate[0]) $alreadyRated = true;	   
            	$totalRates++;
            	$totalPoints += $oneRate[1];
            }

            if ((!$alreadyRated) && ($rate > 0)){            
               $f = fopen('results/'.$filename.".txt","a+");         
               fwrite($f,$ip.':'.$rate."\n");
               fclose($f);
               $totalRates++;
               $totalPoints+=$rate;
            }
            
?>           
      <div id="result">
       
<?php  
       echo "Actual rating from $totalRates rates is: ".substr(($totalPoints/$totalRates),0,3)."<br/>";
       for ($i=0;$i<round(($totalPoints/$totalRates),0);$i++){
          echo "<img src='style/star.png' alt='s' />";
       }
echo "</div>";       
       } ?>        
	<div id="source">Micro Rate 1.0</div>
  </div>
</body>   
