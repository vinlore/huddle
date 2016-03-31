angular.module( 'draftEventCtrl', [])
.controller( 'draftEventController', function( $scope, Countries, Events, $stateParams, $filter, $location, popup, $state ) {
    $scope.header = "Draft";
    $scope.creation = false;
    $scope.draft = true;


    $scope.citiesOnly = {
        types: ['(cities)']
    };

    $scope.addressOnly = {
        types: ['address']
    }

    $scope.calendar = {
        isOpen1: false
    };

    $scope.loadEvent = function(){
      Events.fetch().get( { cid: $stateParams.conference_id, eid: $stateParams.event_id} )
          .$promise.then( function( response ) {
              if ( response ) {
                  //console.log(response);
                  $scope.event = response;
              } else {
                  popup.error( 'Error', response.message );
              }
          }, function () {
              popup.connection();
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
        start_time: $filter('time')($scope.event.start_time),
        end_time: $filter('time')($scope.event.end_time),
        address: address,
        city: city,
        country: country,
        age_limit: String($scope.event.age_limit),
        gender_limit: $scope.event.gender_limit,
        attendee_count: 0,
        capacity: $scope.event.capacity,
        status: 'approved'
      }
       Events.fetch().update( { cid: $stateParams.conference_id, eid: $stateParams.event_id}, _event )
        .$promise.then( function( response ) {
            if ( response.status == 200 ) {
                $state.go('requests');
            } else {
                popup.error( 'Error', response.message );
            }
        }, function () {
            popup.connection();
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
          start_time: $filter('time')($scope.event.start_time),
          end_time: $filter('time')($scope.event.end_time),
          address: address,
          city: city,
          country: country,
          age_limit: String($scope.event.age_limit),
          gender_limit: $scope.event.gender_limit,
          attendee_count: 0,
          capacity: $scope.event.capacity,
          status: 'pending'
        }

        Events.fetch().update( { cid: $stateParams.conference_id, eid: $stateParams.event_id }, _event )
            .$promise.then( function( response ) {
                if ( response.status == 200 ) {
                    $state.go('requests');
                } else {
                    popup.error( 'Error', response.message );
                }
            }, function () {
                popup.connection();
            })
    }
})
