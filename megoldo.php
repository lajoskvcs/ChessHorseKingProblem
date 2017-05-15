<style>
	table {
		float: left;
	}
</style>

<?php
include("vendor/autoload.php");

use Problem\HorseOperator;
use Problem\KingOperator;
use Problem\State;

$horse = new HorseOperator();
$king = new KingOperator();


if(isset($_POST['curve'])) {
	$curve = json_decode($_POST['curve']);
	$state = new State(6,2,6,3);
	$state->printTable();
	foreach ($curve as $step) {
		switch($step->type) {
			case "H":
				$horse->apply($step->x, $step->y, $state);
				break;
			case "K":
				$king->apply($step->x, $step->y, $state);
				break;
			default:
				break;
		}
		$state->printTable();

	}
} else {
	echo "<form method='POST' action=''>";
		echo "<textarea name='curve'></textarea>";
		echo "<input type='submit' value='Elküld' />";
	echo "</form>";
}