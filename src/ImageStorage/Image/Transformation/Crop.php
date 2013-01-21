<?php
namespace ImageStorage\Image\Transformation;

class Crop implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Structure\Image
	 */
	private $_imageStruct;

	/**
	 * @var \ImageStorage\Image\Structure\Crop|null
	 */
	private $_crop = null;

	/**
	 * @param \ImageStorage\Image\Structure\Crop $crop
	 * @throws \Exception
	 */
	public function __construct(\ImageStorage\Image\Structure\Crop $crop = null)
	{
		if (!($crop instanceof \ImageStorage\Image\Structure\Crop))
		{
			throw new \Exception('Bad structure!');
		}
		$this->_crop = $crop;
	}

	/**
	 * @param \ImageStorage\Image\Structure\Image $imageStruct
	 *
	 * @return \ImageStorage\Image\Structure\Image
	 */
	public function transform(\ImageStorage\Image\Structure\Image $imageStruct)
	{
		$this->_imageStruct = $imageStruct;
		return $this->_crop();
	}

	private function _crop()
	{
		$newIm = imagecreatetruecolor($this->_crop->width, $this->_crop->height);
		imagecopyresized($newIm, $this->_imageStruct->image, 0, 0, $this->_crop->x, $this->_crop->y, $this->_crop->width, $this->_crop->height, $this->_crop->width, $this->_crop->height);
		return new \ImageStorage\Image\Structure\Image($newIm, $this->_crop->width, $this->_crop->height);
	}
}
