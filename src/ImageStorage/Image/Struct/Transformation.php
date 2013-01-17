<?php
namespace ImageStorage\Image\Struct;
class Transformation
{
	public $className;

	public $object;

	/**
	 * @param string|null $className
	 * @param object|null $object
	 */
	public function __construct($className = null, $object = null)
	{
		$this->className 	= $className;
		$this->object		= $object;
	}
}
