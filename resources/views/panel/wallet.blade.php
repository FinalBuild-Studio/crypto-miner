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
      <div class="card card-nav-tabs">
        <div class="card-header" data-background-color="green">
          <div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<span class="nav-tabs-title">操作:</span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li>
									<a
                    href="#"
                    aria-expanded="false"
                    class="confirm-button"
                    data-title="請選擇需要賣出的虛擬幣"
                    data-action="{{ action('Panel\Wallet\SellController@store') }}"
                    data-method="POST"
                    data-message="{{ '<div class="radio">
                      <label>
                        <input type="radio" name="currency" value="ETH">
                        <span class="circle"></span>
                        <span class="check"></span> ETH
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="currency" value="BTC">
                        <span class="circle"></span>
                        <span class="check"></span> BTC
                      </label>
                    </div>
                    <div class="form-group label-floating is-empty">
                      <label class="control-label">總額度</label>
                      <input type="number" step="0.00000001" name="amount" class="form-control">
                      <span class="material-input"></span>
                    </div>
                    <div class="form-group label-floating is-empty">
                      <label class="control-label">賣點</label>
                      <input type="number" step="0.00000001" name="price_at" class="form-control">
                      <span class="material-input"></span>
                    </div>' }}"
                  >
										<i class="material-icons">account_balance_wallet</i>
										賣出
									<div class="ripple-container"></div></a>
								</li>
							</ul>
						</div>
					</div>
          <p class="category">提領金額過低的話可以請求合併提領，賣出成台幣後請提供匯款帳號</p>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">貨幣類型</th>
                <th class="col-md-4">單位</th>
    						<th class="col-md-3">分配比例</th>
                <th class="col-md-3">入帳時間</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($wallets as $wallet)
                <tr>
                  <td>{{ $wallet->currency->name }}</td>
                  <td>
                    {!! amount_output($wallet->amount) !!}
                  </td>
                  <td>{{ $wallet->percentage ? ($wallet->percentage * 100) . '%' : '-' }}</td>
                  <td>{{ $wallet->created_at->format('Y/m/d H:i:s') }}</td>
                </tr>
              @endforeach
              @if (!$wallets->count())
                <tr>
                  <td colspan="4" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $wallets->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
