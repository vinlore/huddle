angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope, Profile, Activity, popup ) {


//
  $scope.logs = []

  $scope.filterActivityLog = function(arr){
      for(var i=0; i < arr.length; i++){
        var obj = {
          user_id: arr[i].user_id,
          source_id: arr[i].source_id,
          source_type: arr[i].source_type,
          profile_id: arr[i].profile_id,
          activity_type: arr[i].activity_type,
        }
        var activity = "";
        if(!(obj.profile_id == null)){
          activity = "User " + obj.user_id + " " + obj.activity_type + " " + obj.source_type + " for Profile " + obj.profile_id;

        } else {
          var activity = "User " + obj.user_id + " " + obj.activity_type + " " + obj.source_type + " : " + obj.source_id;
        }
        var object = {
          type: activity,
          date: arr[i].created_at,
        }
        $scope.logs.push(object);
      }
      console.log($scope.logs.length);
  }

  $scope.loadActivityLog = function () {
      Activity.query()
          .$promise.then( function( response ) {
              if (response) {
                  $scope.filterActivityLog(response);
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  }
  $scope.loadActivityLog();
});
