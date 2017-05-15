<?php
/**
 * Created by PhpStorm.
 * User: diwin
 * Date: 2017. 05. 14.
 * Time: 12:00
 */

namespace Problem;


interface Operator {
	/**
	 * @param $x
	 * @param $y
	 *
	 * @return mixed
	 */
	public function isValid( $x, $y );

	/**
	 * @param State $state
	 *
	 * @return mixed
	 */
	public function applyExpr( $state );

	/**
	 * @param State $state
	 *
	 * @return mixed
	 */
	public function getPossibleSteps( $state );

	/**
	 * @param $x
	 * @param $y
	 * @param State $state
	 *
	 * @return mixed
	 */
	public function apply( $x, $y, $state );
}