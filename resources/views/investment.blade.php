@extends('layouts.base')

@section('title')
  投資紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">Simple Table</h4>
          <p class="category">Here is a subtitle for this table</p>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th>投資類型</th>
                <th>投資金額(USD)</th>
    						<th>狀態</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($investments as $investment)
                <tr>
                  <td>{{ $investment->currency->name }}</td>
                  <td>{{ $investment->amount }}</td>
                  <td></td>
                </tr>
              @endforeach
              @if (!$investments->count())
                <tr>
                  <td colspan="3" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="pull-right">
      {{ $investments->links() }}
    </div>
  </div>
@endsection
