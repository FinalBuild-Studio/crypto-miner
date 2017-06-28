@if ($data)
  <script type="text/javascript">
    $.chartist.Line('#{{ $element }}', {
      labels: {!! json_encode(array_keys($data)) !!},
      series: [
        {!! json_encode(array_values($data)) !!}
      ]
    }, {
      lineSmooth: $.chartist.Interpolation.cardinal({
        tension: 0
      }),
      low: 0,
      high: {{ $data ? (max(array_values($data)) + max(array_values($data)) * .5) : 0 }},
      chartPadding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      },
    });
  </script>
@endif
