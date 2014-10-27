<?php
namespace ImageStorage\Image\Structure;

class Blur
{
	public $blurCount;

	/**
	 * @param int|null $blurCount
	 */
	public function __construct($blurCount = 15)
	{
		$this->blurCount = $blurCount;
	}
}
