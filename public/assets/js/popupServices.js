var app = angular.module( 'popupServices', [] );

app.factory( 'popup', function ( $uibModal, $rootScope ) {
    return {

        prompt: function ( title, body ) {
            return $uibModal.open( {
                templateUrl: 'shared/popup/popupPrompt.html',
                controller: 'popupController',
                size: 'md',
                windowClass: 'center-modal',
                animation: false,
                resolve: {
                    content: function () {
                        return {
                            title: title,
                            body: body
                        }
                    }
                }
            } )
        },

        warning: function ( title, body ) {
            return $uibModal.open( {
                templateUrl: 'shared/popup/popupWarning.html',
                controller: 'popupController',
                size: 'md',
                windowClass: 'center-modal',
                animation: false,
                resolve: {
                    content: function () {
                        return {
                            title: title,
                            body: body
                        }
                    }
                }
            } )
        },

        error: function ( title, body ) {
            return $uibModal.open( {
                templateUrl: 'shared/popup/popupError.html',
                controller: 'popupController',
                size: 'md',
                windowClass: 'center-modal',
                animation: false,
                resolve: {
                    content: function () {
                        return {
                            title: title,
                            body: body
                        }
                    }
                }
            } )
        },

        connection: function () {
            return $uibModal.open( {
                templateUrl: 'shared/popup/popupError.html',
                controller: 'popupController',
                size: 'md',
                windowClass: 'center-modal',
                animation: false,
                resolve: {
                    content: function () {
                        return {
                            title: 'Error',
                            body: 'Could not connect to the server. Please try again later.'
                        }
                    }
                }
            } )
        },

        alert: function ( type, message ) {
            $rootScope.alerts.push( {
                type: type,
                msg: message
            } )
        }
    }
} );
