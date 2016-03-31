angular.module( 'manageEventAttendeesCtrl', [] )
.controller( 'manageEventAttendeesController', function ($scope, ngTableParams, $stateParams, $filter, Events, popup) {

	// Event ID
	$scope.eventId = $stateParams.eventId;

	$scope.radioModel = '';

	$scope.csvData = [];

	//////// Load Data ////////

    $scope.load = function() {
		$scope.tableParams = new ngTableParams(
		  {
		  	filter: {
                'pivot.status' : $scope.radioModel
            }
		  },
		  {
		    counts: [],
		    getData: function ($defer, params) {
		      	// organize filter as $filter understand it (graph object)
                var filters = {};
                angular.forEach(params.filter(), function(val, key) {
                    var filter = filters;
                    var parts = key.split('.');
                    for (var i = 0; i < parts.length; i++) {
                        if (i != parts.length - 1) {
                            filter[parts[i]] = {};
                            filter = filter[parts[i]];
                        } else {
                            filter[parts[i]] = val;
                        }
                    }
                })

			    Events.attendees().query( {eid: $scope.eventId} )
			      .$promise.then( function( response ) {
			        if ( response ) {
			          	$scope.data = response;

			          	console.log(JSON.stringify(params.filter()));

                       	// filter with $filter (don't forget to inject it)
                        var filteredDatas =
                            params.filter() ?
                            $filter('filter')($scope.data, filters) :
                            $scope.data;

                        // ordering
                        var sorting = params.sorting();
                        var key = sorting ? Object.keys(sorting)[0] : null;
                        var orderedDatas = sorting ? $filter('orderBy')(filteredDatas, key, sorting[key] == 'desc') : filteredDatas;

                        $defer.resolve(orderedDatas);
                        $scope.setCSVData(orderedDatas);
			        } else {
			          popup.error( 'Error', response.message );
			        }
			      }, function () {
			        popup.connection();
			      })

		    }
		});
	}

	$scope.loadEventData = function() {
    Events.fetch().get({cid: $stateParams.conferenceId, eid: $stateParams.eventId})
    .$promise.then( function( response ) {
      if ( response ) {
        $scope.event = response;
      } else {
        popup.error( 'Error', response.message );
      }}, function () {
        popup.connection();
      })
  	};

	$scope.load();
	$scope.loadEventData();

	//////// Button Functions ////////

  	$scope.approve = function(id) {

	    Events.attendees().update( {eid: $scope.eventId, pid: id}, {status: 'approved'})
	    .$promise.then( function( response ) {
	      if ( response.status == 200 ) {
	        console.log( 'Changes saved to profile_attends_events (approve)' );
	        popup.alert( 'success', 'Approve success.' );
	      } else {
	        popup.error( 'Error', response.message );
	      }
	    }, function () {
	      popup.connection();
	    })

	    $scope.tableParams.reload();
	}

  	$scope.deny = function(id) {

	    Events.attendees().update( {eid: $scope.eventId, pid: id}, {status: 'denied'})
	    .$promise.then( function( response ) {
	      if ( response.status == 200 ) {
	        console.log( 'Changes saved to profile_attends_events (deny)' );
	        popup.alert( 'success', 'Deny success.' );
	      } else {
	        popup.error( 'Error', response.message );
	      }
	    }, function () {
	      popup.connection();
	    })

	    $scope.tableParams.reload();
	 }

	 $scope.setCSVData = function(data) {
        //console.log(JSON.stringify(data));
        $scope.csvData = [];
        var temp = {};
        angular.forEach(data, function(item) {
          angular.forEach(item, function(value, key) {
            if (key == "pivot") {
                temp['status'] = value.status;
            }
            else if ( key == "first_name" || key == "middle_name" || key == "last_name" ||
                key == "birthdate" || key == "gender" || key == "email" || key == "phone" ||
                key == "phone2") {
                temp[key] = value;
            }
          });
          // console.log(JSON.stringify(temp));
          $scope.csvData.push(temp);
          temp = {}
    });
  }

});
