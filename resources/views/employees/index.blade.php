
@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('vendor/node_modules/angular/angular-confirm.min.css')}}">
@endpush

@push('scripts')

    @include('components.angular', ['modules' => [
        'cp.ngConfirm'=>'vendor/node_modules/angular/angular-confirm.min.js',
    ]])

    <script type="text/javascript">

        app.controller('Controller', ['$scope','$http','$element','$ngConfirm','$location', function($scope,$http,$element,$ngConfirm,$location){

            var base_url = window.location.origin
            var url = $element.find('form').attr('action');

            $scope.form = {
                display: false,
                mapping: {}
            };

            $scope.page = $location.search().page;

            var params = {
                page: $scope.page,
                limit: 2,
                sortIndex: 'id',
                sortOrder: 'asc',
                searchIndex: $location.search().searchIndex,
                searchValue: $location.search().searchValue
            }

            $http.get(base_url + '/employees',{params:params}).then(function(response){
                $scope.employees = response.data.list;
                $scope.pages = response.data.pages;
            });

            $scope.getNumber = function(num) {
                return new Array(num);
            }

            $scope.changePage = function(page){
                window.location.href = base_url + '/employees?page=' + page;
            }

            $scope.create = function(){
                $scope.form.display  = true;
                $scope.form.mapping = {};
            }

            $scope.back = function(){
                $scope.form.display  = false;
            }

            $scope.update = function(index){
                $scope.form.display  = true;
                $scope.form.mapping = $scope.employees[index];
            }

             $scope.save = function(){

                 var fd = new FormData();

                 if ($scope.form.mapping.id) $scope.form.mapping._method = 'patch';

                 angular.forEach($scope.form.mapping,function(value,key){
                     fd.append(key, value ? value : '');
                 });

                 var config = {headers: {'Content-Type': undefined}};

                 return $ngConfirm({
                     icon: 'fa fa-warning',
                     title: 'SAVE',
                     content: 'Are sure you wish to save the entry?',
                     buttons: {
                         yes: {
                             btnClass: 'btn-red',
                             action: function(){

                                 $http.post(url,fd,config).then(function(response){

                                     $ngConfirm(response.data.message);

                                 }, function(response){

                                     if (response.status == 304)
                                     {
                                         $ngConfirm('Updated successfully.');
                                         return false;
                                     }

                                 });

                             }
                         },
                         no: function() {}
                     }
                 });

             }

             $scope.delete = function(id,row){
                 return $ngConfirm({
                     icon: 'fa fa-warning',
                     title: 'DELETE',
                     content: 'Are sure you wish to delete the record?',
                     buttons: {
                         yes: {
                             btnClass: 'btn-red',
                             action: function(){

                                 $http.post(url, {id : id, _method: 'delete'}).then(function(response){

                                     $ngConfirm(response.data.message);
                                     $scope.employees.splice(row,1);

                                 }, function(response){

                                 });
                             }
                         },
                         no: function() {}
                     }
                 });
             }

        }]);

    </script>

@endpush

@section('title')
Event
@endsection

@section('content')

<div ng-controller="Controller">

    <div class="container" ng-show="!form.display">

        <div class="pull-left">
            <button class="btn btn-primary" ng-click="create()">Create</button>
        </div>

        <div class="form-inline pull-right">
            <div class="form-group">
                <label>Search</label>
                <input type="text" ng-model="search" class="form-control" placeholder="Search">
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="data in employees">
                <td><% data.id %></td>
                <td>
                    <button type="button" class="btn btn-warning" ng-click="update(employees.indexOf(data))">Update</button>
                    <button type="button" class="btn btn-danger" ng-click="delete(data.id,employees.indexOf(data))">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <ul class="pagination pagination-sm pull-right">
            <li ng-repeat="i in getNumber(pages) track by $index" ng-class="page == $index + 1 ? 'active' : ''"><a ng-click="changePage($index + 1)"> <%$index+1%> </a></li>
        </ul>

    </div>

    <div class="container" ng-show="form.display">
        @include('employees.form')
    </div>

</div>

@endsection