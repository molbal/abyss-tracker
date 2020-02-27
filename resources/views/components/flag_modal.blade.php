<div class="modal fade " tabindex="-1" role="dialog" id="flag_modal">
    <form action="{{route("run_flag")}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$id}}">
        <div class="modal-dialog border-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><img src="https://img.icons8.com/offices/24/000000/filled-flag2.png"> Flag this run for manual review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-justify text-black-50 text-small mb-3">
                        Please submit this run review if you think something is wrong with it, such as unrealistic loot
                        or clearly wrong entry filled. If its your own, please sign in and delete it.
                    </div>
                    <div class="form-group">
                        <label for="message">Reason for flagging</label>
                        <textarea name="message" id="message" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="button" role="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Cancel
                        </button>
                        <button type="submit" class="btn btn-sm btn-outline-danger">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
