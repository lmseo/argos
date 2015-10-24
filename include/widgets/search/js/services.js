searchApp.factory('Posts', ['$http', function($http){
	return {
		getPosts: function (search_term){
			var response = $http({
				url: ajax_url,
				method: 'GET',
				params:{
					action: 'lmseo_ajax_retrieve_posts_wp_query_with_class',
					term: search_term}
			}).then(function (response){
				return response.data;
			});
			return response;
		}
	}
}]);

