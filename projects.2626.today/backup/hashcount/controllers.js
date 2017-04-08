//inject the twitterService into the controller
app.controller('TwitterController', function($scope,$q, twitterService, $http) {

    $scope.tweets=[]; //array of tweets

    twitterService.initialize();

    //using the OAuth authorization result get the latest 20 tweets from twitter for the user
    $scope.refreshTimeline = function(maxId) {
		
		$http({
                    method: "GET",
                    url: 'https://api.twitter.com/1.1/search/tweets.json?q=%23ModiSpeech',
                    dataType: 'jsonp',
                }).then(function (res) {
                    console.log('res: ', res);
                });
		
        twitterService.getLatestTweets(maxId).then(function(data) {
            $scope.tweets = $scope.tweets.concat(data);
        },function(){
            $scope.rateLimitError = true;
        });
    }

    //when the user clicks the connect twitter button, the popup authorization window opens
    $scope.connectButton = function() {
        twitterService.connectTwitter().then(function() {
            if (twitterService.isReady()) {
                //if the authorization is successful, hide the connect button and display the tweets
                $('#connectButton').fadeOut(function(){
                    $('#getTimelineButton, #signOut').fadeIn();
                    $scope.refreshTimeline();
                    $scope.connectedTwitter = true;
                });

            } else {
                
			}
        });
    }

    //sign out clears the OAuth cache, the user will have to reauthenticate when returning
    $scope.signOut = function() {
        twitterService.clearCache();
        $scope.tweets.length = 0;
        $('#getTimelineButton, #signOut').fadeOut(function(){
            $('#connectButton').fadeIn();
			$scope.$apply(function(){$scope.connectedTwitter=false})
        });
        $scope.rateLimitError = false;    
    }

    //if the user is a returning user, hide the sign in button and display the tweets
    if (twitterService.isReady()) {
        $('#connectButton').hide();
        $('#getTimelineButton, #signOut').show();
     		$scope.connectedTwitter = true;
        $scope.refreshTimeline();
    }

});
