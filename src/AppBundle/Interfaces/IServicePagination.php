<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 9:37 PM
 */

namespace AppBundle\Interfaces;


interface IServicePagination
{
	/**
	 * @param int $page
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function generatePagination($page = 1);
}