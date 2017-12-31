<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 1:36 PM
 */

namespace AppBundle\Interfaces;


use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface IPagination
{

	/**
	 * Get by page method
	 *
	 * 1. Create & pass query to paginate method
	 * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
	 * 3. Return that object to the controller
	 *
	 * @param integer $page The current page (passed from controller)
	 *
	 * @return Paginator
	 */
	public function getByPage($page);


	/**
	 * Paginator Helper
	 *
	 * Pass through a query object, current page & limit
	 * the offset is calculated from the page and limit
	 * returns an `Paginator` instance, which you can call the following on:
	 *
	 *     $paginator->getIterator()->count() # Total fetched (ie: `5` posts)
	 *     $paginator->count() # Count of ALL posts (ie: `20` posts)
	 *     $paginator->getIterator() # ArrayIterator
	 *
	 * @param Query $dql   DQL Query Object
	 * @param integer            $page  Current page (defaults to 1)
	 * @param integer            $limit The total number per page (defaults to 25)
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator | array
	 */
	public function paginate($dql, $page = 1, $limit = 25);
}