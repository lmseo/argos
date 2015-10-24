searchApp.controller('pageListController', ['$scope','Posts','$sce', function($scope, Posts,$sce){
	$scope.search_term = '';
	$scope.isActive = 'true';

	
	$scope.doSearch = function () {
		Posts.getPosts($scope.search_term).then(function(data){
			$scope.posts = data;
			if($scope.posts){
				$scope.isActive = false;
			}else{
				$scope.isActive = true;
			}
		});
    };
}]);