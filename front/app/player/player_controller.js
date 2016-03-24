rune.controller('PlayerController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $scope.volume = "";

        $scope.reset = function () {
            $scope.playing = "";
            $scope.track = "";
            $scope.artist = "";
            $scope.album = "";
            $scope.albumArtist = "";
            $scope.date = "";
            $scope.file = "";
            $scope.song_number = 0;
            $scope.playlist_length = 0;
        };

        // start music
        $scope.player_start = function (){
            $http.get($rootScope.root + '/player/play')
                .then(function(response){
                    console.log("=== PLAY ===");
                    $rootScope.player_status();
                });

            $scope.playing = true;
        };

        // stop music
        $scope.player_pause = function (){
            $http.get($rootScope.root + '/player/pause')
                .then(function(response){
                    console.log("=== pause ===");
                });

            $scope.playing = false;
        };

        // previous music
        $scope.player_previous = function (){
            $http.get($rootScope.root + '/player/previous')
                .then(function(response){
                    console.log("=== PREVIOUS ===");
                    $rootScope.player_status();
                })
        };

        // next music
        $scope.player_next = function (){
            $http.get($rootScope.root + '/player/next')
                .then(function(response){
                    console.log("=== NEXT ===");
                    $rootScope.player_status();
                })
        };

        // volume music
        $scope.player_volume = function (){
            $http.get($rootScope.root + '/volume/' + $scope.volume)
                .then(function(response){
                    console.log("=== VOLUME ===");
                })
        };

        // get current track info
        $scope.current_track = function () {
            $http.get($rootScope.root + '/song')
                .then(function(response){
                    console.log(response);
                    $scope.track = response.data.song[0].Title;
                    $scope.artist = response.data.song[0].Artist;
                    $scope.album = response.data.song[0].Album;
                    $scope.albumArtist = response.data.song[0].AlbumArtist;
                    $scope.date = response.data.song[0].Date;
                    $scope.file = response.data.song[0].file;
                })
        };

        // get player infos (playing or not, time elapsed...)
        $rootScope.player_status = function () {
            $http.get($rootScope.root + '/playerStatus')
                .then(function(response){
                    console.log(response);
                    $scope.volume = response.data.infos[0].volume;
                    if(response.data.infos[0].state == "play") {
                        $scope.current_track();
                        $scope.playing = true;
                        $scope.song_number = response.data.infos[0].song;
                        $scope.song_number ++;
                        $scope.playlist_length = response.data.infos[0].playlistlength;
                    }else{
                        $scope.playing = false;
                        $scope.reset();
                    }
                })
        };

        // to know if player is playing
        $scope.reset();
        $rootScope.player_status();
    }]
);
