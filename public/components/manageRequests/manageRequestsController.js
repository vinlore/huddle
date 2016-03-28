angular.module( 'manageRequestsCtrl', [] )
.controller( 'manageRequestsController', function ($scope, Conferences, Events, popup) {

  // Conference Creation methods

  // show conference creation application
  $scope.viewConferenceApplication = function(index){
    $scope.conferences.splice(index, 1);
  }


  // show events creation application
  $scope.viewEventApplication = function(index){

  }

  $scope.conferences = []
  // TODO: Need to change approved --> pending
  $scope.loadPendingConferences = function () {
      Conferences.status().query({status:'pending'})
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
  $scope.loadPendingConferences();

  $scope.events = []
  // TODO: Need to change approved --> pending
  $scope.loadPendingEvents = function () {
      Events.status().query({status:'pending'})
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
  $scope.loadPendingEvents();

  // ================ Update Conference Status Methods ============== //
  $scope.publishConference = function (index) {
      var conference = {
          id: $scope.conferences[index].id,
          status: 'approved'
      };
      Conferences.status().update({cid: conference.id },{status: conference.status})
          .$promise.then( function (response) {
              if ( response.status == 200 ) {
                  $scope.loadPendingConferences();
                  popup.alert( 'success', 'Conference successfully published.' );
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };

  $scope.declineConference = function (index) {
      var conference = {
          id: $scope.conferences[index].id,
          status: 'denied'
      };
      Conferences.status().update({cid: conference.id },{status: conference.status})
          .$promise.then( function (response) {
              if ( response.status == 200 ) {
                  $scope.loadPendingConferences();
                  popup.alert( 'success', 'Conference request denied.' );
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };

// ================ Update Event Status Methods ============== //
  $scope.publishEvent = function (index) {
      var _event = {
        id: $scope.events[index].id,
        status: 'approved'
      };
      Events.status().update( {eid: _event.id },{status: _event.status})
          .$promise.then( function ( response ) {
              if ( response.status == 200 ) {
                  $scope.loadPendingEvents();
                  popup.alert( 'success', 'Event successfully published.' );
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };


  $scope.declineEvent = function (index) {
      var _event = {
        id: $scope.events[index].id,
        status: 'denied'
      };
      Events.status().update( {eid: _event.id },{status: _event.status})
          .$promise.then( function ( response ) {
              if ( response.status == 200 ) {
                  $scope.loadPendingEvents();
                  popup.alert( 'success', 'Event request denied.' );
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
          })
  };

});
