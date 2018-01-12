<link rel="stylesheet" href="{{url('vendor/node_modules/bootstrap/bootstrap.min.css')}}">
<script src="{{url('vendor/node_modules/bootstrap/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('vendor/node_modules/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('vendor/node_modules/angular/angular.min.js')}}"></script>

<?php $angularModules = '';
if(isset($modules)): foreach($modules as $module => $path):
    $angularModules .= sprintf(',"%s"', $module);
    ?>
    <script type="text/javascript" src="{{url($path)}}"></script>
<?php endforeach;
    $angularModules = substr($angularModules, 1);
endif;
?>
<script type="text/javascript">
    var base_url = window.location.origin;
    var config = {
        "async": true,
        "crossDomain": true,
        "headers": {
            "cache-control": "no-cache",
            "Accept" : "application/json"
        }
    };
    var app = angular.module('Test', [<?php echo $angularModules; ?>], function($interpolateProvider){

        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>') ;

    }).config(function ($locationProvider,$httpProvider) {
        $httpProvider.interceptors.push('myHttpInterceptor');
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
    }).factory('myHttpInterceptor', ['$q', '$rootScope', '$injector',
            function ($q, $rootScope, $injector) {
                $rootScope.http = null;
                return {
                    'request': function (config) {
                        $(".loader").addClass('active');
                        return config || $q.when(config);
                    },
                    'requestError': function (rejection) {
                        $rootScope.http = $rootScope.http || $injector.get('$http');
                        if ($rootScope.http.pendingRequests.length < 1) {
                            $(".loader").removeClass('active');
                        }
                        return $q.reject(rejection);
                    },
                    'response': function (response) {
                        $rootScope.http = $rootScope.http || $injector.get('$http');
                        if ($rootScope.http.pendingRequests.length < 1) {
                            $(".loader").removeClass('active');
                        }
                        return response || $q.when(response);
                    },
                    'responseError': function (rejection) {
                        $rootScope.http = $rootScope.http || $injector.get('$http');
                        if ($rootScope.http.pendingRequests.length < 1) {
                            $(".loader").removeClass('active');
                        }
                        return $q.reject(rejection);
                    }
                }
            }
        ]).run(function($http){
            $http.defaults.async = true;
            $http.defaults.headers.common.Accept = "application/json";
            $http.defaults.headers.common["Cache-Control"] = "no-cache, max-age=0";
    });
</script>