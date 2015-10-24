searchApp.controller('pageListController', ['$scope','Posts', function($scope, Posts){
	$scope.search_term = '';
	$scope.doSearch = function () {
		Posts.getPosts($scope.search_term).then(function(data){
			$scope.posts = data;
			console.log($scope.posts);
			if($scope.posts){
				return true;
			}else{
				return false;
			}
		});
    };
}]);

searchApp.config(function($stateProvider, $urlRouterProvider) {
	$urlRouterProvider.otherwise("");
	$stateProvider.state('search', {
		url: "",
		template: "<h1>This is home!</h1><input type='button' value='go To private State' ng-click='goToEmpty()' /><input type='button' value='go To Public State' ng-click='goToSearchState()' /><div ui-view></div>",
		controller: function($scope,$state,doSearch) {
			if(doSearch()){
				$state.go('search.empty')
			}else{
				$state.go('search.query')
			}

			$scope.goToSearchState=function(){
				$state.go('search.query')
			};
			$scope.goToEmpty=function(){
				$state.go('search.empty')
			};
		}
	}).state('search.query', {
		url: "",
		template: '<h1>This is public</h1><ul><li data-ng-repeat="post in posts | orderBy:\'postTitle\'"><a href="{{post.postUrl}}"><img src="{{post.postThumbnail.imageSource}}" width="{{post.postThumbnail.imageWidth}}" height="{{post.postThumbnail.imageHeight}}" alt="{{post.postThumbnail.imageAlt}}"></a><a href="{{post.postUrl}}"> {{post.postTitle | uppercase}}</a><p> {{post.postDate}}</p><p>{{post.postExcerpt}}</p></li></ul>',
		controller: function($scope) {
		}
	}).state('search.empty', {
		url: "",
		template: '<h1>This is private</h1>',
		controller: function($scope) {

		}
	})
});