// Generated by CoffeeScript 1.4.0
(function() {

  angular.module("userly", []).constant("applicationId", "wordlift").config([
    "applicationId", "$httpProvider", "$locationProvider", "$routeProvider", function(applicationId, $httpProvider, $locationProvider, $routeProvider) {
      $httpProvider.defaults.headers.common["Application-Id"] = applicationId;
      return $httpProvider.defaults.withCredentials = true;
    }
  ]).directive("passwordConfirmation", [
    "$log", function($log) {
      return {
        require: "?ngModel",
        link: function(scope, elm, attr, ctrl) {
          var validator;
          if (!(ctrl != null)) {
            return;
          }
          validator = function(value) {
            if (scope.password !== value) {
              $log.error("password don't match");
              ctrl.$setValidity("passwordConfirmation", false);
              return;
            }
            ctrl.$setValidity("passwordConfirmation", true);
            return value;
          };
          return ctrl.$parsers.unshift(validator);
        }
      };
    }
  ]).service("BasicAuthenticationService", [
    "$log", function($log) {
      return {
        getHeaderValue: function(userName, password) {
          return "Basic " + (window.btoa(userName + ":" + password));
        }
      };
    }
  ]).service("ApiService", [
    "BasicAuthenticationService", "$http", "$q", "$log", function(BasicAuthenticationService, $http, $q, $log) {
      return {
        authToken: null,
        clearAuthToken: function() {
          return this.authToken = null;
        },
        getUrl: function() {
          return "https://api.idntik.it/api/";
        },
        execute: function(method, path, userName, password, storeAuthToken, data) {
          var authToken, deferred, that;
          if (userName == null) {
            userName = null;
          }
          if (password == null) {
            password = null;
          }
          if (storeAuthToken == null) {
            storeAuthToken = false;
          }
          if (data == null) {
            data = null;
          }
          deferred = $q.defer();
          authToken = this.authToken;
          if (userName && password) {
            authToken = BasicAuthenticationService.getHeaderValue(userName, password);
          }
          that = this;
          $http({
            method: method,
            url: this.getUrl() + path,
            headers: {
              Authorization: authToken
            },
            data: data
          }).success(function(data, status, headers, config) {
            if (storeAuthToken) {
              that.authToken = authToken;
            }
            return deferred.resolve(data);
          }).error(function(data, status, headers, config) {
            return deferred.reject(data);
          });
          return deferred.promise;
        }
      };
    }
  ]).service("MessageService", [
    "$log", function($log) {
      return {
        info: function(message) {
          return $("#message").removeClass("text-error").addClass("text-info").html(message);
        },
        error: function(message) {
          return $("#message").removeClass("text-info").addClass("text-error").html(message);
        }
      };
    }
  ]).service("AuthenticationService", [
    "applicationId", "ApiService", "$q", "$rootScope", "$log", function(applicationId, ApiService, $q, $rootScope, $log) {
      return {
        isLoggedIn: false,
        setLoggedIn: function(loggedIn) {
          this.isLoggedIn = loggedIn;
          return $rootScope.$broadcast("AuthenticationService.isLoggedIn", loggedIn);
        },
        login: function(userName, password) {
          var deferred,
            _this = this;
          deferred = $q.defer();
          ApiService.execute("GET", "user/me", userName, password, true).then(function(data) {
            _this.setLoggedIn(true);
            return deferred.resolve(data);
          }, function(data) {
            _this.setLoggedIn(false);
            return deferred.reject(data);
          });
          return deferred.promise;
        },
        logout: function() {
          ApiService.clearAuthToken();
          return this.setLoggedIn(false);
        }
      };
    }
  ]).service("UserRegistrationService", [
    "ApiService", "MessageService", "$http", "$q", "$log", function(ApiService, MessageService, $http, $q, $log) {
      return {
        activate: function(activationKey) {
          var deferred;
          deferred = $q.defer();
          ApiService.execute("GET", "user/activate/" + activationKey).then(function(data) {
            return deferred.resolve(data);
          }, function(data) {
            return deferred.reject(data);
          });
          return deferred.promise;
        },
        register: function(data) {
          var deferred;
          deferred = $q.defer();
          $http({
            method: "POST",
            url: "admin-ajax.php?action=wordlift.register",
            data: data
          }).success(function(data, status, headers, config) {
            return deferred.resolve(data);
          }).error(function(data, status, headers, config) {
            return deferred.reject(data);
          });
          return deferred.promise;
        }
      };
    }
  ]).controller("AuthenticationCtrl", [
    "AuthenticationService", "ApiService", "MessageService", "$location", "$http", "$scope", "$log", function(AuthenticationService, ApiService, MessageService, $location, $http, $scope, $log) {
      $scope.$on("AuthenticationService.isLoggedIn", function(loggedIn) {
        $log.info("Auth Serv is " + AuthenticationService.isLoggedIn);
        return $scope.isLoggedIn = AuthenticationService.isLoggedIn;
      });
      $scope.login = function() {
        var password;
        password = $scope.password;
        $scope.password = "";
        return AuthenticationService.login($scope.username, password).then(function() {
          return MessageService.info("You successfully authenticated!");
        }, function(data) {
          return MessageService.error("" + data.message + "\n(" + data.simpleName + ")");
        });
      };
      $scope.logout = function() {
        AuthenticationService.logout();
        return MessageService.info("You logged out!");
      };
      $scope.ping = function() {
        return ApiService.execute("GET", "ping").then(function(data) {
          return MessageService.info(data);
        }, function(data) {
          return MessageService.error("" + data.message + "\n(" + data.simpleName + ")");
        });
      };
      return $scope.register = function() {
        return $location.path("/register");
      };
    }
  ]).controller("UserActivationCtrl", [
    "applicationId", "MessageService", "UserRegistrationService", "$location", "$routeParams", "$scope", "$log", function(applicationId, MessageService, UserRegistrationService, $location, $routeParams, $scope, $log) {
      $log.info($routeParams);
      $scope.activate = function(activationKey) {
        return UserRegistrationService.activate(activationKey).then(function(data) {
          return MessageService.info("Activation completed successfully!");
        }, function(data) {
          return MessageService.error("Uh oh: " + data.message + "\n(" + data.simpleName + ")");
        });
      };
      $scope.goToLogin = function() {
        return $location.path("/");
      };
      if ($routeParams.activationKey != null) {
        return $scope.activate($routeParams.activationKey);
      }
    }
  ]);

}).call(this);
