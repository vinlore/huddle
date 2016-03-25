angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope ) {


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

  // $scope.loadActivityLog = function () {
  //     Conferences.attendees().get( {cid: $stateParams.conferenceId} )
  //         .$promise.then( function( response ) {
  //             if ( response.status == 'success' && response.logs ) {
  //                 $scope.logs = response.logs;
  //             } else {
  //                 popup.error( 'Error', response.message );
  //             }
  //         }, function () {
  //             popup.connection();
  //         })
  // }
  //
  // $scope.loadActivityLog();
});
