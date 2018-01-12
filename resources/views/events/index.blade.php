
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
        'cp.ngConfirm'=>'vendor/node_modules/angular/angular-confirm.min.js'
    ]])

    <script type="text/javascript">

        app.controller('Controller', ['$scope','$http','$element','$ngConfirm', function($scope,$http,$element,$ngConfirm){

            var url = $element.find('form').attr('action');

            $scope.form = {
                display: false,
                mapping: {}
            };

            $http.get('http://localhost/users').then(function(response){
                $scope.users = response.data.list;
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
                $scope.form.mapping = $scope.users[index];
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
                                     $scope.users.splice(row,1);

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
                <th  ng-click="sort('name')">Name<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th  ng-click="sort('email')">Email<span class="glyphicon sort-icon" ng-show="sortKey=='email'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr dir-paginate="user in users|orderBy:sortKey:reverse|filter:search|itemsPerPage:5">
                <td><% user.id %></td>
                <td><% user.name %></td>
                <td><% user.email %></td>
                <td>
                    <button type="button" class="btn btn-warning" ng-click="update(users.indexOf(user))">Update</button>
                    <button type="button" class="btn btn-danger" ng-click="delete(user.id,users.indexOf(user))">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="pagination-container">
            <dir-pagination-controls max-size="5" direction-links="false" boundary-links="true"></dir-pagination-controls>
        </div>

    </div>

    <div class="container" ng-show="form.display">
        @include('events.form')
    </div>

</div>

@endsection