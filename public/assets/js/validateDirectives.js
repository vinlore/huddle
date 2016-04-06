var app = angular.module( 'validateDirectives', [] );

var USERNAME_REGEXP = /^[a-zA-Z0-9]+[_.-]{0,1}[a-zA-Z0-9]+$/;
app.directive( 'username', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.username = function( modelValue, viewValue ) {
                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                // Match regexp
                if ( USERNAME_REGEXP.test( viewValue ) && viewValue.length >= 4 ) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})

// No whitespace at both ends, no consecutive whitespaces
var PASSWORD_REGEXP_SPACE = /^\S+(?: \S+)*$/;
// At least 1 number
var PASSWORD_REGEXP_NUM = /.*[0-9]+.*/;
app.directive( 'password', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.password = function( modelValue, viewValue ) {
                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }
 
                var PASSWORD_REGEXP = PASSWORD_REGEXP_SPACE.test( viewValue ) && PASSWORD_REGEXP_NUM.test( viewValue ) && viewValue.length >= 8;
                if ( PASSWORD_REGEXP ) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})

app.directive( 'confirmPassword', function () {
    return {
        require: 'ngModel',
        scope: {
        	confirmPassword: '='
        },
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.confirmPassword = function( modelValue, viewValue ) {
                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                // Match regexp
                if ( scope.confirmPassword == viewValue ) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})

// All letters with option of hyphen and commas (non-consecutively)
var NAME_REGEXP = /^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,(0-9)]$/;
app.directive( 'names', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.names = function( modelValue, viewValue ) {

                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                // Match regexp
                if ( NAME_REGEXP.test( viewValue )) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})

var PHONE_REGEXP = /^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/;
app.directive( 'phone', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.phone = function( modelValue, viewValue ) {

                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                // Match regexp
                if ( PHONE_REGEXP.test( viewValue )) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})

app.directive( 'birthdate', function ($filter) {
	return {
		require: 'ngModel',
		link: function ( scope, elm, attrs, ctrl ) {
			ctrl.$validators.birthdate = function( modelValue, viewValue ) {

				// Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                var today = new Date();
                var date = $filter('date')(viewValue, 'yyyy-MM-dd');
                date = date.split('-');
                var enteredDate = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));
                if ( !enteredDate ) {
                	return false;
                }

                if ( enteredDate < today ) {
                    return true;
                }

                return false;

			}
		}
	}
})

app.directive( 'futureDate', function ($filter) {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.futureDate = function( modelValue, viewValue ) {

                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                var today = new Date();
                var date = $filter('date')(viewValue, 'yyyy-MM-dd');
                date = date.split('-');
                var enteredDate = new Date(parseInt(date[0]), parseInt(date[1])-1, parseInt(date[2]));
                if ( !enteredDate ) {
                    return false;
                }

                if ( enteredDate > today ) {
                    return true;
                }

                return false;

            }
        }
    }
})

var EMAIL_REGEX = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/;
app.directive( 'overwriteEmail', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            ctrl.$validators.email = function( modelValue, viewValue ) {

                // Empty models are valid
                if ( ctrl.$isEmpty( modelValue ) ) {
                    return true;
                }

                // Match regexp
                if ( EMAIL_REGEX.test( viewValue )) {
                    return true;
                }

                // Doesn't match
                return false;
            }
        }
    }
})