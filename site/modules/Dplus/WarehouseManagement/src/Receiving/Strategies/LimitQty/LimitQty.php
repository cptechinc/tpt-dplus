<?php namespace Dplus\Wm\Receiving\Strategies\ReadQty;

// ProcessWire
use ProcessWire\WireData;


/**
 * LimitQty
 * Strategy for Allowing to Receive More than Ordered
 */
class LimitQty extends WireData {
	const ALLOW_OVER_RECEIVE = false;

	public function allowOverReceive() {
		return self::ALLOW_OVER_RECEIVE;
	}
}
