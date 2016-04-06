angular.module( 'draftEventCtrl', [])
.controller( 'draftEventController', function( $scope, Countries, Events, $stateParams, $filter, $location, popup, $state ) {
    $scope.header = "Draft";
    $scope.creation = false;
    $scope.draft = true;
    $scope.event = [];

    $scope.countries = Countries;

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false
    };

    $scope.changeCountry = function (country) {
        $scope.citiesOnly.componentRestrictions = {country: country.code};
    }

    $scope.loadEvent = function(){
      Events.fetch().get( { cid: $stateParams.conference_id, eid: $stateParams.event_id} )
          .$promise.then( function( response ) {
              if ( response ) {
                  var date = response.date.split('-');
                  response.date = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));

                  // Parse start time from database to Date object
                  var time1 = response.start_time.split(':');
                  var startTime = new Date();
                  startTime.setHours(time1[0]);
                  startTime.setMinutes(time1[1]);
                  response.start_time = startTime;

                  // Parse end time from database to Date object
                  var time2 = response.end_time.split(':');
                  var endTime = new Date();
                  endTime.setHours(time2[0]);
                  endTime.setMinutes(time2[1]);
                  response.end_time = endTime;

                  $scope.event = response;
              } else {
                  popup.error( 'Error', response.message );
              }
          })
    }
    $scope.loadEvent();

    $scope.publish = function(){
      var city, address, country;
      if ( $scope.event.city ) {
          city = $scope.event.city;
          if ( $scope.event.city.name ) {
              city = $scope.event.city.name;
          }
      }

      if ( $scope.event.country ) {
          country = $scope.event.country;
          if ( $scope.event.country.name ) {
              country = $scope.event.country.name;
          }
      }

      if ( $scope.event.address) {
          address = $scope.event.address;
          if ( $scope.event.address.formatted_address ) {
              address = $scope.event.address.formatted_address;
          }
      }

      var _event = {
        conference_id: $scope.event.conference_id,
        name: $scope.event.name,
        description: $scope.event.description,
        facilitator: $scope.event.facilitator,
        date: $filter('date')($scope.event.date, 'yyyy-MM-dd'),
        start_time: $filter('date')($scope.event.start_time, 'HH:mm'),
        end_time: $filter('date')($scope.event.end_time, 'HH:mm'),
        address: address,
        city: city,
        country: country,
        age_limit: $scope.event.age_limit,
        gender_limit: $scope.event.gender_limit,
        attendee_count: 0,
        capacity: $scope.event.capacity,
        status: 'approved'
      }
       Events.fetch().update( { cid: $stateParams.conference_id, eid: $stateParams.event_id}, _event )
        .$promise.then( function( response ) {
            if ( response.status == 200 ) {
                popup.alert('success', 'Event has been published!');
                $state.go('requests');
            } else {
                popup.error( 'Error', response.message );
            }
        })
      }

    $scope.submit = function () {
        var city, address, country;
        if ( $scope.event.city ) {
            city = $scope.event.city;
            if ( $scope.event.city.name ) {
                city = $scope.event.city.name;
            }
        }

        if ( $scope.event.country ) {
            country = $scope.event.country;
            if ( $scope.event.country.name ) {
                country = $scope.event.country.name;
            }
        }

        if ( $scope.event.address) {
            address = $scope.event.address;
            if ( $scope.event.address.formatted_address ) {
                address = $scope.event.address.formatted_address;
            }
        }

        var _event = {
          //conference_id: $scope.event.conference_id,
          name: $scope.event.name,
          description: $scope.event.description,
          facilitator: $scope.event.facilitator,
          date: $filter('date')($scope.event.date, 'yyyy-MM-dd'),
          start_time: $filter('date')($scope.event.start_time, 'HH:mm'),
          end_time: $filter('date')($scope.event.end_time, 'HH:mm'),
          address: address,
          city: city,
          country: country,
          age_limit: $scope.event.age_limit,
          gender_limit: $scope.event.gender_limit,
          capacity: $scope.event.capacity,
          status: 'pending'
        }

        Events.fetch().update( { cid: $stateParams.conference_id, eid: $stateParams.event_id }, _event )
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    popup.alert('success', 'Event has been updated!');
                    $state.go('requests');
                }
              })
    }
})
