<?php

//Page Generation Start
$time  = microtime();
$time  = explode(' ', $time);
$time  = $time[1] + $time[0];
$start = $time;

//Curl Start
$ch = curl_init();

$url = "https://www.epiclan.co.uk/epic28/seating";

curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$output = curl_exec($ch);
curl_close($ch);
//Curl End

$doc = new DOMDocument();
$doc->loadHTML(htmlspecialchars($output));
$xpath = new DomXPath($doc);

libxml_use_internal_errors(TRUE);

$doc->loadHTML($output);
libxml_clear_errors(); //remove errors for yucky html

$xpath     = new DOMXPath($doc);
$available = $xpath->query('//div/div[contains(@class, "seat_available")]');
$taken     = $xpath->query('//div/div[contains(@class, "seat_taken")]');

$totalAvailable = $available->length + $taken->length;
$percentage     = ($taken->length / $totalAvailable) * 100;

if ($percentage == 100) {
    
    $percenttext = "100%(Full)";
} else {
    $percenttext = $percentage;
}

?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <title>Arena Seat Stats</title>
   </head>
   <body>
      <div class="container">
         </br>
         <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
            <a class="navbar-brand" href="#">epic.28</a>
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
               </li>
               <li class="nav-item active">
                  <a class="nav-link" href="arena.php">Arena</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="lakeside.php">Lakeside</a>
               </li>
            </ul>
         </nav>
         <center>
            <p>
            <h2><b>epic.28 Arena Seat Stats</b></h2>
            </br>
            <div class='container'>
               <div class='row'>
                  <div class='col'>
                     <h5>Total Seats: <?php echo $totalAvailable; ?></br></h5>
                  </div>
                  <div class='col'>
                     <h5>Seats Available: <?php echo $available->length; ?></br></h5>
                  </div>
                  <div class='col'>
                     <h5>Seats Taken: <?php echo $taken->length; ?></br></h5>
                  </div>
                  <div class='col'>
                     <h5>Percentage Sold: <?php echo $percenttext; ?></p></h5>
                  </div>
               </div>
            </div>
         </center>
      </div>
   </body>
</html>
<?php
//Page Generation End
$time       = microtime();
$time       = explode(' ', $time);
$time       = $time[1] + $time[0];
$finish     = $time;
$total_time = round(($finish - $start), 4);
echo '<center>Page generated in ' . $total_time . ' seconds.</center>';
?>