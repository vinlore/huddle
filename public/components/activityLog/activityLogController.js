angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope ) {

  $scope.log = {
      "Time": null,
      "Date": null,
      "Log Message": null,
  };

  $scope.logs = [
    {Time: "01:00:00",
     Date: "Monday March 7, 2016",
     Log: "This is log 1"},

    {Time: "02:00:00",
      Date: "Tuesday March 8, 2016",
      Log: "This is log 2"},

    {Time: "03:00:00",
       Date: "Wednesday March 9, 2016",
       Log: "This is log 3"},

    {Time: "04:00:00",
        Date: "Thursday March 10, 2016",
        Log: "This is log 4"}
    ];

});
