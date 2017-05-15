<?php
include ("vendor/autoload.php");

use \Problem\State;

/**
 * @param State $state
 */
function korfigyeleses_backtrack($state) {
	$king = new \Problem\KingOperator();
	$horse = new \Problem\HorseOperator();

	$aktualis = (new State($state->getKingRow(), $state->getKingCol(), $state->getHorseRow(), $state->getHorseCol()));

	$ops = [];
	$allapot = [];
	$szulo = [];
	$operator = [];
	$alkalmazhato_k = [];
	$alkalmazhato_h = [];

	$allapot[$aktualis->getHash()] = $state;
	$szulo[$aktualis->getHash()] = null;
	$operator[$aktualis->getHash()] = [];


	$alkalmazhato_k[$aktualis->getHash()] = $aktualis->getOperatorSteps($king);
	$alkalmazhato_h[$aktualis->getHash()] = $aktualis->getOperatorSteps($horse);
	$counter = 0;
	while (true) {
		//echo $aktualis->printTable();

		if($aktualis == null) {
			break;
		}

		if($allapot[$aktualis->getHash()]->isGoalState()) {
			break;
		}

		if(isset($allapot[$aktualis->getHash()]) && $counter != 0) {
			/**
			 * @var $toClone State
			 */
		    //$toClone = $szulo[$aktualis->getHash()];
		    //$aktualis = (new State($toClone->getKingRow(), $toClone->getKingCol(), $toClone->getHorseRow(), $toClone->getHorseCol()));
		}

		if($horse->applyExpr($aktualis) && count($alkalmazhato_h[$aktualis->getHash()]) != 0) {
			$key = array_rand($alkalmazhato_h[$aktualis->getHash()]);

			$op = $alkalmazhato_h[$aktualis->getHash()][$key];



			unset($alkalmazhato_h[$aktualis->getHash()][array_search($op, $alkalmazhato_h[$aktualis->getHash()])]);
			/**
			 * @var $uj State
			 */
			$uj = (new State($aktualis->getKingRow(), $aktualis->getKingCol(), $aktualis->getHorseRow(), $aktualis->getHorseCol()));

			$horse->apply($op->x,$op->y, $uj);

			$allapot[$uj->getHash()] = (new State($uj->getKingRow(), $uj->getKingCol(), $uj->getHorseRow(), $uj->getHorseCol()));
			$szulo[$uj->getHash()] = (new State($aktualis->getKingRow(), $aktualis->getKingCol(), $aktualis->getHorseRow(), $aktualis->getHorseCol()));
			$operator[$uj->getHash()] = (Object)array("type"=>"H", "x" => $op->x, "y" => $op->y);
			$alkalmazhato_h[$uj->getHash()] = $uj->getOperatorSteps($horse);
			$alkalmazhato_k[$uj->getHash()] = $uj->getOperatorSteps($king);
			$aktualis = (new State($uj->getKingRow(), $uj->getKingCol(), $uj->getHorseRow(), $uj->getHorseCol()));
			$ops[] = $operator[$aktualis->getHash()];
		} elseif($king->applyExpr($aktualis) && count($alkalmazhato_k[$aktualis->getHash()]) != 0) {
			$op = $alkalmazhato_k[$aktualis->getHash()][array_rand($alkalmazhato_k[$aktualis->getHash()])];

			unset($alkalmazhato_k[$aktualis->getHash()][array_search($op, $alkalmazhato_k[$aktualis->getHash()])]);


			/**
			 * @var $uj State
			 */
			$uj = (new State($aktualis->getKingRow(), $aktualis->getKingCol(), $aktualis->getHorseRow(), $aktualis->getHorseCol()));
            $king->apply($op->x,$op->y, $uj);
			$allapot[$uj->getHash()] = (new State($uj->getKingRow(), $uj->getKingCol(), $uj->getHorseRow(), $uj->getHorseCol()));
			$szulo[$uj->getHash()] = (new State($aktualis->getKingRow(), $aktualis->getKingCol(), $aktualis->getHorseRow(), $aktualis->getHorseCol()));
			$operator[$uj->getHash()] = (Object)array("type"=>"K", "x" => $op->x, "y" => $op->y);
			$alkalmazhato_h[$uj->getHash()] = $uj->getOperatorSteps($horse);
			$alkalmazhato_k[$uj->getHash()] = $uj->getOperatorSteps($king);
			$aktualis = (new State($uj->getKingRow(), $uj->getKingCol(), $uj->getHorseRow(), $uj->getHorseCol()));
			$ops[] = $operator[$aktualis->getHash()];
		} else {
			array_pop($ops);
			/**
			 * @var $toClone State
			 */
		    $toClone =$szulo[$aktualis->getHash()];

			$aktualis = (new State($toClone->getKingRow(), $toClone->getKingCol(), $toClone->getHorseRow(), $toClone->getHorseCol()));
		}
		$counter++;
	}

	if($aktualis->isGoalState()) {
		echo json_encode($ops);
		echo "Juhé!\n";
	} else {
		echo "Nincs megoldás!!!\n";
	}

}

function kiir_op($operator) {

        echo "Type: ".$operator->type." X: ".$operator->x." Y: ".$operator->y. " \n";
}

$state = new \Problem\State(6,2,6,3);


korfigyeleses_backtrack($state);