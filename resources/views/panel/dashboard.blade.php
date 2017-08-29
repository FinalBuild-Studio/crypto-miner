@extends('layouts.base')

@section('title')
  總覽
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-stats">
        <div class="card-header" data-background-color="purple">
          <i class="material-icons">account_balance</i>
        </div>
        <div class="card-content">
          <p class="category">BTC 分配比重 / ETH 分配比重 / DASH 分配比重</p>
          <h3 class="title">{{ $btcRevenue }} <small>%</small> / {{ $ethRevenue }} <small>%</small> / {{ $dashRevenue }} <small>%</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card card-stats">
        <div class="card-header" data-background-color="red">
          <i class="material-icons">account_balance_wallet</i>
        </div>
        <div class="card-content">
          <p class="category">持有</p>
          <h3 class="title">{{ decimal_value($twdWallet, '0') ?: 0 }} <small>TWD</small></h3>
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
          <h3 class="title">{{ decimal_value($eth, '0') ?: 0 }} <small>ETH</small></h3>
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
          <h3 class="title">{{ decimal_value($ethWallet, '0') ?: 0 }} <small>ETH</small></h3>
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
          <h3 class="title">{{ decimal_value($btc, '0') ?: 0 }} <small>BTC</small></h3>
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
          <h3 class="title">{{ decimal_value($btcWallet, '0') ?: 0 }} <small>BTC</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="orange">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">未確認</p>
          <h3 class="title">{{ decimal_value($dash, '0') ?: 0 }} <small>DASH</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-stats">
        <div class="card-header" data-background-color="orange">
          <i class="material-icons">attach_money</i>
        </div>
        <div class="card-content">
          <p class="category">持有</p>
          <h3 class="title">{{ decimal_value($dashWallet, '0') ?: 0 }} <small>DASH</small></h3>
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
          <h3 class="title">{{ round(crypto_sum(['BTC' => $btc, 'ETH' => $eth, 'DASH' => $dash]) ?: 0) }} <small>TWD</small></h3>
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
          <h3 class="title">{{ round(crypto_sum(['BTC' => $btcWallet, 'ETH' => $ethWallet, 'DASH' => $dashWallet]) ?: 0) }} <small>TWD</small></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card card-stats">
        <div class="card-header" data-background-color="red">
          <i class="material-icons">show_chart</i>
        </div>
        <div class="card-content">
          <p class="category">年投資報酬率(ROI)</p>
          <h3 class="title">{{ annual_revenue(Auth::user()) }} <small>%</small></h3>
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

    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-chart" data-background-color="orange">
          <div class="ct-chart" id="dash-chart"></div>
        </div>
        <div class="card-content">
          <h4 class="title">達世幣每日產出趨勢</h4>
          <p class="category">
            相較於昨日
            @if ($dashPercentage > 0)
              <span class="text-success">
                <i class="fa fa-long-arrow-up"></i> {{ abs($dashPercentage) }}%
              </span>
            @elseif ($dashPercentage < 0)
              <span class="text-danger">
                <i class="fa fa-long-arrow-down"></i> {{ abs($dashPercentage) }}%
              </span>
            @else
              <span class="text-muted">
                <i class="fa fa-long-arrow-right"></i> {{ abs($dashPercentage) }}%
              </span>
            @endif
            的產出
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="red">
          <h4 class="title">目前年投資報酬率(ROI)估算</h4>
        </div>
        <div class="card-content">

          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">投資類型</th>
                <th class="col-md-3">目前單價</th>
                <th class="col-md-4">年投資報酬率(ROI)</th>
                <th class="col-md-3">期望回本天數</th>
              </tr>
            </thead>
            <tbody>
              @foreach (annual_revenue_type() as $type => $roi)
                <tr>
                  <td>{{ $type }}</td>
                  <td>{{ crypto_value($type) }}</td>
                  <td>{{ $roi }}%</td>
                  <td>{{ round(365 / ($roi / 100 + 1)) }}天</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footerjs')
  @include('components.chart', ['element' => 'btc-chart', 'data' => $btcChart])
  @include('components.chart', ['element' => 'eth-chart', 'data' => $ethChart])
  @include('components.chart', ['element' => 'dash-chart', 'data' => $dashChart])
@endsection
