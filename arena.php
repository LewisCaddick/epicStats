<?php
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
$xpath = new DOMXPath($doc);

$available = $xpath->query('//div/div[contains(@class, "seat_available")]');
$taken = $xpath->query('//div/div[contains(@class, "seat_taken")]');
$totalAvailable = $available->length + $taken->length;
$percentage = ($taken->length / $totalAvailable) * 100;

if ($percentage == 100) {
    $percenttext = "100%(Full)";
} else {
    $percenttext = $percentage . "%";
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Arena Seat Stats</title>
	<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />
  </head>
  <body>
    <div class="container-fluid">
      
      <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <a class="navbar-brand" href="/">epic.28</a>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link disabled" href="arena.php">Arena</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="lakeside.php">Lakeside</a>
          </li>
        </ul>
      </nav>
      <center>
        <p>
        <div class="row">
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-left media-middle">
                                <i class="icon-pencil cyan font-large-2 float-xs-left"></i>
                            </div>
                            <div class="media-body text-xs-right">
                                <h4>Total Seats: <?php echo $totalAvailable; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-left media-middle">
                                <i class="icon-chat1 deep-orange font-large-2 float-xs-left"></i>
                            </div>
                            <div class="media-body text-xs-right">
                                <h4>Seats Available: <?php echo $available->length; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-left media-middle">
                                <i class="icon-trending_up teal font-large-2 float-xs-left"></i>
                            </div>
                            <div class="media-body text-xs-right">
                                <h4>Seats Taken: <?php echo $taken->length; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-left media-middle">
                                <i class="icon-map1 pink font-large-2 float-xs-left"></i>
                            </div>
                            <div class="media-body text-xs-right">
                                <h4>Percentage Sold: <?php echo $percenttext; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      </center>
    </div>
	<p>
    <div class='container-fluid'>
      <div class='row'>
        <div class='col'>
          <table class='table table-striped table-sm' cellspacing="0">
		  <thead class='thead-dark'>
              <tr>
                <th>Row A</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-A") and not(contains(text(), "AR-AA"))]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
	
	
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
	echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row B</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-B") and not(contains(text(), "AR-BB"))]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row C</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-C")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row D</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-D")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row E</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-E")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
      </div>
      <div class='row'>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row F</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-F")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row G</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-G")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row H</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-H")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row L</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-L")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row M</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-M")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
      </div>
	  <div class='row'>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row N</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-N")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row P</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-P")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row Q</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-Q")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row R</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-R")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row S</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-S")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
      </div>
	  <div class='row'>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row T</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-T")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row U</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-U")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row V</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-V")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row W</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-W")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row X</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-X")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
      </div>
	  <div class='row'>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row Y</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-Y")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row Z</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-Z")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row AA</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-AA")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
          <table class='table table-striped table-sm'>
            <thead class='thead-dark'>
              <tr>
                <th>Row BB</th>
				<th></th>
				<th></th>
              </tr>
            </thead>
            <thead class='thead'>
              <tr>
                <th>Seat</th>
				<th>Name</th>
				<th>Clan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
$infos = $xpath->query('//*[@class="seat_info"]/h4[contains(text(), "AR-BB")]');
foreach ($infos as $info) {
    $seat = $info->nodeValue;
    $name = $xpath->evaluate('string(./../p[2]/a)', $info) . $xpath->evaluate('string(./../p[2]/strong[1]/following-sibling::text()[1])', $info);
    $clan = $xpath->evaluate('string(./../p[2]/strong[2]/following-sibling::text()[1])', $info);
    echo "<td>" . $seat . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $clan . "</td>";
    echo "</tr>";
}
?> 
          </table>
        </div>
        <div class='col'>
        </div>
      </div>
      </center>
    </div>
  </body>
</html>