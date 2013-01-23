<?php
namespace ImageStorage\Image;

class Image
{
	/**
	 * @var Structure\Image
	 */
	private $_imageStruct;

	/**
	 * @param $fileName
	 *
	 * @return bool
	 */
	private function _load($fileName)
	{
		if (file_exists($fileName))
		{
			$this->_imageStruct = $this->loadImage($fileName);

			if ($this->_imageStruct)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $file
	 */
	public function __construct($file)
	{
		$this->_imageStruct = new Structure\Image;
		$this->_load($file);
	}

	/**
	 * @param $file
	 *
	 * @return Structure\Image
	 * @throws \Exception
	 */
	public static function loadImage($file)
	{
		self::convertPDF($file);

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
				throw new \Exception('Invalid file type!');
		}

		return new Structure\Image($im, $imageInformation[0], $imageInformation[1]);
	}

	protected static function convertPDF($file)
	{
		if ("%PDF-" === file_get_contents($file, null, null, 0, 5))
		{
			// magic!
			if (class_exists('Imagick'))
			{
				$img = new \Imagick($file . '[0]');
				$img->setimageformat("jpg");
				$img->writeimage($file);
			}
			else
			{
				exec(sprintf('convert %s %s', escapeshellarg($file), escapeshellarg($file . '.jpg')));
				rename($file . '.jpg', $file);
			}
		}
	}

	/**
	 * @param Transformation $transformationObject
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function transform(\ImageStorage\Image\Transformation $transformationObject)
	{
		if (!($transformationObject instanceof Transformation))
		{
			throw new \Exception('Transformation is not instanceof \ImageStorage\Image\Transformation!');
		}
		$this->_imageStruct = $transformationObject->transform($this->_imageStruct);
		if (!($this->_imageStruct instanceof Structure\Image))
		{
			throw new \Exception('Transformation return invalid data!');
		}
		return true;
	}

	/**
	 * @param        $fileName
	 * @param string $format
	 * @param int    $quality
	 */
	public function save($fileName, $format = 'jpg', $quality = 97)
	{
		switch (strtolower($format))
		{
			case "png":
				imagepng($this->_imageStruct->image, $fileName, $quality);
				break;

			default:
				imagejpeg($this->_imageStruct->image, $fileName, $quality);
				break;
		}
	}


	public function __clone()
	{
		$this->_imageStruct = clone $this->_imageStruct;
	}
}

