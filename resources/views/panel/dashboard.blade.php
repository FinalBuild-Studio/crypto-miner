@extends('layouts.base')

@section('title')
  總覽
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="orange">
          <i class="material-icons">account_balance</i>
        </div>
        <div class="card-content">
          <p class="category">BTC 分配比重 / ETH 分配比重</p>
          <h3 class="title">{{ $btcRevenue }} <small>%</small> / {{ $ethRevenue }} <small>%</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="red">
          <i class="material-icons">account_balance_wallet</i>
        </div>
        <div class="card-content">
          <p class="category">持有</p>
          <h3 class="title">{{ rtrim($twdWallet, '0') ?: 0 }} <small>TWD</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">未確認</p>
          <h3 class="title">{{ rtrim($eth, '0') ?: 0 }} <small>ETH</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="green">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">持有</p>
          <h3 class="title">{{ rtrim($ethWallet, '0') ?: 0 }} <small>ETH</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="blue">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">未確認</p>
          <h3 class="title">{{ rtrim($btc, '0') ?: 0 }} <small>BTC</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="blue">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">持有</p>
          <h3 class="title">{{ rtrim($btcWallet, '0') ?: 0 }} <small>BTC</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="default">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">密碼幣估值(未確認)</p>
          <h3 class="title">{{ round(crypto_sum(['BTC' => $btc, 'ETH' => $eth]) ?: 0) }} <small>TWD</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="default">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">密碼幣估值(持有)</p>
          <h3 class="title">{{ round(crypto_sum(['BTC' => $btcWallet, 'ETH' => $ethWallet]) ?: 0) }} <small>TWD</small></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-chart" data-background-color="blue">
          <div class="ct-chart" id="btc-chart"></div>
        </div>
        <div class="card-content">
          <h4 class="title">比特幣每日產出趨勢</h4>
          <p class="category">
            相較於昨日
            @if ($btcPercentage > 0)
              <span class="text-success">
                <i class="fa fa-long-arrow-up"></i> {{ abs($btcPercentage) }}%
              </span>
            @elseif ($btcPercentage < 0)
              <span class="text-danger">
                <i class="fa fa-long-arrow-down"></i> {{ abs($btcPercentage) }}%
              </span>
            @else
              <span class="text-muted">
                <i class="fa fa-long-arrow-right"></i> {{ abs($btcPercentage) }}%
              </span>
            @endif
            的產出
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-chart" data-background-color="green">
          <div class="ct-chart" id="eth-chart"></div>
        </div>
        <div class="card-content">
          <h4 class="title">以太幣每日產出趨勢</h4>
          <p class="category">
            相較於昨日
            @if ($ethPercentage > 0)
              <span class="text-success">
                <i class="fa fa-long-arrow-up"></i> {{ abs($ethPercentage) }}%
              </span>
            @elseif ($ethPercentage < 0)
              <span class="text-danger">
                <i class="fa fa-long-arrow-down"></i> {{ abs($ethPercentage) }}%
              </span>
            @else
              <span class="text-muted">
                <i class="fa fa-long-arrow-right"></i> {{ abs($ethPercentage) }}%
              </span>
            @endif
            的產出
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footerjs')
  @include('components.chart', ['element' => 'btc-chart', 'data' => $btcChart])
  @include('components.chart', ['element' => 'eth-chart', 'data' => $ethChart])
@endsection
