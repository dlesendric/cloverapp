<?php

namespace ClientBundle\Controller;



use AppBundle\Annotation\FilterDeleted;
use AppBundle\Controller\BaseController;
use ClientBundle\Entity\Client;
use ClientBundle\Services\ClientService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/clients")
 * @Security("has_role('ROLE_USER')")
 * @FilterDeleted(enabled="true")
 * Class FrontendClientController
 * @package ClientBundle\Controller
 */
class FrontendClientController extends BaseController
{

	/**
	 * @var ClientService
	 */
	protected $service;

	/**
	 * @Route(name="client_index", path="/")
	 * @Method("GET")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction(Request $request)
	{
		$page = 1;
		if($request->get('page')){
			$page = $request->get('page');
		}

		$pagination = $this->service->generatePagination($page);
		return $this->render('@Client/client/index.html.twig', array(
			'pagination' => $pagination
		));
	}


	/**
	 * Finds and displays a client entity.
	 *
	 * @Route("/{id}", name="client_show")
	 * @Method("GET")
	 */
	public function showAction(Client $client)
	{

		return $this->render('@Client/client/show.html.twig', array(
			'client' => $client
		));
	}
}