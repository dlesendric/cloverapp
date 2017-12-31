<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 3:07 PM
 */

namespace AppBundle\Services;


use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

interface IBaseService
{

	/**
	 * This don't need to be singleton class, but in case when service is shared, he will always return the same instance
	 * @return mixed
	 */
	public function getInstance();


	/**
	 * Set Service main repository instance
	 * @param ObjectRepository $repository
	 *
	 * @return mixed
	 */
	public function setRepository(ObjectRepository $repository);

	/**
	 * Get main service repository
	 * @return ObjectRepository
	 */
	public function getRepository();


	/**
	 * Save any entyty
	 * @param      $obj
	 * @param bool $flush
	 */
	public function save($obj, $flush = true);


	/**
	 * @param ContainerInterface $container
	 *
	 */
	public function setContainer(ContainerInterface $container);



	/**
	 * Delete entity
	 * @param      $obj
	 * @param bool $flush
	 */
	public function remove($obj, $flush = true);




}