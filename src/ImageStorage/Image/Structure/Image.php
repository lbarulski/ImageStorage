<?php
namespace ImageStorage\Image\Structure;
class Image
{
	public $image;
	public $width;
	public $height;

	public function __construct($image = null, $width = 0, $height = 0)
	{
		$this->image	= $image;
		$this->width 	= $width;
		$this->height 	= $height;
	}
}
