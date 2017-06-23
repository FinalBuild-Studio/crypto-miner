@extends('layouts.base')

@section('title')
  待轉帳
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="orange">
          <h4 class="title">待轉帳</h4>
          <p class="category">這裡只會處理還沒有進行轉帳作業的人，可以改成已處理</p>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-1">類型</th>
                <th class="col-md-3">使用者</th>
                <th class="col-md-3">總額</th>
                <th class="col-md-3">賣點</th>
                <th class="col-md-2">操作</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transfers as $transfer)
                <tr>
                  <td>{{ $transfer->currency->name }}</td>
                  <td>{{ $transfer->user->name }}</td>
                  <td>{!! amount_output($transfer->amount) !!}</td>
                  <td>{{ $transfer->price_at }}</td>
                  <td>

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
