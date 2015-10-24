<?php



class CustomPost{
	public $postId, $postTitle, $postUrl, $postExcerpt, $postDate, $postImage, $postThumbnail;

	function __construct(CustomPostImage $customImage=NULL){
		if(!empty($customImage)){
			$this->setPostImage($customImage);
		}
	}

	public function getPostId(){
		return $this->postId;
	}
	public function setPostID($postId){
		$this->postId = $postId;
	}

	public function getPostTitle(){
		return $this->postTitle;
	}
	public function setPostTitle($postTitle){
		$this->postTitle = $postTitle;
	}

	public function getPostUrl(){
		return $this->postUrl;
	}
	public function setPostUrl($postUrl){
		$this->postUrl = $postUrl;
	}

	public function getPostExcerpt(){
		return $this->postExcerpt;
	}
	public function setPostExcerpt($postExcerpt){
		$this->postExcerpt = $postExcerpt;
	}

	public function getPostDate(){
		return $this->postDate;
	}
	public function setPostDate($postDate){
		$this->postDate = $postDate;
	}

	public function getPostThumbnail(){
		return $this->postThumbnail;
	}
	public function setPostThumbnail($postThumbnail){
		$this->postThumbnail = $postThumbnail;
	}
	public function getPostImage(){
		return $this->postImage;
	}
	public function setPostImage($postImage){
		$this->postImage = $postImage;
	}
}
?>