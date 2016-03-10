angular.module( 'conferenceService', [] )
.factory( 'Conference', function ( $resource ) {
    
    return {

        all : function () {
            return $resource( 'mockdata/conferences.json' ).query();
        },

        get : function (cid) {
            var conference;
            var conferences = $resource( 'mockdata/conferences.json' ).query().$promise.then(function(result) {
                angular.forEach(result, function(value, key) {
                    if (value.conferenceId == cid) {
                        conference = value;
                    }
                });
            });
            return conference;
        }
    }

})
