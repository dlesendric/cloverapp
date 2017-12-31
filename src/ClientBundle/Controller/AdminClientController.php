<?php

namespace ClientBundle\Controller;

use AppBundle\Annotation\FilterDeleted;
use AppBundle\Controller\BaseController;
use ClientBundle\Entity\Client;
use ClientBundle\Services\ClientService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

/**
 * Client controller.
 * This controller have Soft delete filter (Filter Delete) even if hi is enabled by default, we have options to disable or
 * enable filter for this controller
 * @Route("/admin/clients")
 * @Security("has_role('ROLE_ADMIN')")
 * @FilterDeleted(enabled="true")
 */
class AdminClientController extends BaseController
{
	/**
	 * @var ClientService
	 */
	protected $service;


    /**
     * Creates a new client entity.
     *
     * @Route("/new", name="admin_clients_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm('ClientBundle\Form\ClientType', $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$this->service->save($client, true);

            return $this->redirectToRoute('client_index');
        }

        return $this->render('@Client/client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="admin_clients_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('ClientBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->service->save($client);
            return $this->redirectToRoute('client_index');
        }

        return $this->render('@Client/client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     * @Route("/{id}", name="admin_clients_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Client $client)
    {
	    if(!$client){
		    return new Response('',Response::HTTP_BAD_REQUEST);
	    }
	    if($request->isXmlHttpRequest() && $this->isCsrfTokenValid('authenticate', $request->get('_token'))){
		    $this->service->remove($client); //soft delete
		    return new Response('',Response::HTTP_NO_CONTENT);
	    }
	    $form = $this->createDeleteForm($client);
	    $form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {
		    $this->service->remove($client); //soft delete
	    }
	    return $this->redirectToRoute('client_index');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_clients_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
