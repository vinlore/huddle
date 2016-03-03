angular.module ( 'activityCtrl', [] )
.controller('activityLogController', function ( $scope ) {

  $scope.log = {
      "Time": null,
      "Date": null,
      "Log Message": null,
  };

  $scope.logs = [
    {Time: "01:00:00",
     Date: "Monday February 8, 2016",
     Log: "This is a log 1"},

    {Time: "02:00:00",
      Date: "Tuesday February 9, 2016",
      Log: "This is a log 2"},

    {Time: "03:00:00",
       Date: "Wednesday February 10, 2016",
       Log: "This is a log 3"},

    {Time: "04:00:00",
        Date: "Thursday February 11, 2016",
        Log: "This is a log 4"}
    ];

});
