<?php
namespace ImageStorage\Image\Struct;
class Watermark
{
	public $fileName;

	/**
	 * @param string|null $fileName
	 */
	public function __construct($fileName = null)
	{
		$this->fileName	= $fileName;
	}
}
