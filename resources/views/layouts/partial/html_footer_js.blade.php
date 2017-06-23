<script src="{{ url('/js/app.js') }}"></script>

@if (session('error'))
  <script type="text/javascript">
    $.notify('{{ session('error') }}', {type: 'danger'});
  </script>
@endif

@if (session('success'))
  <script type="text/javascript">
    $.notify('{{ session('success') }}', {type: 'success'});
  </script>
@endif
