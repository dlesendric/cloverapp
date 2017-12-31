<?php

namespace UserBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Services\UserService;

/**
 * User controller.
 *
 * @Route("/admin/users")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdminUserController extends BaseController
{
	/**
	 * @var UserService
	 */
	protected $service;



    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
    	$page = 1;
    	if($request->get('page')){
    		$page = $request->get('page');
	    }

        $pagination = $this->service->generatePagination($page);
        return $this->render('@User/user/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
	    $roles = $this->service->getRolesFromConfig();
        $form = $this->createForm('UserBundle\Form\UserType', $user, [
        	'roles' => $roles
        ]);
        $form->handleRequest($request);
	    if($request->getMethod() == Request::METHOD_POST){
		    $passwordPlain = $request->get($form->getName())['password'];
		    $passwordEncoder = $this->get('security.password_encoder');
		    $password = $passwordEncoder->encodePassword($user, $passwordPlain);
		    $user->setPassword($password);
	    }
        if ($form->isSubmitted() && $form->isValid()) {
	        $this->service->save($user,true);
            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('@User/user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('@User/user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "PATCH"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user, [
        	'method' => Request::METHOD_PATCH,
	        'roles' => $this->service->getRolesFromConfig()
        ]);
	    $editForm->handleRequest($request);
		if($request->getMethod() == Request::METHOD_PATCH){
			$passwordPlain = $request->get($editForm->getName())['password'];
			$passwordEncoder = $this->get('security.password_encoder');
			$password = $passwordEncoder->encodePassword($user, $passwordPlain);
			$user->setPassword($password);
		}
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->service->save($user,true);
            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('@User/user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
    	if(!$user){
    		return new Response('',Response::HTTP_BAD_REQUEST);
	    }
	    if($request->isXmlHttpRequest() && $this->isCsrfTokenValid('authenticate', $request->get('_token'))){
    		$this->service->remove($user);
    		return new Response('',Response::HTTP_NO_CONTENT);
	    }
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->remove($user);
        }
        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
