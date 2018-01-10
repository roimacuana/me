
@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{url('vendor/node_modules/angular/angular-confirm.min.css')}}">
<style>
    .pagination-container,.search-container {
        float: right;
    }
    .search-container {
        margin: 16px 0px;
    }
</style>
@endpush

@push('scripts')

    @include('components.angular', ['modules' => [
        'cp.ngConfirm'=>'vendor/node_modules/angular/angular-confirm.min.js',
        'angularUtils.directives.dirPagination'=>'vendor/node_modules/angular/dirPagination.js'
    ]])

    <script type="text/javascript">

        app.controller('Controller', ['$scope','$http','$element','$ngConfirm', function($scope,$http,$element,$ngConfirm){

            var url = $element.find('form').attr('action');

            $scope.form = {
                display: false,
                mapping: {}
            };

            $http.get('http://localhost/employees').then(function(response){
                $scope.employees = response.data.list;
            });

            $scope.sort = function(keyname){
                $scope.sortKey = keyname;
                $scope.reverse = !$scope.reverse;
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

        <div class="create-container">
            <button class="btn btn-primary" ng-click="create()">Create</button>
        </div>

        <div class="form-inline search-container">
            <div class="form-group">
                <label>Search</label>
                <input type="text" ng-model="search" class="form-control" placeholder="Search">
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th  ng-click="sort('id')">Id<span class="glyphicon sort-icon" ng-show="sortKey=='id'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr dir-paginate="data in employees|orderBy:sortKey:reverse|filter:search|itemsPerPage:5">
                <td><% data.id %></td>
                <td>
                    <button type="button" class="btn btn-warning" ng-click="update(employees.indexOf(data))">Update</button>
                    <button type="button" class="btn btn-danger" ng-click="delete(data.id,employees.indexOf(data))">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <dir-pagination-controls max-size="5" direction-links="false" boundary-links="true"></dir-pagination-controls>
        </div>

    </div>

    <div class="container" ng-show="form.display">
        @include('employees.form')
    </div>

</div>

@endsection