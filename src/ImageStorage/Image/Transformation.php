<?php
namespace ImageStorage\Image;

interface Transformation
{
	/**
	 * @param Struct\Image $imageStruct
	 */
	public function __construct(Struct\Image $imageStruct);
	public function transform();
}
