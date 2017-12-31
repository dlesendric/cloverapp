<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 3:10 PM
 */

namespace AppBundle\Services;


use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseService implements IBaseService
{
	/**
	 * @var ObjectRepository
	 */
	protected $repository;


	/**
	 * @var ContainerInterface
	 */
	protected $container;

	/**
	 * @var EntityManagerInterface
	 */
	protected $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * This don't need to be singleton class, but in case when service is shared, he will always return the same instance
	 * @return mixed
	 */
	public function getInstance()
	{
		return $this;
	}

	/**
	 * Set Service main repository instance
	 *
	 * @param ObjectRepository $repository
	 *
	 * @return mixed
	 */
	public function setRepository(ObjectRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Get main service repository
	 * @return ObjectRepository
	 */
	public function getRepository()
	{
		return $this->repository;
	}


	/**
	 * Save any entity
	 * @param      $obj
	 * @param bool $flush
	 */
	public function save($obj, $flush = true) {
		$this->em->persist($obj);
		if($flush){
			$this->em->flush();
		}
	}

	/**
	 * Delete entity
	 * @param      $obj
	 * @param bool $flush
	 */
	public function remove($obj, $flush = true)
	{
		$this->em->remove($obj);
		if($flush){
			$this->em->flush();
		}
	}


	public function setContainer(ContainerInterface $container){
		$this->container = $container;
	}


}