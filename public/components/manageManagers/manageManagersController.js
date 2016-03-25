angular.module('managersCtrl', [])
.controller('conferenceManagersController', function ($scope, Conferences, $stateParams, popup, Users) {
    
    $scope.managers = [];
    $scope.users = [];
    $scope.selectedUser = null;

    $scope.loadUsers = function () {
        Users.query().$promise.then(function(response) {
            if (response) {
                $scope.users = response;
            } else {
                popup.error('Error', response.message);
            }
        }, function () {
            popup.connection();
        })
    }

    $scope.loadUsers();

    $scope.loadManagers = function () {
        Conferences.managers().query({cid: $stateParams.conferenceId})
            .$promise.then(function(response) {
                if (response) {
                    $scope.managers = response;
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })   
    }

    //$scope.loadManagers();
    
    $scope.addManager = function (user) {
        Conferences.managers().save({cid: $stateParams.conferenceId}, user.id)
            .$promise.then(function(response) {
                if (response.status == 'success') {
                    popup.alert('success', user.username + 'is now managing this conference.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.removeManager = function (id) {
        Conferences.managers().delete({cid: $stateParams.conferenceId, mid: id})
            .$promise.then(function(response) {
                if (response.status == 'success') {
                    popup.alert('success', 'User is no longer managing this conference.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })
    }

})

.controller('eventManagersController', function ($scope, Events, popup, $stateParams) {

    $scope.managers = [];
    $scope.selectedUser = null;

    $scope.loadManagers = function () {
        Events.managers().query({cid: $stateParams.conferenceId, eid: $stateParams.eventId})
            .$promise.then(function(response) {
                if (response) {
                    $scope.managers = response;
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })   
    }

    //$scope.loadManagers();
    
    $scope.addManager = function (user) {
        Events.managers().save({cid: $stateParams.conferenceId, eid: $stateParams.eventId}, user.id)
            .$promise.then(function(response) {
                if (response.status == 'success') {
                    popup.alert('success', 'User is now managing this event.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })
    }

    $scope.removeManager = function (id) {
        Conferences.managers().delete({cid: $stateParams.conferenceId, eid: $stateParams.eventId, mid: id})
            .$promise.then(function(response) {
                if (response.status == 'success') {
                    popup.alert('success', 'User is no longer managing this event.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.connection();
            })
    }

})