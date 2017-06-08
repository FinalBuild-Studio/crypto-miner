@extends('layouts.base')

@section('title')
  錢包紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="red">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">台幣</p>
          <h3 class="title">{{ $twdAmount }} <small>TWD</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">以太幣</p>
          <h3 class="title">{{ $ethAmount }} <small>ETH</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-stats">
        <div class="card-header" data-background-color="blue">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">比特幣</p>
          <h3 class="title">{{ $btcAmount }} <small>BTC</small></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="green">
          <h4 class="title">錢包明細</h4>
          <p class="category">此明細為確認已經提出礦池並且可以提領，但是注意有提領限制，有需要的話可以合併提領</p>
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
              @foreach ($wallets as $wallet)
                <tr>
                  <td>{{ $wallet->currency->name }}</td>
                  <td>{{ $wallet->amount }}</td>
                  <td></td>
                </tr>
              @endforeach
              @if (!$wallets->count())
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
      {{ $wallets->links() }}
    </div>
  </div>
@endsection
