<?php
namespace ImageStorage\Image\Transformation;

class WatermarkRand implements \ImageStorage\Image\Transformation
{
	/**
	 * @var \ImageStorage\Image\Structure\Image
	 */
	private $_imageStruct;

	/**
	 * @var \ImageStorage\Image\Structure\WatermarkRand|null
	 */
	private $_watermarkRand = null;

	/**
	 * @param \ImageStorage\Image\Structure\WatermarkRand $watermark
	 *
	 * @throws \Exception
	 */
	public function __construct(\ImageStorage\Image\Structure\WatermarkRand $watermarkRand = null)
	{
		if (!($watermarkRand instanceof \ImageStorage\Image\Structure\WatermarkRand))
		{
			throw new \Exception('Bad structure!');
		}

		$this->_watermarkRand = $watermarkRand;
	}

	/**
	 * @param \ImageStorage\Image\Structure\Image $imageStruct
	 *
	 * @return \ImageStorage\Image\Structure\Image
	 */
	public function transform(\ImageStorage\Image\Structure\Image $imageStruct)
	{
		$this->_imageStruct = $imageStruct;

		return $this->_watermark_rand();
	}

	/**
	 * @return \ImageStorage\Image\Structure\Image
	 * @throws \Exception
	 */
	private function _watermark_rand()
	{
		if (file_exists($this->_watermarkRand->fileName))
		{


			$config = $this->_watermarkRand;


			if (class_exists('\Imagick'))
			{


				//prepare source in Imagick
				$source = new \Imagick();
				$source->readImageBlob($this->getPngBlobFromGd($this->_imageStruct->image));

				//prepare watermark
				$watermark        = new \Imagick($this->_watermarkRand->fileName);
				$maxWatermarkSize = $source->getImageWidth() * $config->getSize();
				if ($maxWatermarkSize < $config->getMinSize())
				{
					$maxWatermarkSize = $config->getMinSize();
				}

				$watermark->thumbnailImage($maxWatermarkSize, $maxWatermarkSize);

				//cache image size
				$imageWidth  = $source->getImageWidth();
				$imageHeight = $source->getImageHeight();

				//set max watermarks
				$maxCols = $imageWidth / $config->getMinSize() / 2;
				if ($maxCols < $config->getCols())
				{
					$config->setCols(ceil($maxCols));
				}

				$maxRows = $imageHeight / $config->getMinSize() / 2;
				if ($maxRows < $config->getRows())
				{
					$config->setRows(ceil($maxRows));
				}


				//step width
				$stepWidth  = $imageWidth / $config->getCols();
				$stepHeight = $imageHeight / $config->getRows();

				//put images
				for ($row = 0; $row < $config->getRows(); $row++)
				{
					for ($col = 0; $col < $config->getCols(); $col++)
					{
						$x = rand($col * $stepWidth, ($col + 1) * $stepWidth);
						$y = rand($row * $stepHeight, ($row + 1) * $stepHeight);

						//make sure that watermark is in image bound
						if (($x + $maxWatermarkSize) > $imageWidth)
						{
							$x = $imageWidth - $maxWatermarkSize;
						}

						if (($y + $maxWatermarkSize) > $imageHeight)
						{
							$y = $imageHeight - $maxWatermarkSize;
						}

						//put watermark to image
						$source->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $x, $y);
					}
				}


				//now put logo in right bottom corner




				$logoUrl = dirname($this->_watermarkRand->fileName) . DIRECTORY_SEPARATOR . 'logo_'.c("LANGUAGE").'.png';

				if(false === is_file($logoUrl)){
					$logoUrl = dirname($this->_watermarkRand->fileName) . DIRECTORY_SEPARATOR . 'logo.png';
				}



				$watermark = new \Imagick($logoUrl);

				$size = $imageWidth * 0.3;

				if ($size > 50)
				{
					$watermark->thumbnailImage($size, $size, true);

					$x = $imageWidth - $watermark->getImageWidth();
					$y = $imageHeight - $watermark->getImageHeight();
					$source->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $x, $y);


				}

				$this->_imageStruct->image = imagecreatefromstring($source->getImageBlob());
			}

			return $this->_imageStruct;
		}

		throw new \Exception('File ' . $this->_watermarkRand->fileName . ' not exist!');
	}


	private function getPngBlobFromGd($image)
	{
		ob_start();
		imagepng($image);
		$imageBlob = ob_get_clean();

		return $imageBlob;
	}

}
