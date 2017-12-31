<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/30/2017
 * Time: 10:14 PM
 */

namespace AppBundle\Services;


use AppBundle\Interfaces\ISoftDelete;

class SoftDeletableService extends BaseService
{
	/**
	 * Overrides method from parent class
	 * Makes objects invisible in view like magic
	 * @param      $obj
	 * @param bool $flush
	 */
	public function remove($obj, $flush = true)
	{
		if($obj instanceof ISoftDelete){
			$obj->setDeleted(true);
			$this->save($obj,$flush);
		}
	}
}