<?php
/**
 * Created by PhpStorm.
 * User: diwin
 * Date: 2017. 05. 14.
 * Time: 11:11
 */

namespace Problem;


class KingOperator implements Operator {

	/**
	 * @var array
	 */
	protected $x_steps = [-1,0,1];
	/**
	 * @var array
	 */
	protected $y_steps = [-1,0,1];

	/**
	 * KingOperator constructor.
	 */
	public function __construct() {
	}

	/**
	 * @param $x
	 * @param $y
	 *
	 * @return bool
	 */
	public function isValid( $x, $y ) {
		$validity = true;
		if(!in_array($x, $this->x_steps) || !in_array($y, $this->y_steps)){
			$validity = false;
		}

		if($x == 0 && $y == 0) {
			$validity = false;
		}

		return $validity;
	}

	/**
	 * @param State $state
	 *
	 * @return bool
	 */
	public function applyExpr( $state ) {
		return (abs($state->getKingRow()-$state->getHorseRow()) == 2 && abs($state->getKingCol()-$state->getHorseCol()) == 1) ||
		       (abs($state->getKingRow()-$state->getHorseRow()) == 1 && abs($state->getKingCol()-$state->getHorseCol()) == 2);
	}


	/**
	 * @param State $state
	 *
	 * @return array
	 */
	public function getPossibleSteps( $state ) {
		$possibles = [];
		for ($x=0; $x < 3; $x++) {
			for($y=0; $y <3; $y++) {
				$x_p = $this->x_steps[$x];
				$y_p = $this->y_steps[$y];
				if($x_p==0 && $y_p == 0) {
					continue;
				}
				$newState = new State($state->getKingRow(), $state->getKingCol(), $state->getHorseRow(), $state->getHorseCol());

				$newX = $newState->getKingRow() + $x_p;
				$newY = $newState->getKingCol() + $y_p;
				$newState->setKing($newX, $newY);

				if($newState->isState()) {
					array_push($possibles,(Object)array("x"=>$x_p, "y"=>$y_p));
				}

			}
		}

		return $possibles;
	}


	/**
	 * @param $x
	 * @param $y
	 * @param State $state
	 *
	 * @throws \Exception
	 */
	public function apply( $x, $y, $state ) {
		if(!(new State($state->getKingRow()+$x, $state->getKingCol()+$y, $state->getHorseRow(), $state->getHorseCol()))->isState()) {
			throw new \Exception("This step is not allowed");
		}
		$newX = $state->getKingRow() + $x;
		$newY = $state->getKingCol() + $y;
		$state->setKing($newX, $newY);
	}


}