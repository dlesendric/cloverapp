<?php

namespace UserBundle\Tests\Services;


use AppBundle\Tests\AppTestCase;
use UserBundle\Services\UserService;

class UserServiceTest extends AppTestCase
{
	public function testMethodExists(){
		/**
		 * @var UserService
		 */
		$service = $this->getService('user_service');
		$this->assertTrue(method_exists($service, 'remove'));
		$this->assertTrue(method_exists($service, 'createUser'));
		$this->assertTrue(method_exists($service, 'save'));
		$this->assertTrue(method_exists($service, 'getRepository'));
		$this->assertTrue(method_exists($service, 'setRepository'));
		$this->assertObjectHasAttribute('repository', $service);
	}


	

}