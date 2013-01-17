<?php
namespace ImageStorage\Image;

class Image
{
	/**
	 * @var Struct\Image
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
		$this->_imageStruct = new Struct\Image;
		$this->_load($file);
	}

	/**
	 * @param $file
	 *
	 * @return Struct\Image
	 * @throws \Exception
	 */
	public static function loadImage($file)
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
				throw new \Exception('Invalid file type!');
		}

		return new Struct\Image($im, $imageInformation[0], $imageInformation[1]);
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
		if (!($this->_imageStruct instanceof Struct\Image))
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
}

?>