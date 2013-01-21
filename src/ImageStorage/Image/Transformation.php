<?php
namespace ImageStorage\Image;

interface Transformation
{
	/**
	 * @throws \Exception
	 */
	public function __construct();

	/**
	 * @return Structure\Image
	 * @throws \Exception
	 */
	public function transform(Structure\Image $imageStruct);
}
