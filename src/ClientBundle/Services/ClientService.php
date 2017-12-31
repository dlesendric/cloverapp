<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 9:21 PM
 */

namespace ClientBundle\Services;


use AppBundle\Interfaces\IServicePagination;
use AppBundle\Services\SoftDeletableService;
use ClientBundle\Repository\ClientRepository;

class ClientService extends SoftDeletableService implements IServicePagination
{
	/**
	 * @var ClientRepository
	 */
	protected $repository;

	/**
	 * @param int $page
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function generatePagination($page = 1)
	{
		return $this->repository->getByPage($page);
	}

}