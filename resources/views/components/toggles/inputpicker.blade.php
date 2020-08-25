<div class="pickerInputGroup">
    <input id="{{md5($name.$value)}}" name="{{$name}}" value="{{$value}}" type="radio" {{$checked ? "checked=''" : ""}}/>
    <label for="{{md5($name.$value)}}">
        <p class="mb-1 font-weight-bold text-uppercase">{{$title}}</p>
        <p class="mb-1 text-small">{!! $description !!}</p>
    </label>
</div>
