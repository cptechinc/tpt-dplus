<?php namespace Controllers\Ajax\Lookup;
// Propel Classes
use Propel\Runtime\ActiveQuery\ModelCriteria as Query;
// Dplus Model Classes
use ItemMasterItem;
// ProcessWire Classes, Modules
use ProcessWire\Module;
// Dplus Filters
use Dplus\Filters\AbstractFilter    as Filter;
use Dplus\Filters;
// Mvc Controllers
use Controllers\Ajax\Lookup\Base;

class Min extends Base {

	/**
	 * Search Items
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function items($data) {
		self::sanitizeParametersShort($data, self::FIELDS_LOOKUP_SHORT);
		self::sanitizeParametersShort($data, ['fororder|bool']);
		$filter = new Filters\Min\ItemMaster();
		self::pw('page')->headline = "Item Master";
		return self::filterItemsAndDisplay($filter, $data);

	}

	private static function filterItemsAndDisplay(Filter $filter, $data) {
		self::filter($filter, $data);

		$results = $filter->query->paginate(self::pw('input')->pageNum, 10);
		$itemids = array_column($results->toArray(), 'Inititemnbr');

		if ($data->fororder === true) {
			self::pw('modules')->get('ItemPricing')->request_multiple($itemids);
		}
		return self::displayResults(self::getResultsPathSegment(), $results, $data->q);
	}
}
