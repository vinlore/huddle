angular.module( 'manageConferenceAttendeesCtrl', [] )
.controller( 'manageConferenceAttendeesController', function ($scope) {

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

  // Conference Creation methods

  // show conference creation application
  $scope.viewConfCreationApplication = function(index){
    $scope.conferencePendingCreations.splice(index, 1);
  }

  // change conference from pending to publish
  $scope.publishConfCreationRequest = function (index) {
    $scope.conferencePendingCreations.splice(index, 1);
  }

  // decline creation requests
  $scope.declineConfCreationRequest = function (index) {
    $scope.conferencePendingCreations.splice(index, 1);
  }


  // Event Creation methods

  // show events creation application
  $scope.viewEventsCreationApplication = function(index){
    $scope.eventsPendingCreationssplice(index, 1);
  }

  $scope.publishEventsCreationRequest = function (index) {
    $scope.eventsPendingCreations.splice(index, 1);
  }

  $scope.declineEventsCreationRequest = function (index) {
    $scope.eventsPendingCreations.splice(index, 1);
  }

  $scope.conferences = []

  $scope.loadConferenceAttendees = function () {
      Conferences.fetch().query()
          .$promise.then( function ( response ) {
              if ( response ) {
                  $scope.conferences = response;
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };
  $scope.loadConferences();

  $scope.events = []

  $scope.loadConferenceAttendees = function () {
      Events.fetch().query()
          .$promise.then( function ( response ) {
              if ( response ) {
                  $scope.events = response;
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };
  $scope.loadEvents();

});
