<div class="card card-body border-0 shadow-sm mb-3 pb-1">
@component("components.collapse.collapse-toggle", ['icon' => $icon, 'target' => "#".md5($title)]) {{$title}} @endcomponent
@component("components.collapse.collapsible", ["id" => md5($title), 'show' => $show ?? false])
    {{$slot}}
@endcomponent
</div>
