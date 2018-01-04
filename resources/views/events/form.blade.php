
<form method="post" action="{{url('users')}}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" ng-model="form.mapping.name">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" ng-model="form.mapping.email">
            </div>
        </div>
    </div>
    <div class="row">
        <button type="button" class="btn btn-warning" ng-click="save()">Save</button>
        <button type="button" class="btn btn-primary" ng-click="back()">Back</button>
    </div>
</form>