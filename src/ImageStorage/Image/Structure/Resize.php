<?php
namespace ImageStorage\Image\Structure;
class Resize
{
	public $width;
	public $height;
	public $crop;

	public function __construct($width = 0, $height = 0, $crop = true)
	{
		$this->width 	= $width;
		$this->height 	= $height;
		$this->crop 	= $crop;
	}
}
