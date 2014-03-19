<?php


$db = new PDO('mysql:host=localhost;dbname=baseball;charset=utf8', 'root', '');

echo "
<h1>Comanche Statistics</h1>
<h2>Batting Statistics</h2>
<table>
	<thead>";

echo "<tr style='text-decoration:underline;'>";
	echo "<td>Player Name</td>";
	echo "<td>OBP</td>";
	echo "<td>AVG</td>";
	echo "<td>SLG</td>";
	echo "<td>OPS</td>";
	echo "<td>Runs Created</td>";
	echo "<td>PA</td>";
	echo "<td>Hits</td>";
	echo "<td>Walks</td>";
	echo "<td>Strikeouts</td>";
	echo "<td>Total Bases</td>";
	echo "<td>HBP</td>";
	echo "<td>2B</td>";
	echo "<td>3B</td>";
	echo "<td>HR</td>";
	echo "<td>RBI</td>";
	echo "<td>Sacrifices</td>";
	echo "<td>Runs</td>";
	echo "<td>SB</td>";
	echo "<td>CS</td>";
	echo "<td>Stolen Base %</td>";
	echo "<td>Times on Base</td>";
	echo "</tr>";

echo"
	</thead>
";

foreach($db->query('SELECT * FROM `batting` ORDER BY `pa` DESC') as $player) {
	//Calculations
	
	//OBP = OB / PA
	$obp = ($player['ob']) / $player['pa'];
	
	//At Bats
	$ab = $player['pa'] - ($player['bb'] + $player['hbp'] + $player['sac']);
	
	//Batting Avg = Hits / At Bats
	$avg = $player['h'] / $ab;
	
	//Total Bases = (1*1B + 2*2B + 3*3B + 4*HR);
	$tb = ($player['h'] - ($player['2b'] + $player['3b'] + $player['hr'])) + (2 * $player['2b']) + (3 * $player['3b']) + (4 * $player['hr']); 
	
	//Slugging Percentage = Total Bases / At Bats
	$slg = $tb / $ab;
	
	//OPS = On Base Percentage + Slugging Percentage
	$ops = $obp + $slg;
	
	//Runs Created = (Hits + BB)(Total Bases) / (AB + BB)
	//$rc = ($player['h'] + $player['bb']) / ($ab + $player['bb']);
	$rca = $player['h'] + $player['bb'] - $player['cs'] + $player['hbp'];
	$rcb = (1.125 * ($player['h'] - ($player['2b'] + $player['3b'] + $player['hr']))) + (1.69 * $player['2b']) + (3.02 * $player['3b']) + (3.73 * $player['hr']) + (.29 * ($player['bb'] + $player['hbp'])) + (.492 * ($player['sac'] + $player['sb'])) - (.04 * $player['so']);
	$rcc = $ab + $player['bb'] + $player['hbp'] + $player['sac'];
	$rc = (((2.4 * $rcc + $rca) * (3 * $rcc + $rcb)) / (9 * $rcc)) - (.9 * $rcc);
	
	//Stolen Base Percentage = SB / (SB + CS)
	$sbp = $player['sb'] / ($player['sb'] + $player['cs']);
	
	
	echo "<tr>";
	echo "<td>" . $player['player'] . "</td>";
	echo "<td>";
	printf("%.3f <br />", $obp); //OBP to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $avg); //AVG to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $slg); //SLG to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $ops); //OPS to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $rc); //RC to three decimal places
	echo "</td>";
	echo "<td>" . $player['pa'] . "</td>";
	echo "<td>" . $player['h'] . "</td>";
	echo "<td>" . $player['bb'] . "</td>";
	echo "<td>" . $player['so'] . "</td>";
	echo "<td>" . $tb . "</td>";
	echo "<td>" . $player['hbp'] . "</td>";
	echo "<td>" . $player['2b'] . "</td>";
	echo "<td>" . $player['3b'] . "</td>";
	echo "<td>" . $player['hr'] . "</td>";
	echo "<td>" . $player['rbi'] . "</td>";
	echo "<td>" . $player['sac'] . "</td>";
	echo "<td>" . $player['r'] . "</td>";
	echo "<td>" . $player['sb'] . "</td>";
	echo "<td>" . $player['cs'] . "</td>";
	echo "<td>";
	printf("%.3f <br />", $sbp); //SBP to three decimal places
	echo "</td>";
	echo "<td>" . $player['ob'] . "</td>";
	echo "</tr>";
}

echo "</table>";

echo "<h2>Pitching Statistics</h2>";

echo "<table>";
echo "<thead>";
		echo "<tr style='text-decoration:underline;'>";
	echo "<td>Player Name</td>";
	echo "<td>ERA</td>";
	echo "<td>Wins</td>";
	echo "<td>Losses</td>";
	echo "<td>Innings Pitched</td>";
	echo "<td>WHIP</td>";
	echo "<td>W-L %</td>";
	echo "<td>H/7</td>";
	echo "<td>BB/7</td>";
	echo "<td>SO/7</td>";
	echo "<td>SO/BB</td>";
	echo "<td>Hits Allowed</td>";
	echo "<td>Walks</td>";
	echo "<td>Hit Batsmen</td>";
	echo "<td>Earned Runs</td>";
	echo "<td>Strikeouts</td>";
	echo "<td>Games</td>";
	echo "<td>Saves</td>";
	echo "<td>Batters Faced</td>";
	echo "</tr>";
echo "</thead>";


foreach($db->query('SELECT * FROM `pitching` ORDER BY `ip` DESC') as $player) {
	//Calculations
	
	//Earned Run Average = (Earned Runs / IP) * 7
	$era = $player['er'] / $player['ip'] * 7.0;
	
	//Walks & Hits per Innings Pitched = (BB + H)/IP
	$whip = ($player['bb'] + $player['h']) / $player['ip'];
	
	//Win-loss Percentage = Wins / Decisions
	$wlpercentage = $player['w'] / ($player['l'] + $player['w']);
	
	//Hits per 7 = 7 * (H / IP)
	$h7 = 7 * ($player['h'] / $player['ip']);
	
	//Walks per 7 = 7 * (BB/IP)
	$bb7 = 7 * ($player['bb'] / $player['ip']);
	
	//Strikeouts per 7 = 7 * (k / ip);
	$so7 = 7 * ($player['k'] / $player['ip']);
	
	//Strikeouts / Walks
	$sobb = $player['k'] / $player['bb'];
	
		echo "<tr>";
	echo "<td>" . $player['player'] . "</td>";
	echo "<td>";
	printf("%.3f <br />", $era); //ERA to three decimal places
	echo "</td>";
	echo "<td>" . $player['w'] . "</td>";
	echo "<td>" . $player['l'] . "</td>";
	echo "<td>" . $player['ip'] . "</td>";
	echo "<td>";
	printf("%.3f <br />", $whip); //WHIP to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $wlpercentage); //W-L% to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $h7); //H/7 to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $bb7); //BB/7 to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $so7); //SO/7 to three decimal places
	echo "</td>";
	echo "<td>";
	printf("%.3f <br />", $sobb); //SO/BB to three decimal places
	echo "</td>";
	echo "<td>" . $player['h'] . "</td>";
	echo "<td>" . $player['bb'] . "</td>";
	echo "<td>" . $player['hbp'] . "</td>";
	echo "<td>" . $player['er'] . "</td>";
	echo "<td>" . $player['k'] . "</td>";
	echo "<td>" . $player['g'] . "</td>";
	echo "<td>" . $player['s'] . "</td>";
	echo "<td>" . $player['bf'] . "</td>";
	echo "</tr>";
}

echo "</table>";

?>
