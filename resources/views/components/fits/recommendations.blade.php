<table class="w-100 table-sm">
    <tr>
        @foreach(['DARK','ELECTRICAL','EXOTIC','FIRESTORM','GAMMA'] as $type)
            <td class="text-center" style="width: 20%">
                <p class="h3 mb-1">
                    @if($recommendations->$type == 0)
                        <img src="_icons/unavailable.png" class="smallicon" alt="Nope" data-toggle="tooltip" title="Not recommended for any {{strtolower($type)}} runs">
                    @else
                        {{$recommendations->$type}}
                    @endif
                </p>
                <img src="types/{{ucfirst(strtolower($type))}}.png"  class="tinyicon" alt=""> {{ucfirst(strtolower($type))}}
            </td>
        @endforeach
    </tr>
</table>
