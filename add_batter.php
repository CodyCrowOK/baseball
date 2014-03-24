<?php

$db = new PDO('mysql:host=localhost;dbname=baseball;charset=utf8', 'root', '');

if (htmlspecialchars($_GET["sent"])) {
	
	$_player = $_GET["player"];
	$_pa = $_GET["pa"];
	$_h = $_GET["h"];
	$_bb = $_GET["bb"];
	$_so = $_GET["so"];
	$_hbp = $_GET["hbp"];
	$_2b = $_GET["2b"];
	$_3b = $_GET["3b"];
	$_hr = $_GET["hr"];
	$_rbi = $_GET["rbi"];
	$_sac = $_GET["sac"];
	$_r = $_GET["r"];
	$_sb = $_GET["sb"];
	$_cs = $_GET["cs"];
	$_ob = $_GET["ob"];
	

	//Process player if it matches one already in the database.
	$stmt = $db->prepare('SELECT * FROM batting WHERE player = ?');
	
	if ($stmt->execute(array($_GET['player'])) && $stmt->rowCount()) {
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
}



?>

<h1>Add a Batter's Statistics</h1>
<form action="add_batter.php" method="get">
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
