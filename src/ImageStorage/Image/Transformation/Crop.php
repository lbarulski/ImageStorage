<?php
namespace ImageStorage\Image\Transformation;

class Crop implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Struct\Image
	 */
	private $_imageStruct;

	/**
	 * @var \ImageStorage\Image\Struct\Crop|null
	 */
	private $_crop = null;

	/**
	 * @param \ImageStorage\Image\Struct\Image 		$imageStruct
	 * @param \ImageStorage\Image\Struct\Crop|null  $crop
	 */
	public function __construct(\ImageStorage\Image\Struct\Image $imageStruct, \ImageStorage\Image\Struct\Crop $crop = null)
	{
		$this->_imageStruct = $imageStruct;
		$this->_crop		= $crop;
	}

	public function transform()
	{
		return $this->_crop();
	}

	private function _crop()
	{
		$newIm = imagecreatetruecolor($this->_crop->width, $this->_crop->height);
		imagecopyresized($newIm, $this->_imageStruct->image, 0, 0, $this->_crop->x, $this->_crop->y, $this->_crop->width, $this->_crop->height, $this->_crop->width, $this->_crop->height);
		return $newIm;
	}
}
