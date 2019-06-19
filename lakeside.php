<?php

//Page Generation Start
$time  = microtime();
$time  = explode(' ', $time);
$time  = $time[1] + $time[0];
$start = $time;

?>
<html lang="en">
 <head>
   
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   
  <title>Lakeside Seat Stats</title>
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
    <li class="nav-item">
      <a class="nav-link" href="arena.php">Arena</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="lakeside.php">Lakeside</a>
    </li>
  </ul>
</nav>
<?php
//Curl Start
$ch = curl_init();

$url = "https://www.epiclan.co.uk/epic28/seating/lakeside";

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

$xpath = new DOMXPath($doc);
$available  = $xpath->query('//div/div[contains(@class, "seat_available")]');
$taken = $xpath->query('//div/div[contains(@class, "seat_taken")]');

$totalAvailable = $available->length + $taken->length;

$percentage = ($taken->length / $totalAvailable) * 100;

if($percentage == 100) {
	
	$percenttext = "100%(Full)";
} else {
	
	$percenttext = $percentage. "%";
}

echo "<center><p>";
echo "<h2><b>epic.28 Lakeside Seat Stats</b></h2>";

echo "<h5>Total Seats: " . $totalAvailable . "</br>";
echo "Seats Available: " . $available->length . "</br>";
echo "Seats Taken: " . $taken->length . "</br>";
echo "Percentage filled: " . $percenttext . "</h5></p>";
echo "<h5>*Please note that the total seats does not include staff seats.*</h5></p>";

echo "<div class='row'>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row A</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-A")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row B</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-B")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row C</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-C")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row D</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-D")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "</div>";

echo "<div class='row'>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row E</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-E")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row F</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-F")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row G</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-G")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row H</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-H")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "</div>";

echo "<div class='row'>";

echo "<div class='col'>";
echo "</div>";

echo "<div class='col'>";


echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row J</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-J")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";

echo "<table class='table table-striped table-sm'>";
echo"<thead class='thead-dark'>
      <tr>
        <th>Row K</th>
      </tr>
    </thead>
	<tbody>
      <tr>";
foreach ($xpath->query('//div[@class="seat_label" and contains(*, "LK-K")]') as $item) {
    echo "<td>" .$item->nodeValue. "</td>";
	echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='col'>";
echo "</div>";

echo "</div>";

echo "</center>";

?>
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