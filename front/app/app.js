var rune = angular.module('rune', ['ui.materialize']).config(function($sceProvider) {
    // Completely disable SCE.  For demonstration purposes only!
    // Do not use in new projects.
    $sceProvider.enabled(false);
});

$(function(){
    $("#iframe").contents().find("span").hide();
});