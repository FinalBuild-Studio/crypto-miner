@extends('layouts.base')

@section('title')
  轉帳紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="orange">
          <h4 class="title">轉帳紀錄</h4>
          <p class="category">此紀錄為從共同錢包轉成台幣(設定賣點金額為-1的將不會進行處理)</p>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">類型</th>
                <th class="col-md-6">總額</th>
                <th class="col-md-3">賣點</th>
                <th class="col-md-3">狀態</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transfers as $transfer)
                <tr>
                  <td>{{ $transfer->currency->name }}</td>
                  <td>{{ amount_output($transfer->amount) }}</td>
                  <td>{{ $transfer->price_at }}</td>
                  <td>
                    @if ($transfer->status == App\Transfer::WAITING)
                      <span class="label label-warning">待處理</span>
                    @elseif ($transfer->status == App\Transfer::PROCESSING)
                      <span class="label label-info">處理中</span>
                    @else
                      <span class="label label-success">已處理</span>
                    @endif
                  </td>
                </tr>
              @endforeach
              @if (!$transfers->count())
                <tr>
                  <td colspan="4" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $transfers->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
