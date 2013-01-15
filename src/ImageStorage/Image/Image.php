<?php
namespace ImageStorage\Image;
class Image
{
	private $_imageObject = null;
	private $_imageWidth = 0;
	private $_imageHeight = 0;

	/**
	 * @param $fromX
	 * @param $fromY
	 * @param $width
	 * @param $height
	 *
	 * @return bool
	 */
	public function crop($fromX, $fromY, $width, $height)
	{
		if ($this->_imageObject)
		{
			$newIm = imagecreatetruecolor($width, $height);
			imagecopyresized($newIm, $this->_imageObject, 0, 0, $fromX, $fromY, $width, $height, $width, $height);
			$this->_imageObject = $newIm;
			return true;
		}
		return false;
	}

	/**
	 * @param int  $width
	 * @param int  $height
	 * @param bool $scale
	 *
	 * @return bool
	 */
	public function resize($width = 0, $height = 0, $scale = true)
	{
		$newHeight = 0;
		$newWidth = 0;

		if ($this->_imageObject)
		{
			if ($width == 0 && $height > 0)
			{
				$newHeight = $height;
				$newWidth = $this->_imageWidth / ($this->_imageHeight / $height);
			}
			elseif ($height == 0 && $width > 0)
			{
				$newHeight = $this->_imageHeight / ($this->_imageWidth / $width);
				$newWidth = $width;
			}
			elseif ($width > 0 && $height > 0)
			{
				if ($scale == false)
				{
					$newHeight = $height;
					$newWidth = $width;
				}
				else
				{
					if ($height > $width)
					{
						$newHeight = $height;
						$newWidth = $this->_imageWidth / ($this->_imageHeight / $height);
					}
					else
					{
						$newHeight = $this->_imageHeight / ($this->_imageWidth / $width);
						$newWidth = $width;
					}
				}
			}

			if ($newHeight != 0 && $newWidth != 0)
			{
				$newIm = imagecreatetruecolor($newWidth, $newHeight);

				imagecopyresampled($newIm, $this->_imageObject, 0, 0, 0, 0, $newWidth, $newHeight, $this->_imageWidth, $this->_imageHeight);
				$this->_imageObject = $newIm;
				$this->_imageWidth = imagesx($newIm);
				$this->_imageHeight = imagesy($newIm);

				return true;
			}
		}

		return false;
	}

	/**
	 * @param        $filename
	 *
	 * @return bool
	 */
	public function watermark($filename)
	{
		if (file_exists($filename) && $this->_imageObject)
		{
			$image = $this->loadImage($filename);

			if ($image)
			{
				list($watermarkObject, $watermarkWidth, $watermarkHeight) = $image;
				imagecopyresampled($this->_imageObject, $watermarkObject, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight, $watermarkWidth, $watermarkHeight);

				return true;
			}
		}

		return false;
	}

	/**
	 * @param $filename
	 *
	 * @return bool
	 */
	public function load($filename)
	{
		if (file_exists($filename))
		{
			$image = $this->loadImage($filename);

			if ($image != false)
			{
				list($this->_imageObject, $this->_imageWidth, $this->_imageHeight) = $image;

				return true;
			}
		}

		return false;
	}

	/**
	 * @param $file
	 *
	 * @return array|bool
	 */
	private function loadImage($file)
	{
		$imageInformation = getimagesize($file);

		switch ($imageInformation[2])
		{
			case 1:
				// gif
				$im = imagecreatefromgif($file);
				break;

			case 2:
				// jpeg
				$im = imagecreatefromjpeg($file);
				break;

			case 3:
				// png
				$im = imagecreatefrompng($file);
				break;

			default:
				// other types
				return false;
				break;
		}

		return array(
			$im,
			$imageInformation[0],
			$imageInformation[1]
		);
	}

	/**
	 * @param        $filename
	 * @param string $format
	 * @param int    $quality
	 */
	public function save($filename, $format = 'jpg', $quality = 97)
	{
		if ($this->_imageObject)
		{
			switch (strtolower($format))
			{
				case "png":
					imagepng($this->_imageObject, $filename, $quality);
					break;

				default:
					imagejpeg($this->_imageObject, $filename, $quality);
					break;
			}
		}

		return;
	}
}

?>