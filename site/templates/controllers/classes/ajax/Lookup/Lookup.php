<?php namespace Controllers\Ajax\Lookup;
// Propel Classes
use Propel\Runtime\ActiveQuery\ModelCriteria as Query;
// ProcessWire Classes, Modules
use ProcessWire\Module;
// Dplus Filters
use Dplus\Filters\AbstractFilter    as Filter;
use Dplus\Filters\Misc\PhoneBook    as PhoneBookFilter;
use Dplus\Filters\Misc\CountryCode  as CountryCodeFilter;
use Dplus\Filters\Mpo\PurchaseOrder as PurchaseOrderFilter;
use Dplus\Filters\Mgl\GlCode        as GlCodeFilter;
use Dplus\Filters\Min\ItemGroup     as ItemGroupFilter;
use Dplus\Filters\Mar\Customer      as CustomerFilter;
use Dplus\Filters\Map\Vendor        as VendorFilter;
use Dplus\Filters\Map\Vxm           as VxmFilter;
// Mvc Controllers
use Controllers\Ajax\Lookup\Base;

class Lookup extends Base {
	/**
	 * Search Tariff Codes
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function tariffCodes($data) {
		$data   = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page   = self::pw('page');
		$filter = self::pw('modules')->get('FilterInvTariffCodes');
		$filter->init_query();
		$page->headline = "Tariff Codes";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * Search MSDS Codes
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function msdsCodes($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = self::pw('modules')->get('FilterInvMsdsCodes');
		$filter->init_query();
		$page->headline = "Msds Codes";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * Search Freight Codes
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function freightCodes($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = self::pw('modules')->get('FilterMsoFreightCodes');
		$filter->init_query();
		$page->headline = "Freight Codes";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * Search VXM
	 * @param  object $data
	 *                     vendorID Vendor ID
	 *                     q        Search Term
	 * @return void
	 */
	public static function vxm($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = new VxmFilter();
		$page->headline = "VXM";
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Warehouses
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function warehouses($data) {
		$data   = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page   = self::pw('page');
		$filter = self::pw('modules')->get('FilterWarehouses');
		$filter->init_query();
		$page->headline = "Warehouses";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * Search Users
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function users($data) {
		$data   = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page   = self::pw('page');
		$filter = self::pw('modules')->get('FilterDplusUsers');
		$filter->init_query();
		$page->headline = "Users";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * Search Vendors
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function vendors($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = new VendorFilter();
		$filter->init();
		$page->headline = "Vendors";
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Vendor Contacts
	 * @param  object $data
	 *                     vendorID  Vendor ID
	 *                     q         Search Term
	 * @return void
	 */
	public static function vendorContacts($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$data = self::sanitizeParametersShort($data, ['vendorID|text']);
		$page = self::pw('page');
		$filter = new PhoneBookFilter();
		$filter->init();
		$page->headline = "Vendor Contacts";
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Item Groups
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function itemGroups($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$data = self::sanitizeParametersShort($data, ['vendorID|text']);
		$page = self::pw('page');
		$filter = new ItemGroupFilter();
		$filter->init();
		$page->headline = "Item Groups";
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Items
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function itmItems($data) {
		self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$filter = self::pw('modules')->get('FilterItemMaster');
		$filter->init_query();
		self::pw('page')->headline = "Item Master";
		return self::filterModuleAndDisplayResults($filter, $data);
	}

	/**
	 * filter Purchase Orders
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function purchaseOrders($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$filter = new PurchaseOrderFilter();
		$filter->init();
		self::pw('page')->headline = "Purchase Orders";
		self::pw('config')->po = self::pw('modules')->get('ConfigurePo')->config();
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Filter General Ledger Codes
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function generalLedgerCodes($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$filter = new GlCodeFilter();
		$filter->init();
		self::pw('page')->headline = "General Ledger Codes";
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Customers
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function customers($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = new CustomerFilter();
		$filter->init();
		$filter->user(self::pw('user'));
		$page->headline = "Customers";
		if ($data->q) {
			$filter->search($data->q);
			$page->headline = "Searching for $data->q";
		}
		return self::filterAndDisplayResults($filter, $data);
	}

	/**
	 * Search Country Codes
	 * @param  object $data
	 *                     q   Search Term
	 * @return void
	 */
	public static function countryCodes($data) {
		$data = self::sanitizeParameters($data, self::FIELDS_LOOKUP);
		$page = self::pw('page');
		$filter = new CountryCodeFilter();
		$filter->init();
		$page->headline = "Country Codes";
		if ($data->q) {
			$filter->search($data->q);
			$page->headline = "Searching for $data->q";
		}
		return self::filterAndDisplayResults($filter, $data);
	}
}
