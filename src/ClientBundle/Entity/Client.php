<?php

namespace ClientBundle\Entity;

use AppBundle\Annotation\DeleteAware;
use AppBundle\Entity\Traits\DeleteTrait;
use AppBundle\Interfaces\ISoftDelete;
use ContactBundle\Entity\Contact;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ClientRepository")
 * @DeleteAware(deleteFieldName="deleted")
 */
class Client implements ISoftDelete
{

	use DeleteTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

	/**
	 * @var Contact
	 *
	 * Eager fetch, always join
	 * @ORM\OneToOne(targetEntity="ContactBundle\Entity\Contact", cascade={"persist"}, fetch="EAGER")
	 * @JoinColumn(name="contact_id", referencedColumnName="id")
	 */
    private $contact;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * @param Contact $contact
	 *
	 * @return $this
	 */
    public function setContact(Contact $contact)
    {
    	$this->contact = $contact;
    	return $this;
    }

	/**
	 * @return Contact
	 */
    public function getContact(){
    	return $this->contact;
    }
}

