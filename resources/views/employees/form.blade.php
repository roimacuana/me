
      <form method="post" action="{{url('employees')}}">
            
           <div class="col-md-6">
                <div class="form-group">
                    <label for="id">Id:</label>
                    <input type="text" class="form-control" id="id" placeholder="Enter id" name="id" ng-model="form.mapping.id"/>
                </div>
           </div>
           <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" ng-model="form.mapping.title"/>
                </div>
           </div>
           <div class="col-md-6">
                <div class="form-group">
                    <label for="created_at">Created At:</label>
                    <input type="datetime" class="form-control" id="created_at" placeholder="Enter created_at" name="created_at" ng-model="form.mapping.created_at"/>
                </div>
           </div>
           <div class="col-md-6">
                <div class="form-group">
                    <label for="updated_at">Updated At:</label>
                    <input type="datetime" class="form-control" id="updated_at" placeholder="Enter updated_at" name="updated_at" ng-model="form.mapping.updated_at"/>
                </div>
           </div>
            <div class="row">
                    <button type="button" class="btn btn-warning" ng-click="save()">Save</button>
                    <button type="button" class="btn btn-primary" ng-click="back()">Back</button>
           </div>
      </form>