angular.module( 'manageRequestsCtrl', [] )
.controller( 'manageRequestsController', function ($scope) {

  $scope.user = {};

  $scope.removeFamilyMember = function (index) {
    $scope.familymembers.splice(index, 1);
  }

  //$scope.loadPendingConferenceCreations = function() {};
  //$scope.loadPendingConferenceAttendees = function() {};

  //$scope.loadPendingEventCreations = function() {};
  //$scope.loadPendingEventAttendees = function() {};

  $scope.conferencePendingCreations = [
      {
          id: 123,
          name: "Bill Gates",
          conference_name: "India",
          startDate: "Feb 20, 2016",
          endDate: "Feb 27, 2016",
      },
      {
          id: 234,
          name: "Tony Montana",
          conference_name: "Canada",
          startDate: "Jan 29, 2016",
          endDate: "Feb 3, 2016"
      },
      {
          id: 1,
          name: "Michael Jackson",
          conference_name: "France",
          startDate: "Jan 5, 2016",
          endDate: "Jan 12, 2016"
      }
  ];

  $scope.eventsPendingCreations = [
      {
          id: 123,
          name: "Bill Gates",
          event_name: "Event1",
          startDate: "Feb 20, 2016",
          endDate: "Feb 27, 2016",
      },
      {
          id: 234,
          name: "Felix",
          event_name: "Event2",
          startDate: "Jan 29, 2016",
          endDate: "Feb 3, 2016"
      },
      {
          id: 1,
          name: "Freddy",
          event_name: "Event3",
          startDate: "Jan 5, 2016",
          endDate: "Jan 12, 2016"
      },
      {
          id: 1,
          name: "Jessica",
          event_name: "Event4",
          startDate: "Jan 5, 2016",
          endDate: "Jan 12, 2016"
      }
  ];

  $scope.acceptConfRequest = function (index) {
    $scope.conferencePendingCreations.splice(index, 1);
  }
});
