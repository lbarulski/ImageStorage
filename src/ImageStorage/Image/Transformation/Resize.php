<?php
namespace ImageStorage\Image\Transformation;

class Resize implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Struct\Image
	 */
	private $_imageStruct;

	/**\
	 * @var \ImageStorage\Image\Struct\Resize|null
	 */
	private $_resize = null;

	/**
	 * @param \ImageStorage\Image\Struct\Resize $resize
	 * @throws \Exception
	 */
	public function __construct(\ImageStorage\Image\Struct\Resize $resize = null)
	{
		if (!($resize instanceof \ImageStorage\Image\Struct\Resize))
		{
			throw new \Exception('Bad structure!');
		}
		$this->_resize = $resize;

	}

	/**
	 * @param \ImageStorage\Image\Struct\Image $imageStruct
	 *
	 * @return \ImageStorage\Image\Struct\Image
	 */
	public function transform(\ImageStorage\Image\Struct\Image $imageStruct)
	{
		$this->_imageStruct	= $imageStruct;
		return $this->_resize();
	}

	private function _resize()
	{
		$newHeight = 0;
		$newWidth = 0;

		if ($this->_resize->width == 0 && $this->_resize->height > 0)
		{
			$newHeight = $this->_resize->height;
			$newWidth = $this->_imageStruct->width / ($this->_imageStruct->height / $this->_resize->height);
		}
		elseif ($this->_resize->height == 0 && $this->_resize->width > 0)
		{
			$newHeight = $this->_imageStruct->height / ($this->_imageStruct->width / $this->_resize->width);
			$newWidth = $this->_resize->width;
		}
		elseif ($this->_resize->width > 0 && $this->_resize->height > 0)
		{
			if ($this->_resize->scale == false)
			{
				$newHeight = $this->_resize->height;
				$newWidth = $this->_resize->width;
			}
			else
			{
				if ($this->_resize->height > $this->_resize->width)
				{
					$newHeight = $this->_resize->height;
					$newWidth = $this->_imageStruct->width / ($this->_imageStruct->height / $this->_resize->height);
				}
				else
				{
					$newHeight = $this->_imageStruct->height / ($this->_imageStruct->width / $this->_resize->width);
					$newWidth = $this->_resize->width;
				}
			}
		}
		if ($newHeight != 0 && $newWidth != 0)
		{
			$newIm = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($newIm, $this->_imageStruct->image, 0, 0, 0, 0, $newWidth, $newHeight, $this->_imageStruct->width, $this->_imageStruct->height);
			return new \ImageStorage\Image\Struct\Image($newIm, $newWidth, $newHeight);
		}

		throw new \Exception('Bad new size!');
	}
}
