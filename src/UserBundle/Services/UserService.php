<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 3:13 PM
 */

namespace UserBundle\Services;


use AppBundle\Interfaces\IServicePagination;
use AppBundle\Services\BaseService;
use Symfony\Component\Form\FormError;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;

class UserService extends BaseService implements IServicePagination
{
	/**
	 * @var UserRepository
	 */
	protected $repository;


	private $roles;


	public function getAllUsers()
	{
		return $this->repository->findAll();
	}


	public function getUserById(int $id)
	{
		return $this->repository->find($id);
	}


	/**
	 * @param string $username
	 * @param string $password
	 *
	 * @return User | FormError
	 */
	public function checkLogin(string $username, string $password)
	{
		$passwordEncoder = $this->container->get('security.password_encoder');

		/**
		 * @var User $user
		 */
		$user = $this->repository->findOneBy([
			'username'=>$username
		]);

		if (!$user || !$passwordEncoder->isPasswordValid($user, $password)) {
			return new FormError('Invalid credentials.');
		} else if (!$user->isEnabled()) {
			return new FormError( 'Account is not activated.');
		}
		return $user;
	}

	/**
	 * @param int $page
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	public function generatePagination($page = 1){
		return $this->repository->getByPage($page);
	}

	public function getRolesFromConfig($withKeys = true, $sortByKeys = false){
		if($this->roles){
			return $this->roles;
		}
		$roleHierarchy  = $this->container->getParameter('security.role_hierarchy.roles');
		$roles = array(
			array_keys($roleHierarchy)[0] => array_keys($roleHierarchy)[0]
		);
		array_walk_recursive($roleHierarchy, function($val) use (&$roles) {
			$roles[$val] = $val;
		});
		if($sortByKeys){
			ksort($roles);
		}
		if($withKeys){
			return $this->roles = array_unique($roles);
		}
		return array_values($roles);
	}


	public function createUser()
	{
		$user  = new User();
		return $user;
	}



}