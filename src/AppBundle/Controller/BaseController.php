<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 3:05 PM
 */

namespace AppBundle\Controller;


use AppBundle\Services\IBaseService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
	/**
	 * @var IBaseService
	 */
	protected $service;


	public function __construct(IBaseService $service)
	{
		$this->service = $service;
	}

}