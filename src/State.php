<?php
/**
 * Created by PhpStorm.
 * User: diwin
 * Date: 2017. 05. 14.
 * Time: 10:46
 */

namespace Problem;



class State {
	/**
	 * @var int
	 */
	protected $kingRow;
	protected $kingCol;
	protected $horseRow;
	protected $horseCol;

	/**
	 * State constructor.
	 *
	 * @param $kingRow
	 * @param $kingCol
	 * @param $horseRow
	 * @param $horseCol
	 */
	public function __construct( $kingRow, $kingCol, $horseRow, $horseCol ) {
		$this->kingRow  = $kingRow;
		$this->kingCol  = $kingCol;
		$this->horseRow = $horseRow;
		$this->horseCol = $horseCol;
	}

	/**
	 * @param $row
	 * @param $col
	 */
	public function setKing($row, $col) {
		$this->kingRow = $row;
		$this->kingCol = $col;
	}

	/**
	 * @param $row
	 * @param $col
	 */
	public function setHorse($row, $col) {
		$this->horseRow = $row;
		$this->horseCol = $col;
	}

	/**
	 * @return mixed
	 */
	public function getKingRow() {
		return $this->kingRow;
	}

	/**
	 * @return mixed
	 */
	public function getKingCol() {
		return $this->kingCol;
	}

	/**
	 * @return mixed
	 */
	public function getHorseRow() {
		return $this->horseRow;
	}

	/**
	 * @return mixed
	 */
	public function getHorseCol() {
		return $this->horseCol;
	}


	/**
	 * @param Operator $operator
	 *
	 * @return mixed
	 */
	public function getOperatorSteps( $operator ) {
		return $operator->getPossibleSteps($this);
	}


	public function isGoalState() {
        return ($this->kingRow == 8 && $this->kingCol == 7) || ($this->horseRow == 8 && $this->horseCol == 7);
    }

    public function isState() {
        return ($this->kingRow != $this->horseRow || $this->kingCol != $this->horseCol) &&
               ($this->kingRow >= 1 && $this->kingRow <= 8) &&
               ($this->kingCol >= 1 && $this->kingCol <= 8) &&
               ($this->horseRow >= 1 && $this->horseRow <= 8) &&
               ($this->horseCol >= 1 && $this->horseCol <= 8);
    }

    public function printTable($arr = []) {
		echo "<table>";
		echo "<tr><td></td><td align='center'>1</td><td align='center'>2</td><td align='center'>3</td><td align='center'>4</td><td align='center'>5</td><td align='center'>6</td><td align='center'>7</td><td align='center'>8</td></tr>";
        for($r = 1; $r <= 8; $r++) {
        	echo "<tr>";
        	echo "<td align='center'>$r</td>";
			for($c = 1; $c <= 8; $c++) {
        		echo "<td align='center' style='background-color: ".(($r %2)? (($c%2)?"white":"black"):(($c%2)?"black":"white"))."; color: ".(($r %2)? (($c%2)?"black":"white"):(($c%2)?"white":"black"))."'>";
				if($this->kingRow == $r && $this->kingCol == $c) {
					echo "K";
                } elseif($this->horseRow == $r && $this->horseCol == $c) {
					echo "H";
                } elseif($r == 8 && $c == 7){
					echo "G";
                } else {
					echo "";
	            }
	            echo "</td>";
			}
			echo "</tr>";

        }
        echo "</table>";
    }

	public function toString() {
		echo "State: ".
	         $this->getKingRow().
	         " ".
		     $this->getKingCol().
		     " ".
		     $this->getHorseRow().
		     " ".
		     $this->getHorseCol();

    }

	public function getHash() {
		return md5(
			$this->getKingRow(). ",". $this->getKingCol(). ",". $this->getHorseRow(). ",". $this->getHorseCol()
		);
    }


	/**
	 * @param State $state
	 */
	public function clone( $state ) {
		$this->kingRow = $state->getKingRow();
		$this->kingCol = $state->getKingCol();

		$this->horseRow = $state->getHorseRow();
		$this->horseCol = $state->getHorseCol();

    }

}