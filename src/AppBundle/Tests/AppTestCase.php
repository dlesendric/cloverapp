<?php

namespace AppBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use UserBundle\Entity\User;

class AppTestCase extends WebTestCase
{
    protected static $staticClient;

    /** @var  Client $client */
    protected $client;

    /** @var  EntityManager $em */
    protected $em;

    public static function setUpBeforeClass()
    {
        self::$staticClient = static::createClient(['environment' => 'test']);

        // kernel boot, so we can get the container and use our services
        self::bootKernel();
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->purgeDatabase();
    }

    protected function tearDown()
    {
        // purposefully not calling parent class, which shuts down the kernel
    }

    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
    }

    protected function createUser($username, $password, array $roles = [], $enabled = true)
    {
        $userManager = $this->getService('user_service');

        /** @var User $user */
        $user = $userManager->createUser();
        $user->setEnabled($enabled);
        $passwordEncoder = $this->getService('security.password_encoder');
	    $password = $passwordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
        $user->setUsername($username);
        $user->setFirstName(ucfirst($username));
        $user->setLastName(ucfirst($username));
        if(!empty($roles)){
            $user->setRoles($roles);
        }
        $userManager->save($user);

        return $user;
    }

    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine')->getManager());
        $purger->purge();
    }

    /**
     * Creates some user and returns his token
     *
     * @param $email
     * @return string
     */
    protected function getTokenForTestUser($email)
    {

        $token = $this->getService('lexik_jwt_authentication.encoder')
            ->encode(['email' => $email]);

        return $token;
    }


    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * This invokes private or protected methods of class in unit test
     *
     * @param       $object
     * @param       $methodName
     * @param array $parameters
     *
     * @return mixed
     */
    protected function invokeMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function makePOSTRegisterRequest($data)
    {
        $this->client->request(
            'POST',
            '/user/registration',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
    }
}
