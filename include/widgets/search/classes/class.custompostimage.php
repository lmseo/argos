<?php
class CustomPostImage{
	public $imageSource, $imageHeight, $imageWidth, $imageAlt;

	function __construct(){
		//$this->setPosts($posts_array);
	}

	public function getImageSource(){
		return $this->imageSource;
	}
	public function setImageSource($imageSource){
		$this->imageSource = $imageSource;
	}

	public function getImageHeight(){
		return $this->imageHeight;
	}
	public function setImageHeight($imageHeight){
		$this->imageHeight = $imageHeight;
	}

	public function getImageWidth(){
		return $this->imageWidth;
	}
	public function setImageWidth($imageWidth){
		$this->imageWidth = $imageWidth;
	}

	public function getPostImageAlt(){
		return $this->imageAlt;
	}
	public function setPostImageAlt($imageAlt){
		$this->imageAlt = $imageAlt;
	}
}
?>