angular.module( 'conferenceService', [] )
.factory( 'Conference', function ( $resource ) {
    
    return {

        all : function () {
            return $resource( 'mockdata/conferences.json' ).query();
        },

        get : function (cid) {
            return $resource( '/api/conferences/:cid', {cid: cid});
        }
    }

})
