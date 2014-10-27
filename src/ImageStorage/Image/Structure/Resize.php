<?php
namespace ImageStorage\Image\Structure;
class Resize
{
	/** @var int */
	public $width;

	/** @var int */
	public $height;

	/** @var bool */
	public $crop;

	/** @var int */
	public $blur;

	/**
	 * @param int  $width
	 * @param int  $height
	 * @param bool $crop
	 * @param int $blur
	 */
	public function __construct($width = 0, $height = 0, $crop = true, $blur = 0)
	{
		$this->width  = $width;
		$this->height = $height;
		$this->crop   = $crop;
		$this->blur   = $blur;
	}
}
