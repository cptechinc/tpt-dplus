<?php namespace Dplus\CodeValidators\Mii;

use Dplus\CodeValidators\Mii;
use Dplus\CodeValidators\Min;
use Dplus\CodeValidators\Msa;

/**
 * Mii
 */
class Iio extends Mii {
	/**
	 * Validate Login ID
	 * @param  string $userID User ID
	 * @return bool
	 */
	public function userid($userID) {
		$validate = new Msa();
		return $validate->userid($userID);
	}

	/**
	 * Validate Warehouse ID
	 * @param  string $whseID Warehouse ID
	 * @return bool
	 */
	public function whseid($whseID) {
		if ($whseID == '**') {
			return true;
		}
		$validate = new Min();
		return $validate->whseid($whseID);
	}
}
