<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 1:45 PM
 */

namespace AppBundle\Helper;


use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorHelper
{
	private $dql;
	/**
	 * @var int
	 */
	private $page;
	/**
	 * @var int
	 */
	private $limit;

	/**
	 * @var int
	 */
	private $total;

	/**
	 * @param $dql
	 * @param $page
	 * @param $limit
	 *
	 * @return Paginator
	 */
	public static function standardPagination($dql, $page, $limit){
		$paginator = new Paginator($dql);

		$paginator->getQuery()
			->setFirstResult($limit * ($page - 1)) // Offset
			->setMaxResults($limit); // Limit

		return $paginator;
	}

	public function setDql($dql){
		$this->dql = $dql;
		return $this;
	}


	public function setPage($page){
		$this->page = $page;
		return $this;
	}

	public function setLimit($limit){
		$this->limit = $limit;
		return $this;
	}

	public function setTotal($total){
		$this->total = $total;
		return $this;
	}


	public function advancedPagination(){
		$return = [
			'total' => $this->total,
			'items' => self::standardPagination($this->dql, $this->page, $this->limit),
			'page' => $this->page,
			'limit' => $this->limit
		];
		if(($this->total / $this->page) > $this->limit){
			$return['next'] = $this->page + 1;
		}
		if($this->page > 1){
			$return['prev'] = $this->page - 1;
		}
		return $return;
	}
}