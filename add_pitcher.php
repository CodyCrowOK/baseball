<?php

$db = new PDO('mysql:host=localhost;dbname=baseball;charset=utf8', 'root', '');

if (htmlspecialchars($_GET["sent"])) {
	
	$_player = $_GET["player"];
	$_w = $_GET["w"];
	$_l = $_GET["l"];
	$_ip = $_GET["ip"];
	$_h = $_GET["h"];
	$_bb = $_GET["bb"];
	$_hbp = $_GET["hbp"];
	$_er = $_GET["er"];
	$_k = $_GET["k"];
	$_g = $_GET["g"];
	$_s = $_GET["s"];
	$_bf = $_GET["bf"];
	

	//Process player if it matches one already in the database.
	$stmt = $db->prepare('SELECT * FROM pitching WHERE player = ?');
	
	if ($stmt->execute(array($_GET['player'])) && $stmt->rowCount()) {
		while ($player = $stmt->fetch()) {
			$_w += $player['w'];
			$_l += $player['l'];
			//$_ip += $player['ip'];
			//Handle Innings Pitched:
			$current_remainder = fmod($player['ip'], 1.0);
			$current_whole = $player['ip'] - $current_remainder;
			$new_remainder = fmod($_ip, 1.0);
			$new_whole = $_ip - $new_remainder;
			$total_whole = $current_whole + $new_whole;
			$extra_whole = (int)(($new_remainder + $current_remainder) / .3);
			$extra_remainder = fmod(($new_remainder + $current_remainder), .3);
			$_ip = $total_whole + $extra_whole + $extra_remainder;
			
			$_h += $player['h'];
			$_bb += $player['bb'];
			$_hbp += $player['hbp'];
			$_er += $player['er'];
			$_k += $player['k'];
			$_g += $player['g'];
			$_s += $player['s'];
			$_bf += $player['bf'];
			
			$clearold = $db->prepare("DELETE FROM `pitching` WHERE `player` = ? AND `bf` = ?");
			$clearold->execute(array($player['player'], $player['bf']));	
			
			
			$stmt2 = $db->prepare("INSERT INTO pitching (player, w, l, ip, h, bb, hbp, er, k, g, s, bf) VALUES (:player, :w, :l, :ip, :h, :bb, :hbp, :er, :k, :g, :s, :bf)");
			$stmt2->bindParam(':player', $_player);
			$stmt2->bindParam(':w', $_w);
			$stmt2->bindParam(':l', $_l);
			$stmt2->bindParam(':ip', $_ip);
			$stmt2->bindParam(':h', $_h);
			$stmt2->bindParam(':bb', $_bb);
			$stmt2->bindParam(':hbp', $_hbp);
			$stmt2->bindParam(':er', $_er);
			$stmt2->bindParam(':k', $_k);
			$stmt2->bindParam(':g', $_g);
			$stmt2->bindParam(':s', $_s);
			$stmt2->bindParam(':bf', $_bf);
			$stmt2->execute();
			echo "Existing.";
		}
	} else {
			$stmt2 = $db->prepare("INSERT INTO pitching (player, w, l, ip, h, bb, hbp, er, k, g, s, bf) VALUES (:player, :w, :l, :ip, :h, :bb, :hbp, :er, :k, :g, :s, :bf)");
			$stmt2->bindParam(':player', $_player);
			$stmt2->bindParam(':w', $_w);
			$stmt2->bindParam(':l', $_l);
			$stmt2->bindParam(':ip', $_ip);
			$stmt2->bindParam(':h', $_h);
			$stmt2->bindParam(':bb', $_bb);
			$stmt2->bindParam(':hbp', $_hbp);
			$stmt2->bindParam(':er', $_er);
			$stmt2->bindParam(':k', $_k);
			$stmt2->bindParam(':g', $_g);
			$stmt2->bindParam(':s', $_s);
			$stmt2->bindParam(':bf', $_bf);
			$stmt2->execute();
			echo "New Player";
	}
	echo "<br /><span style='color:#0a0;font-weight:900;text-size:18px;'>Player stats added.</span><br />";
}



?>
<h1>Add a Pitcher's Statistics</h1>
<form action="add_pitcher.php" method="get">
Player Name: <br />
<input type="text" name="player" /><br />
Wins: <br />
<input type="text" name="w" /><br />
Losses: <br />
<input type="text" name="l" /><br />
Innings Pitched: <br />
<input type="text" name="ip" /><br />
Hits Allowed: <br />
<input type="text" name="h" /><br />
Walks: <br />
<input type="text" name="bb" /><br />
Hit Batsmen: <br />
<input type="text" name="hbp" /><br />
Earned Runs: <br />
<input type="text" name="er" /><br />
Strikeouts: <br />
<input type="text" name="k" /><br />
Games: <br />
<input type="text" name="g" /><br />
Saves: <br />
<input type="text" name="s" /><br />
Batters Faced: <br />
<input type="text" name="bf" /><br />
<input type="hidden" name="sent" value="1" />
<input type="submit" />
</form>

