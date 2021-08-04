
@foreach($parameters as $name => $parameter)
    @if($name === '[]')
        <p>
            Body: <code>{{ $parameter['type'] }}</code> {!! Parsedown::instance()->text($parameter['description'] ?? '') !!}
        </p>
        @foreach($parameter['__fields'] as $subfieldName => $subfield)
                @if(!empty($subfield['__fields']))
                    @component('scribe::components.body-parameters', ['parameters' => [$subfieldName => $subfield], 'endpointId' => $endpointId,])
                    @endcomponent
                @else
                    <p>
                        @component('scribe::components.field-details', [
                          'name' => $subfield['name'],
                          'type' => $subfield['type'] ?? 'string',
                          'required' => $subfield['required'] ?? false,
                          'description' => $subfield['description'] ?? '',
                          'endpointId' => $endpointId,
                          'hasChildren' => false,
                          'component' => 'body',
                        ])
                        @endcomponent
                    </p>
                @endif
            @endforeach
    @elseif(!empty($parameter['__fields']))
        <p>
        <details>
            <summary style="padding-bottom: 10px;">
                @component('scribe::components.field-details', [
                  'name' => $parameter['name'],
                  'type' => $parameter['type'] ?? 'string',
                  'required' => $parameter['required'] ?? false,
                  'description' => $parameter['description'] ?? '',
                  'endpointId' => $endpointId,
                  'hasChildren' => true,
                  'component' => 'body',
                ])
                @endcomponent
            </summary>
            @foreach($parameter['__fields'] as $subfieldName => $subfield)
                @if(!empty($subfield['__fields']))
                    @component('scribe::components.body-parameters', ['parameters' => [$subfieldName => $subfield], 'endpointId' => $endpointId,])
                    @endcomponent
                @else
                    <p>
                        @component('scribe::components.field-details', [
                          'name' => $subfield['name'],
                          'type' => $subfield['type'] ?? 'string',
                          'required' => $subfield['required'] ?? false,
                          'description' => $subfield['description'] ?? '',
                          'endpointId' => $endpointId,
                          'hasChildren' => false,
                          'component' => 'body',
                        ])
                        @endcomponent
                    </p>
                @endif
            @endforeach
        </details>
        </p>
    @else
        <p>
            @component('scribe::components.field-details', [
              'name' => $parameter['name'],
              'type' => $parameter['type'] ?? 'string',
              'required' => $parameter['required'] ?? false,
              'description' => $parameter['description'] ?? '',
              'endpointId' => $endpointId,
              'hasChildren' => false,
              'component' => 'body',
            ])
            @endcomponent
        </p>
    @endif
@endforeach

