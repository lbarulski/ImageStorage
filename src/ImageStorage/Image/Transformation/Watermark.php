<?php
namespace ImageStorage\Image\Transformation;

class Watermark implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Struct\Image
	 */
	private $_imageStruct;

	/**
	 * @var \ImageStorage\Image\Struct\Watermark|null
	 */
	private $_watermark = null;

	/**
	 * @param \ImageStorage\Image\Struct\Image     		$imageStruct
	 * @param \ImageStorage\Image\Struct\Watermark|null $watermark
	 */
	public function __construct(\ImageStorage\Image\Struct\Image $imageStruct, \ImageStorage\Image\Struct\Watermark $watermark = null)
	{
		$this->_imageStruct	= $imageStruct;
		$this->_watermark	= $watermark;
	}

	public function transform()
	{
		return $this->_watermark();
	}

	private function _watermark()
	{
		if (file_exists($this->_watermark->fileName))
		{
			$image = \ImageStorage\Image\Image::loadImage($this->_watermark->fileName);
			imagecopyresampled($this->_imageStruct->image, $image->image, 0, 0, 0, 0, $image->width, $image->height, $image->width, $image->height);
			return $this->_imageStruct;
		}

		return false;
	}
}
