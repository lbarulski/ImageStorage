<?php
namespace ImageStorage\Image\Structure;

class WatermarkRand
{

	/**
	 * @var null|string
	 *
	 */
	public $fileName;

	/**
	 * @var int
	 *
	 * How many markers should be in one col
	 */
	public $cols = 2;

	/**
	 * @var int
	 *
	 * How many markers should be in one row
	 */
	public $rows = 5;


	/**
	 * @var float
	 *
	 * Ratio to full image
	 */
	public $size = 0.05;


	/**
	 * @var int
	 *
	 * Min size
	 */
	public $minSize = 15;

	/**
	 * @param string|null $fileName
	 */
	public function __construct($fileName = null)
	{
		$this->fileName = $fileName;
	}

	/**
	 * @return int
	 */
	public function getCols()
	{
		return $this->cols;
	}

	/**
	 * @return int
	 */
	public function getRows()
	{
		return $this->rows;
	}

	/**
	 * @return float
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @return int
	 */
	public function getMinSize()
	{
		return $this->minSize;
	}


	/**
	 * @param int $v
	 *
	 * @return $this
	 */
	public function setCols($v)
	{
		$this->cols = $v;

		return $this;
	}

	/**
	 * @param int $v
	 *
	 * @return $this
	 */
	public function setRows($v)
	{
		$this->rows = $v;

		return $this;
	}

}
