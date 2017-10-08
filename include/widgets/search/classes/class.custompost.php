<?php



class CustomPost{
	public $postId, $postTitle, $postUrl, $postExcerpt, $postDate, $postImage, $postThumbnail, $postThumbnailWithLink,$postLink;

	function __construct(CustomPostImage $customImage=NULL){
		if(!empty($customImage)){
			$this->setPostImage($customImage);
		}
	}
	public function getPostLink(){
		return $this->postLink;
	}
	public function setPostLink($postUrl, $anchor='',$class=''){
		$cssClass = '';
		if($class!=''){
			$cssClass = 'class="'.$class.'"';
		}
		$this->postLink = '<a href="'.$postUrl.'" '.$cssClass.'>'.$anchor.'</a>';
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
	public function getPostThumbnailWithLink(){
		return $this->postThumbnail;
	}
	public function setPostThumbnailWithLink($postThumbnail='',$url='',$linkClass=''){
		$cssClass = '';
		if($linkClass!=''){
			$cssClass = 'class="'.$linkClass.'"';
		}
		if($url != ''){
			if($postThumbnail != ''){
				$this->postThumbnailWithLink = '<a href="'.$url.'" '.$cssClass.'>'.$postThumbnail.'</a>';
			}else{
				$this->postThumbnailWithLink = '<a href="'.$url.'" '.$cssClass.'>'.'<img width="70" height="70" src="/wp-content/themes/argo/include/widgets/search/images/no-thumbnail.png" class="search-app-img wp-post-image" alt="No Thumbnail Available">'.'</a>';
			}
		}else{
			$this->postThumbnailWithLink = '<img width="70" height="70" src="/wp-content/themes/argo/include/widgets/search/images/no-thumbnail.png" class="search-app-img wp-post-image" alt="No Thumbnail Available">';
		}
	}
	public function getPostImage(){
		return $this->postImage;
	}
	public function setPostImage($postImage){
		$this->postImage = $postImage;
	}
}
?>