<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/29/2017
 * Time: 11:22 PM
 */

namespace AppBundle\Helper;


class Flash
{
	const INFO = 'info';
	const DANGER = 'danger';
	const DEFAULT = 'default';
	const PRIMARY = 'primary';
	const WARNING = 'warning';
	const SUCCESS = 'success';


	/**
	 * @param string $type
	 * @param string $message
	 *
	 * @return string
	 */
	public static function renderAlert($type = self::INFO, $message)
	{
		return '<div class="alert alert-'.$type.'" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
		</button>
		'.$message.'</div>';
	}
}