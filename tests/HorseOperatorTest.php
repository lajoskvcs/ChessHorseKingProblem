<?php

//include("../vendor/autoload.php");
/**
 * Created by PhpStorm.
 * User: diwin
 * Date: 2017. 05. 14.
 * Time: 17:23
 */

use Problem\HorseOperator;
use PHPUnit\Framework\TestCase;

class HorseOperatorTest extends TestCase {

	public function applyShouldMakePossibleClass() {
		$state = new \Problem\State(6,2,6,3);
		$horse = new HorseOperator();
		$horse->apply(1,-2, $state);
		$horse->apply(-2,1, $state);

	}


}
