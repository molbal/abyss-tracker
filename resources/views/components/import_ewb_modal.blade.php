<div class="modal fade " tabindex="-1" role="dialog" id="ewb_modal">
    <div class="modal-dialog border-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><img src="{{asset("_icons/ewb.png")}}" class="smallicon bringupper mr-1">EVE Workbench import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-justify text-black-50 text-small mb-3">
                    Please enter the full EVE Workbench fit link such as <a href="https://www.eveworkbench.com/fitting/gila/1e9af79c-8d23-4638-be58-08d8723ecc7c" target="_blank">https://www.eveworkbench.com/fitting/gila/1e9af79c-8d23-4638-be58-08d8723ecc7c</a> then click Import. The Abyss Tracker will call EVE Workbench and try to extract the data.
                </div>
                <div class="form-group">
                    <label for="message">EVE Workbench link</label>
                    <input class="form-control" id="ewbLink" type="text">
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <button type="button" role="button" class="btn btn-sm btn-link text-muted" data-dismiss="modal" id="closeModalEwb">Cancel</button>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="$('#closeModalEwb').click();" wire:click="importFromEveWorkbench($('#ewbLink').val())">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
