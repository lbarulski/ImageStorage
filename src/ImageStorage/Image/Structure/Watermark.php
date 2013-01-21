<?php
namespace ImageStorage\Image\Structure;
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
