<?php
namespace ImageStorage\Image;

interface Transformation
{
	/**
	 * @throws \Exception
	 */
	public function __construct();

	/**
	 * @return Struct\Image
	 * @throws \Exception
	 */
	public function transform(Struct\Image $imageStruct);
}
