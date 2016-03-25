angular.module( 'customDirs', [] )
.directive( 'ngVisible', function() {
    return function( scope, elm, attr ) {
        scope.$watch( attr.ngVisible, function( visible ) {
            elm[visible ? 'removeClass' : 'addClass']('invisible');;
        });
    };
})

.directive('errSrc', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element[0].onerror = function () {
                element[0].className = element[0].className + " image-error";
                element[0].removeAttribute('ng-src');
                element[0].removeAttribute('src');
            };
        }
    }
})

.directive('backImg', function () {
    return function( scope, element, attrs ) {
        attrs.$observe( 'backImg', function( value ) {
            element.css({
                'background-image': 'url(assets/img/overlay.png), url(' + value + ')'
            })
        })
    }
})

.directive('isApproved', function () {
    return {
        restrict: 'A',
        scope: {
            status: '='
        },
        link: function (scope, element, attrs) {
            switch (scope.status) {
                case 'approved': 
                    element[0].className = "alert status-approved";
                    break;
                case 'denied':
                    element[0].className = "alert status-denied";
                    break;
                default:
                    element[0].className = "alert status-pending";
                    break;
            }
        }
    }
} )