angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope, Activity, popup ) {


//
  $scope.logs = []

  $scope.loadActivityLog = function () {
      Activity.query()
          .$promise.then( function( response ) {
              if (response) {
                  console.log(response);
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  }
  $scope.loadActivityLog();
});
