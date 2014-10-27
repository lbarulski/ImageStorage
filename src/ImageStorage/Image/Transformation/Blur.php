<?php
namespace ImageStorage\Image\Transformation;

use ImageStorage\Image\Structure\Blur as BlurStructure;
use ImageStorage\Image\Structure\Image;
use ImageStorage\Image\Transformation;

class Blur implements Transformation
{
	/**
	 * @var Image
	 */
	private $_imageStruct;

	/**
	 * @var BlurStructure
	 */
	private $blur;

	/**
	 * @param BlurStructure $blur
	 *
	 * @throws \Exception
	 */
	public function __construct(BlurStructure $blur = null)
	{
		if (!($blur instanceof BlurStructure))
		{
			throw new \Exception('Bad structure!');
		}

		$this->blur = $blur;
	}

	/**
	 * @param Image $imageStruct
	 *
	 * @return Image
	 */
	public function transform(Image $imageStruct)
	{
		$this->_imageStruct = $imageStruct;

		return $this->_blur();
	}

	/**
	 * @return Image
	 */
	private function _blur()
	{
		for ($i = 0; $i < $this->blur->blurCount; ++$i)
		{
			imagefilter($this->_imageStruct->image, IMG_FILTER_GAUSSIAN_BLUR);
		}

		return $this->_imageStruct;
	}
}