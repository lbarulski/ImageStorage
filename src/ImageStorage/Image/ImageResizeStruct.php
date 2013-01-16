<?php
namespace ImageStorage\Image;
class ImageResizeStruct
{
	public $width;
	public $height;
	public $scale;

	public function __construct($width = 0, $height = 0, $scale = true)
	{
		$this->width 	= $width;
		$this->height 	= $height;
		$this->scale 	= $scale;
	}
}
