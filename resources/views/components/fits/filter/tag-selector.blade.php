<div class="d-flex justify-content-between">
    <span class="tag-picker-text">@lang("tags.".$slot)</span>
    <div class="noselect">
        <input type="hidden" name="{{$slot}}" id="{{$slot}}" value="">
        <span class="tag-selector" onclick="toggleTag('{{$slot}}', 'no', this);"><span>-</span></span>
        <span class="tag-selector" onclick="toggleTag('{{$slot}}', 'yes', this);"><span>+</span></span>
    </div>
</div>
