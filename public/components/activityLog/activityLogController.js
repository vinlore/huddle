angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope, Activity, popup ) {


  $scope.logs = [
    {Time: "01:00:00",
    Date: "Monday March 7, 2016",
    Log: "James created a conference name India"},

    {Time: "02:00:00",
    Date: "Tuesday March 8, 2016",
    Log: "Gabby is requesting to attend Canada conference"},

    {Time: "03:00:00",
    Date: "Wednesday March 9, 2016",
    Log: "Viggy editted France conference"},

    {Time: "04:00:00",
    Date: "Wednesday March 9, 2016",
    Log: "Chris approved Martin's conference attendance"},
    {Time: "01:00:00",
    Date: "Monday March 7, 2016",
    Log: "James created a conference name India"},

    {Time: "02:00:00",
    Date: "Tuesday March 8, 2016",
    Log: "Gabby is requesting to attend Canada conference"},

    {Time: "03:00:00",
    Date: "Wednesday March 9, 2016",
    Log: "Viggy editted France conference"},

    {Time: "04:00:00",
    Date: "Wednesday March 9, 2016",
    Log: "Chris approved Martin's conference attendance"},
  ];

  $scope.logz = []

  $scope.loadActivityLog = function () {
      Activity.query()
          .$promise.then( function( response ) {
              if (response) {
                  $scope.logz = response;
                  //console.log(logz);
              } else {
                  popup.error( 'Error', "Bull shit" );
              }
          }, function () {
              popup.connection();
          })
  }
  $scope.loadActivityLog();

});
