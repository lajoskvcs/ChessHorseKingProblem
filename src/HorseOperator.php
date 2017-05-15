<?php
/**
 * Created by PhpStorm.
 * User: diwin
 * Date: 2017. 05. 14.
 * Time: 12:06
 */

namespace Problem;


class HorseOperator implements Operator {

	/**
	 * @var array
	 */
	protected $x_steps = [-2, -1,1,2];
	/**
	 * @var array
	 */
	protected $y_steps = [-2, -1,1,2];

	/**
	 * HorseOperator constructor.
	 */
	public function __construct() {}


	public function isValid( $x, $y ) {

		return (in_array($x, $this->x_steps) && in_array($y, $this->y_steps) && ((abs($x) == 2 && abs($y) == 1)||(abs($x) == 1 && abs($y) == 2)));
	}

	public function applyExpr( $state ) {
		$x_length = abs($state->getKingRow()-$state->getHorseRow());
		$y_length = abs($state->getKingCol()-$state->getHorseCol());
		return ( $x_length == 1 || $y_length == 1) && $x_length < 2 && $y_length < 2;
	}

	public function getPossibleSteps( $state ) {
		$possibles = [];
		for ($x=0; $x < 4; $x++) {
			for($y=0; $y <4; $y++) {
				$x_p = $this->x_steps[$x];
				$y_p = $this->y_steps[$y];
				if(!$this->isValid($x_p, $y_p)) {
					continue;
				}

				$newState = new State($state->getKingRow(), $state->getKingCol(), $state->getHorseRow()+$x_p, $state->getHorseCol()+$y_p);
				if($newState->isState()) {
					array_push($possibles,(Object)array(
						"x"=>$x_p,
						"y"=>$y_p
					));
				}


			}
		}

		return $possibles;
	}

	public function apply( $x, $y, $state ) {
		if(!(new State($state->getKingRow(), $state->getKingCol(), $state->getHorseRow()+$x, $state->getHorseCol()+$y))->isState()) {
			throw new \Exception("This step is not allowed");
		}
		$newX = $state->getHorseRow() + $x;
		$newY = $state->getHorseCol() + $y;
		$state->setHorse($newX, $newY);
	}

}