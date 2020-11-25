<div class="modal fade " tabindex="-1" role="dialog" id="fit_new_description_modal">
    <form action="{{route("fit.update.description")}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$id}}">
        <div class="modal-dialog border-0" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if (session()->exists("login_id"))
                    <div class="modal-body">
                        <div class="text-justify text-black-50 text-small mb-3">
                            Please edit your description below.
                        </div>
                        <div class="form-group">
                            <label for="message">Description</label>
                            <textarea name="description" id="description" class="form-control w-100 mt-2" rows="10">{{$description}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <button type="button" role="button" class="btn btn-sm btn-link text-muted" data-dismiss="modal">Cancel</button>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-outline-success">Update</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="modal-body">
                        <p class="text-center">
                            Please sign in to update your fit <br>
                            <a href="{{route("auth-start")}}" class="my-sm-0"><img src="https://eve-nt.uk/img/sso_small.png" alt=""></a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
