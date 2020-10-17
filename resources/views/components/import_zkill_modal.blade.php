<div class="modal fade " tabindex="-1" role="dialog" id="zkill_modal">
    <div class="modal-dialog border-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="{{asset("_icons/zKill.png")}}" class="smallicon bringupper mr-1">zKillboard import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-justify text-black-50 text-small mb-3">
                    Please enter the full zKillboard link of a killmail such as <a href="https://zkillboard.com/kill/85153872/" target="_blank">https://zkillboard.com/kill/85153872/</a> then click Import. The Abyss Tracker will call zKillboard and try to extract the data.
                </div>
                <div class="form-group">
                    <label for="message">zKillboard link</label>
                    <input class="form-control" id="zKillLink" type="text">
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <button type="button" role="button" class="btn btn-sm btn-link text-muted" data-dismiss="modal" id="closeModal">Cancel</button>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="$('#closeModal').click();" wire:click="importFromZkill($('#zKillLink').val())">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
