angular.module( 'manageConferenceAttendeesCtrl', [] )
.controller( 'manageConferenceAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Conferences, popup, $uibModal) {

  // Conference ID
  $scope.conferenceId = $stateParams.conferenceId;

  //////// Load Data ////////

  $scope.tableParams = new ngTableParams(
  {
  },
  {
    counts: [],
    getData: function ($defer, params) {
      Conferences.attendees().query( {cid: $scope.conferenceId} )
      .$promise.then( function( response ) {
        if ( response ) {
          $scope.data = response;
          $scope.data = params.sorting() ? $filter('orderBy') ($scope.data, params.orderBy()) : $scope.data;
          $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
          $defer.resolve($scope.data);
        } else {
        }
      }, function () {
        popup.connection();
      })

    }
  });

  //////// Button Functions ////////

  var attend = function(id) {
    Conferences.attendees().update( {cid: $scope.conferenceId, pid: id}, {status: 'approved'})
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to profile_attends_conferences (approve)' );
        popup.alert( 'success', 'User has been approved.' );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })
  }

  $scope.approve = function(attendee) {
    if ( attendee.pivot.arrv_ride_req || attendee.pivot.dept_ride_req || attendee.pivot.accommodation_req ) {
      var modalInstance = $uibModal.open({
        animation: false,
        templateUrl: 'components/manageAttendees/conferenceAttendeeModal.html',
        controller: 'conferenceAttendeeModalController',
        size: 'lg',
        resolve: {
          conferenceId: function () {
            return $stateParams.conferenceId;
          },
          preferences: function () {
            return {
              arrv_ride_req: attendee.pivot.arrv_ride_req,
              dept_ride_req: attendee.pivot.dept_ride_req,
              accommodation_req: attendee.pivot.accommodation_req,
              accommodation_pref: attendee.pivot.accommodation_pref
            }
          }
        }
      })

      modalInstance.result.then( function (result) {
        if (result) {
          attend(attendee.id);
          // TODO store to profile rides and profile stays table
        }
      })
    } else {
      attend(attendee.id);
    }
    $scope.tableParams.reload();
  }

  $scope.deny = function(id) {

    Conferences.attendees().update( {cid: $scope.conferenceId, pid: id}, {status: 'denied'})
    .$promise.then( function( response ) {
      if ( response.status == 200 ) {
        console.log( 'Changes saved to profile_attends_conferences (deny)' );
        popup.alert( 'danger', 'User has been denied.' );
      } else {
        popup.error( 'Error', response.message );
      }
    }, function () {
      popup.connection();
    })

    $scope.tableParams.reload();
  }

});
