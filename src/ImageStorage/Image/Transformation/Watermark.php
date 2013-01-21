<?php
namespace ImageStorage\Image\Transformation;

class Watermark implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Structure\Image
	 */
	private $_imageStruct;

	/**
	 * @var \ImageStorage\Image\Structure\Watermark|null
	 */
	private $_watermark = null;

	/**
	 * @param \ImageStorage\Image\Structure\Watermark $watermark
	 * @throws \Exception
	 */
	public function __construct(\ImageStorage\Image\Structure\Watermark $watermark = null)
	{
		if (!($watermark instanceof \ImageStorage\Image\Structure\Watermark))
		{
			throw new \Exception('Bad structure!');
		}

		$this->_watermark = $watermark;
	}

	/**
	 * @param \ImageStorage\Image\Structure\Image $imageStruct
	 *
	 * @return \ImageStorage\Image\Structure\Image
	 */
	public function transform(\ImageStorage\Image\Structure\Image $imageStruct)
	{
		$this->_imageStruct	= $imageStruct;
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

		throw new \Exception('File '.$this->_watermark->fileName.' not exist!');
	}
}
