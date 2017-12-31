<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 10:59 PM
 */

namespace UserBundle\Controller;


use AppBundle\Controller\BaseController;
use AppBundle\Helper\Flash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Entity\User;

class FrontendUserController extends BaseController
{
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request)
	{
		$authUtils = $this->get('security.authentication_utils');
		// get the login error if there is one
		$error = $authUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();
		$form = $this->createForm('UserBundle\Form\LoginType', null, array(
			'last_username'=>$lastUsername
		));
		return $this->render('@User/user/login.html.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
			'form'          => $form->createView()
		));
	}

	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction(){
		throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
	}


	/**
	 *
	 * @Route("/register" , name="register")
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function registerAction(Request $request)
	{
		$user = new User();
		$form = $this->createForm('UserBundle\Form\RegisterType', $user);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			/**
			 * @var User $user
			 */
			$passwordEncoder = $this->get('security.password_encoder');
			$password = $passwordEncoder->encodePassword($user, $user->getPassword());
			$user->setPassword($password);
			$user->setEnabled(true);
			//TODO do some mailer stuff
			$this->service->save($user, true);
			$this->addFlash(Flash::INFO,'You\'r account is now active, you can login...');
			$this->redirectToRoute('login');
		}
		return $this->render('@User/user/register.html.twig', [
			'form' => $form->createView()
		]);
	}
}