<?php namespace Dplus\Wm\Receiving\Strategies\EnforceQty;

// ProcessWire
use ProcessWire\WireData;


/**
 * Realxed
 * Strategy for allowing Qty Received to be more than qty ordered
 */
class Relaxed extends WireData {
	const ALLOW_OVER_RECEIVE = false;

	public function allowOverReceive() {
		return self::ALLOW_OVER_RECEIVE;
	}
}
