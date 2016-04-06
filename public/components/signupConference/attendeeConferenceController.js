var app = angular.module('attendeeConfCtrl', []);
app.controller('attendeeConferenceController', function($scope, $stateParams, Conferences, Countries, Profile, popup, $rootScope, $filter, $state) {

    $scope.calendar = [];
    $scope.today = new Date();

    $scope.accordionIsOpen = [];
    $scope.countries = Countries;
    $scope.header = "Application";

    $scope.conference = {
        conference_id: $stateParams.conference_id,
        name: $stateParams.conference_name
    }

    $scope.changeCountry = function(country) {
        $scope.citiesOnly.componentRestrictions = { country: country.code };
    };

    $scope.citiesOnly = {
        types: ['(cities)']
    };

    var createDate = function (date) {
        if (date) {
            var input = date.split('-');
            return new Date(parseInt(input[0]), parseInt(input[1])-1, parseInt(input[2]));
        } else {
            return null;
        }
    }

    var createDateTime = function (time) {
        if (time) {
            var input = time.split(':');
            var newTime = new Date();
            newTime.setHours(input[0]);
            newTime.setMinutes(input[1]);
            return newTime;
        } else {
            return null;
        }
    }

    $scope.loadAttendeeProfile = function() {
        Conferences.attendees().get({ cid: $stateParams.conference_id, pid: $stateParams.profile_id })
            .$promise.then(function(response) {
                if (response) {
                    response.pivot.birthdate = createDate(response.pivot.birthdate);
                    response.pivot.arrv_date = createDate(response.pivot.arrv_date);
                    response.pivot.dept_date = createDate(response.pivot.dept_date);
                    response.pivot.arrv_time = createDateTime(response.pivot.arrv_time);
                    response.pivot.dept_time = createDateTime(response.pivot.dept_time);
                    $scope.user = response.pivot;
                } else {
                    popup.error('Error', response.message);
                }
            }, function() {
                popup.connection();
            })
    };
    $scope.loadAttendeeProfile();

    $scope.accommodations = [];
    $scope.loadAccommodations = function() {
        Conferences.accommodations().query({ cid: $stateParams.conference_id })
            .$promise.then(function(response) {
                if (response) {
                    $scope.accommodations = response;
                    //console.log(response);
                } else {
                    // TODO error
                }
            })
    }
    $scope.loadAccommodations();

    $scope.resetFields = function (object) {
        angular.forEach(object, function (value, key) {
            if (typeof(object[key]) === 'boolean') {} else {
                object[key] = null;
            }
        })
    }

    $scope.submitRequest = function() {
        if ($scope.profileForm.$valid && $scope.contactForm.$valid && $scope.arrivalForm.$valid && $scope.departureForm.$valid && $scope.accommForm.$valid) {
            var city, country = null;
            if ( $scope.user.city ) {
                city = $scope.user.city;
                if ( $scope.user.city.formatted_address ) {
                    city = $scope.user.city.formatted_address;
                }
            }

            if ( $scope.user.country ) {
                country = $scope.user.country;
                if ( $scope.user.country.name ) {
                    country = $scope.user.country.name;
                }
            }

            var profile = {
                first_name: $scope.user.first_name,
                middle_name: $scope.user.middle_name,
                last_name: $scope.user.last_name,
                birthdate: $filter('date')($scope.user.birthdate, 'yyyy-MM-dd'),
                gender: $scope.user.gender,
                country: country,
                city: city,
                email: $scope.user.email,
                phone: $scope.user.phone,
                phone2: $scope.user.phone2,
                medical_conditions: $scope.user.medical_conditions,
                contact_first_name: $scope.user.contact_first_name,
                contact_last_name: $scope.user.contact_last_name,
                contact_email: $scope.user.contact_email,
                contact_phone: $scope.user.contact_phone,
                arrv_time: $filter('date')($scope.user.arrv_time, 'HH:mm'),
                arrv_date: $filter('date')($scope.user.arrv_date, 'yyyy-MM-dd'),
                arrv_airport: $scope.user.arrv_airport,
                arrv_ride_req: $scope.user.arrv_ride_req,
                dept_ride_req: $scope.user.dept_ride_req,
                dept_airport: $scope.user.dept_airport,
                dept_time: $filter('date')($scope.user.dept_time, 'HH:mm'),
                dept_date: $filter('date')($scope.user.dept_date, 'yyyy-MM-dd'),
                accommodation_req: $scope.user.accommodation_req,
                accommodation_pref: $scope.user.accommodation_pref
            }

            Conferences.attendees().update({ cid: $stateParams.conference_id, pid: $stateParams.profile_id }, profile)
                .$promise.then(function(response) {
                    if (response.status == 200) {
                        $state.go('profile');
                        popup.alert('success', "Conference profile successfully updated!");
                    } else {
                        popup.error('Error', response.message);
                    }
                }, function() {
                    popup.connection();
                })
        }
    };
})
