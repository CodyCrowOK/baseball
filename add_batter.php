<?php

$db = new PDO('mysql:host=localhost;dbname=baseball;charset=utf8', 'root', '');

if (htmlspecialchars($_POST["sent"])) {
	
	//Anyone who says this is bad practice is a communist.
	$_player = 	trim($_POST["player"]);
	filter_var($_player, FILTER_SANITIZE_STRING);
	$_pa = 		trim($_POST["pa"]);
	if (!is_numeric($_pa)) goto not_numeric;
	$_h = 		trim($_POST["h"]);
	if (!is_numeric($_h)) goto not_numeric;
	$_bb = 		trim($_POST["bb"]);
	if (!is_numeric($_bb)) goto not_numeric;
	$_so = 		trim($_POST["so"]);
	if (!is_numeric($_so)) goto not_numeric;
	$_hbp = 	trim($_POST["hbp"]);
	if (!is_numeric($_hbp)) goto not_numeric;
	$_2b = 		trim($_POST["2b"]);
	if (!is_numeric($_2b)) goto not_numeric;
	$_3b = 		trim($_POST["3b"]);
	if (!is_numeric($_3b)) goto not_numeric;
	$_hr = 		trim($_POST["hr"]);
	if (!is_numeric($_hr)) goto not_numeric;
	$_rbi = 	trim($_POST["rbi"]);
	if (!is_numeric($_rbi)) goto not_numeric;
	$_sac = 	trim($_POST["sac"]);
	if (!is_numeric($_sac)) goto not_numeric;
	$_r = 		trim($_POST["r"]);
	if (!is_numeric($_r)) goto not_numeric;
	$_sb = 		trim($_POST["sb"]);
	if (!is_numeric($_sb)) goto not_numeric;
	$_cs = 		trim($_POST["cs"]);
	if (!is_numeric($_cs)) goto not_numeric;
	$_ob = 		trim($_POST["ob"]);
	if (!is_numeric($_ob)) goto not_numeric;
	

	//Process player if it matches one already in the database.
	$stmt = $db->prepare('SELECT * FROM batting WHERE player = ?');
	
	if ($stmt->execute(array($_player)) && $stmt->rowCount()) {
		while ($player = $stmt->fetch()) {
			$_pa += $player['pa'];
			$_h += $player['h'];
			$_bb += $player['bb'];
			$_so += $player['so'];
			$_hbp += $player['hbp'];
			$_2b += $player['2b'];
			$_3b += $player['3b'];
			$_hr += $player['hr'];
			$_rbi += $player['rbi'];
			$_sac += $player['sac'];
			$_r += $player['r'];
			$_sb += $player['sb'];
			$_cs += $player['cs'];
			$_ob += $player['ob'];
			
			$clearold = $db->prepare("DELETE FROM `batting` WHERE `player` = ? AND `pa` = ?");
			$clearold->execute(array($player['player'], $player['pa']));	
			
			
			$stmt2 = $db->prepare("INSERT INTO batting (player, pa, h, bb, so, hbp, 2b, 3b, hr, rbi, sac, r, sb, cs, ob) VALUES (:player, :pa, :h, :bb, :so, :hbp, :2b, :3b, :hr, :rbi, :sac, :r, :sb, :cs, :ob)");
			$stmt2->bindParam(':player', $_player);
			$stmt2->bindParam(':pa', $_pa);
			$stmt2->bindParam(':h', $_h);
			$stmt2->bindParam(':bb', $_bb);
			$stmt2->bindParam(':so', $_so);
			$stmt2->bindParam(':hbp', $_hbp);
			$stmt2->bindParam(':2b', $_2b);
			$stmt2->bindParam(':3b', $_3b);
			$stmt2->bindParam(':hr', $_hr);
			$stmt2->bindParam(':rbi', $_rbi);
			$stmt2->bindParam(':sac', $_sac);
			$stmt2->bindParam(':r', $_r);
			$stmt2->bindParam(':sb', $_sb);
			$stmt2->bindParam(':cs', $_cs);
			$stmt2->bindParam(':ob', $_ob);
			$stmt2->execute();
			echo "Existing.";
		}
	} else {
			$stmt2 = $db->prepare("INSERT INTO batting (player, pa, h, bb, so, hbp, 2b, 3b, hr, rbi, sac, r, sb, cs, ob) VALUES (:player, :pa, :h, :bb, :so, :hbp, :2b, :3b, :hr, :rbi, :sac, :r, :sb, :cs, :ob)");
			$stmt2->bindParam(':player', $_player);
			$stmt2->bindParam(':pa', $_pa);
			$stmt2->bindParam(':h', $_h);
			$stmt2->bindParam(':bb', $_bb);
			$stmt2->bindParam(':so', $_so);
			$stmt2->bindParam(':hbp', $_hbp);
			$stmt2->bindParam(':2b', $_2b);
			$stmt2->bindParam(':3b', $_3b);
			$stmt2->bindParam(':hr', $_hr);
			$stmt2->bindParam(':rbi', $_rbi);
			$stmt2->bindParam(':sac', $_sac);
			$stmt2->bindParam(':r', $_r);
			$stmt2->bindParam(':sb', $_sb);
			$stmt2->bindParam(':cs', $_cs);
			$stmt2->bindParam(':ob', $_ob);
			$stmt2->execute();
			echo "New Player";
	}
	echo "<br /><span style='color:#0a0;font-weight:900;text-size:18px;'>Player stats added.</span><br />";
	$success = 1;
	//Invalid Input was entered, apparently
	//xkcd.com/292
	not_numeric:
	if (!$success) echo "<br /><span style='color:#c00;font-weight:900;text-size:18px;'>Invalid player stats were entered. Check that all stats are entered and correct.</span><br />";
	//Do nothing...
}



?>

<h1>Add a Batter's Statistics</h1>
<form action="add_batter.php" method="post">
Player Name: <br />
<input type="text" name="player" /><br />
Plate Appearances: <br />
<input type="text" name="pa" /><br />
Hits: <br />
<input type="text" name="h" /><br />
Walks: <br />
<input type="text" name="bb" /><br />
Strikeouts: <br />
<input type="text" name="so" /><br />
Hit by Pitch: <br />
<input type="text" name="hbp" /><br />
Doubles: <br />
<input type="text" name="2b" /><br />
Triples: <br />
<input type="text" name="3b" /><br />
Homeruns: <br />
<input type="text" name="hr" /><br />
RBI: <br />
<input type="text" name="rbi" /><br />
Sacrifices: <br />
<input type="text" name="sac" /><br />
Runs: <br />
<input type="text" name="r" /><br />
Stolen Bases: <br />
<input type="text" name="sb" /><br />
Caught Stealing: <br />
<input type="text" name="cs" /><br />
Times on Base: <br />
<input type="text" name="ob" /><br />
<input type="hidden" name="sent" value="1" />
<input type="submit" />
</form>
