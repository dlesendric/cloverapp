<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 10:16 PM
 */

namespace AppBundle\Interfaces;


interface ISoftDelete
{
	/**
	 * @param boolean|null $deleted
	 */
	public function setDeleted(bool $deleted);

	/**
	 * @return boolean|null
	 */
	public function getDeleted();
}