<?php namespace Controllers\Ajax\Lookup;
// Propel Classes
use Propel\Runtime\ActiveQuery\ModelCriteria as Query;
use Propel\Runtime\Collection as Results;
use Propel\Runtime\Util\PropelModelPager as PagerResults;
// ProcessWire Classes, Modules
use ProcessWire\Module, ProcessWire\ProcessWire;
// Dplus Filters
use Dplus\Filters\AbstractFilter    as Filter;
// Mvc Controllers
use Mvc\Controllers\AbstractController;

abstract class Base extends AbstractController {
	const FIELDS_LOOKUP = ['q' => ['sanitizer' => 'text']];
	const FIELDS_LOOKUP_SHORT = ['q|text'];

	public static function test() {
		return 'test';
	}

	protected static function filterModuleAndDisplayResults(Module $filter, $data) {
		self::filterModule($filter, $data);
		if ($data->q) {
			$page->headline = "Searching for '$data->q'";
		}
		$results = $filter->get_query()->paginate(self::pw('input')->pageNum, 10);
		return self::displayResults(self::getResultsPathSegment(), $results, $data->q);
	}

	protected static function filterAndDisplayResults(Module $filter, $data) {
		self::filter($filter, $data);
		if ($data->q) {
			$page->headline = "Searching for '$data->q'";
		}
		$results = $filter->query->paginate(self::pw('input')->pageNum, 10);
		return self::displayResults(self::getResultsPathSegment(), $results, $data->q);
	}

	protected static function filter(Filter $filter, $data) {
		$filter->filterInput(self::pw('input'));
		if ($data->q) {
			$filter->search($data->q);
		}
		$filter->sortby(self::pw('page'));
	}

	protected static function filterModule(Module $filter, $data) {
		$filter->filter_input(self::pw('input'));

		if ($data->q) {
			$filter->search($data->q);
		}
		$filter->apply_sortby(self::pw('page'));
	}

	protected static function getResultsPathSegment() {
		$input = self::pw('input');
		$page  = self::pw('page');
		$path = $input->urlSegment(count($input->urlSegments()));
		$path = rtrim(str_replace($page->url, '', self::pw('input')->url()), '/');
		$path = preg_replace('/page\d+/', '', $path);
		return $path;
	}

	protected static function displayResults($path = 'codes', PagerResults $results, $q = '') {
		$page  = self::pw('page');
		$html = '';
		$html .= self::pw('config')->twig->render("api/lookup/$path/search.twig", ['results' => $results, 'datamatcher' => self::pw('modules')->get('RegexData'), 'q' => $q]);
		$html .= '<div class="mb-3"></div>';
		$html .= self::pw('config')->twig->render('util/paginator/propel.twig', ['pager' => $results]);
		return $html;
	}
}
