angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope, Activity, popup, Users ) {


//
  $scope.logs = []

  // $scope.loadProfile = function (_id) {
  //   Users.get({id: _id})
  //       .$promise.then (function (response ){
  //         if (response){
  //           console.log(response);
  //         } else {
  //
  //         }
  //       }, function () {
  //         popup.connection();
  //       })
  // }

  $scope.loadActivityLog = function () {
      Activity.query()
          .$promise.then( function( response ) {
              if (response) {
                  console.log(response);
                  $scope.logs = response;
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  }
  $scope.loadActivityLog();
});
