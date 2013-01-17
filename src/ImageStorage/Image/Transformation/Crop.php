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
	 * @param \ImageStorage\Image\Struct\Crop $crop
	 * @throws \Exception
	 */
	public function __construct(\ImageStorage\Image\Struct\Crop $crop = null)
	{
		if (!($crop instanceof \ImageStorage\Image\Struct\Crop))
		{
			throw new \Exception('Bad structure!');
		}
		$this->_crop = $crop;
	}

	/**
	 * @param \ImageStorage\Image\Struct\Image $imageStruct
	 *
	 * @return \ImageStorage\Image\Struct\Image
	 */
	public function transform(\ImageStorage\Image\Struct\Image $imageStruct)
	{
		$this->_imageStruct = $imageStruct;
		return $this->_crop();
	}

	private function _crop()
	{
		$newIm = imagecreatetruecolor($this->_crop->width, $this->_crop->height);
		imagecopyresized($newIm, $this->_imageStruct->image, 0, 0, $this->_crop->x, $this->_crop->y, $this->_crop->width, $this->_crop->height, $this->_crop->width, $this->_crop->height);
		return new \ImageStorage\Image\Struct\Image($newIm, $this->_crop->width, $this->_crop->height);
	}
}
