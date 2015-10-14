// Generated by CoffeeScript 1.4.0
(function() {

  angular.element(document).ready(function() {
    angular.module("wordLiftOptions", []).service("OptionService", [
      "$http", "$rootScope", "$log", function($http, $rootScope, $log) {
        return {
          get: function(key, defaultValue) {
            if (defaultValue == null) {
              defaultValue = null;
            }
            return $http({
              method: "GET",
              url: "admin-ajax.php",
              params: {
                action: "wordlift.option",
                key: key,
                defaultValue: defaultValue
              }
            }).success(function(data, status, headers, config) {
              return $rootScope.$broadcast(key, data);
            }).error(function(data, status, headers, config) {
              return $log.info("error");
            });
          },
          set: function(key, value) {
            return $http({
              method: "POST",
              url: "admin-ajax.php",
              params: {
                action: "wordlift.option",
                key: key,
                value: value
              }
            }).success(function(data, status, headers, config) {
              return $log.info("success");
            }).error(function(data, status, headers, config) {
              return $log.info("error");
            });
          }
        };
      }
    ]).controller("OptionsController", [
      "OptionService", "$scope", "$log", function(OptionService, $scope, $log) {
        $scope.enableFooterBar = false;
        $scope.$on("wordlift_show_footer_bar", function(event, value) {
          return $scope.enableFooterBar = value === "\"true\"";
        });
        OptionService.get("wordlift_show_footer_bar", true, $scope.enableFooterBar);
        return $scope.save = function() {
          return OptionService.set("wordlift_show_footer_bar", $scope.enableFooterBar);
        };
      }
    ]);
    return angular.bootstrap(document.getElementById("wordLiftOptions"), ["wordLiftOptions"]);
  });

}).call(this);
