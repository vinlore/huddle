angular.module('managersCtrl', [])
.controller('conferenceManagersController', function ($scope, Managers, $stateParams, popup, Users) {

    $scope.managers = [];
    $scope.users = [];
    $scope.selectedUser = null;

    $scope.loadUsers = function (val) {
        return Users.query({username: val}).$promise.then(function(response) {
            if (response) {
                return response;
            }
        })
    }

    $scope.loadManagers = function () {
        Managers.conferences().query({cid: $stateParams.conferenceId})
            .$promise.then(function(response) {
                if (response) {
                    $scope.managers = response;
                } else {
                    popup.error('Error', response.message);
                }
            })
    }

    $scope.loadManagers();

    $scope.addManager = function (user) {
        if (user)
        Managers.conferences().save({cid: $stateParams.conferenceId}, {user_id: user.id})
            .$promise.then(function(response) {
                if (response.status == 200) {
                    $scope.selectedUser = null;
                    popup.alert('success', user.username + 'is now managing this conference.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.error('Error', 'User is already managing this conference.');
            })
    }

    $scope.removeManager = function (id) {
        var modalInstance = popup.prompt('Remove Manager', 'Are you sure you want to remove this user from managing this conference?');

        modalInstance.result.then( function(result) {
            if (result) {
                Managers.conferences().delete({cid: $stateParams.conferenceId, uid: id})
                    .$promise.then(function(response) {
                        if (response.status == 200) {
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
    }

})

.controller('eventManagersController', function ($scope, Managers, popup, $stateParams, Users) {

    $scope.managers = [];
    $scope.users = [];
    $scope.selectedUser = null;

    $scope.loadUsers = function (val) {
        return Users.query({username: val}).$promise.then(function(response) {
            if (response) {
                return response;
            }
        })
    }

    $scope.loadManagers = function () {
        Managers.events().query({eid: $stateParams.eventId})
            .$promise.then(function(response) {
                if (response) {
                    $scope.managers = response;
                } else {
                    popup.error('Error', response.message);
                }
            })
    }

    $scope.loadManagers();

    $scope.addManager = function (user) {
        if (user)
        Managers.events().save({eid: $stateParams.eventId}, {user_id: user.id})
            .$promise.then(function(response) {
                if (response.status == 200) {
                    $scope.selectedUser = null;
                    popup.alert('success', user.username + 'is now managing this event.');
                    $scope.loadManagers();
                } else {
                    popup.error('Error', response.message);
                }
            }, function () {
                popup.error('Error', 'User is already managing this conference.');
            })
    }

    $scope.removeManager = function (id) {
        var modalInstance = popup.prompt('Remove Manager', 'Are you sure you want to remove this user from managing this event?');

        modalInstance.result.then( function(result) {
            if (result) {
                Managers.events().delete({eid: $stateParams.eventId, uid: id})
                    .$promise.then(function(response) {
                        if (response.status == 200) {
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

    }

})