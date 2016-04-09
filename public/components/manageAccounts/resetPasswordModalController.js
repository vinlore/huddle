angular.module('resetPasswordModalCtrl', [])
.controller('resetPasswordModalController', function ($scope, $uibModalInstance, popup, isAdmin) {
	
	$scope.password = null;
	$scope.confirm = null;

	$scope.passwordPopover = [
        'AT LEAST 1 letter',
        'AT LEAST 8 characters',
        'AT LEAST 1 number',
        'NO consecutive whitespaces',
        'NO start or end with whitespace'
    ];

	$scope.close = function () {
		$uibModalInstance.close(false);
    }

    $scope.save = function () {
    	if ($scope.resetPasswordForm.$valid) {
			if (($scope.confirm == $scope.password) && isAdmin()) {
		    	var modalInstance = popup.prompt('Reset Password', 'Are you sure you want to override this user\'s password?');

		    	modalInstance.result.then(function(result) {
		    		if (result) {
		    			var password = {
		    				new_password: $scope.password,
		    				new_password_confirmation: $scope.confirm
		    			}
				        $uibModalInstance.close(password);
		    		}
		    	})
			} else {
				popup.error('Error', 'Passwords do not match!');
			}
		}
    }

})