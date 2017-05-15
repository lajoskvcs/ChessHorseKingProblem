<style>
	table {
		border: 1px solid black;
	}
	td {
		width: 50px;
		height: 50px;
		vertical-align: middle;
	}

	div.content {
		width: 100%;
	}

	div.table {
		width:436px;
		float:left;
	}

	a.button {
		text-decoration: none;
		border: 1px solid black;
		padding: 4px;
		color: black;
		margin: 0.5px;
	}
</style>

<?php


include("vendor/autoload.php");

$king = new \Problem\KingOperator();
$horse = new \Problem\HorseOperator();


session_start();
if(isset($_SESSION['state']) && !isset($_GET['new'])) {
	$previous_state = $_SESSION['previous_state'];
	$state = $_SESSION['state'];
	$curve = $_SESSION['curve'];
} else {
	$previous_state = new \Problem\State(6,2,6,3);

	$state = new \Problem\State(6,2,6,3);
	$curve = [];
}

if(isset($_GET['op'])) {
	$x = $_GET['x'];
	$y = $_GET['y'];
	switch($_GET['op']) {
		case "king":
			$previous_state = clone $state;
			$king->apply($x, $y, $state);
			array_push($curve,
				(Object)array(
					"type" => "King",
					"x" => $x,
					"y" => $y
				)
			);
			break;
		case "horse":
			$previous_state = clone $state;
			$horse->apply($x, $y, $state);
			array_push($curve,
				(Object)array(
					"type" => "Horse",
					"x" => $x,
					"y" => $y
				)
			);
			break;
		case "reverse":
			$state = $previous_state;
			array_pop($curve);
			break;
		default:
			echo "not available operator..";
			break;
	}
}

$_SESSION['state'] = $state;
$_SESSION['previous_state'] = $previous_state;
$_SESSION['curve'] = $curve;

if($state->isGoalState()) {
	echo "<h1>GRATULÁLOK! ELÉRTED A CÉLT!!!</h1><br>";
}

echo "<div class='content'>";
echo "<div class='table'>";

$state->printTable();

echo "</div>";

echo "</div>";


echo "<a class='button' href='?new'>Új</a>";
echo "<br>";
echo "<br>";
echo "<br>";

echo "Eddig alkalamzott operátorok: <br>";
foreach ($curve as $op) {
	echo "$op->type{x: $op->x, y: $op->y} ";
}

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
if(!$state->isGoalState()) {
	if(!$king->applyExpr($state) && !$horse->applyExpr($state)) {
		echo "Hoppá! Nincs használható operátor. <br>";
		echo "<a class='button' href='?op=reverse&x=0&y=0'>Vissza</a>";
		echo "<br>";
	}
	echo "Király operátor: <br>";

	echo "Alkalmazható: "; echo ($king->applyExpr($state))?"Igen":"Nem";
	echo "<br>";
	echo ($king->applyExpr($state))?"Lehetséges lépések: ":"";
	if($king->applyExpr($state)) {
		foreach($state->getOperatorSteps($king) as $step) {
			echo "<a class='button' href='?op=king&x=$step->x&y=$step->y'>K{x: ".($state->getKingRow() + $step->x).", y: ".($state->getKingCol() + $step->y)."}</a>";
		}
	}
	echo "<br>";
	echo "<br>";
	echo "Ló operátor: <br>";
	echo "Alkalmazható: "; echo ($horse->applyExpr($state))?"Igen":"Nem";
	echo "<br>";
	echo ($horse->applyExpr($state))? "Alkalamzható operátorok: ":"";
	if($horse->applyExpr($state)) {
		foreach($state->getOperatorSteps($horse) as $step) {
			echo "<a class='button' href='?op=horse&x=$step->x&y=$step->y'>H{x: ".($state->getHorseRow() + $step->x).", y: ".($state->getHorseCol() + $step->y)."}</a>";
		}
	}

	echo "<br>";
}
