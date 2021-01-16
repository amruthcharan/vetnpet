<!-- Modal Add Category -->
<div class="modal fade none-border" id="delete-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Are You sure?</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="text-center">
                            Do you really want to delete the user?
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {!! Form::open(['method'=>"DELETE", 'action'=>['UserController@destroy', $user->id]]) !!}
                {!! Form::submit('Delete', ['class'=>'btn btn-info']) !!}
                {!! Form::close() !!}
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->