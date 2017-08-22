@extends('layouts.base')

@section('title')
  操控面板
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-content">
          <legend>獲利 &amp; 結算</legend>
          <div class="row">
            <div class="col-md-12">
              <button
                class="btn btn-success btn-round btn-block confirm-button"
                data-method="POST"
                data-ajax="true"
                data-title="請輸入今日挖礦產出"
                data-action="{{ action('Panel\\Admin\\Api\\RevenueController@store') }}"
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
                <div class="radio">
                  <label>
                    <input type="radio" name="currency" value="DASH">
                    <span class="circle"></span>
                    <span class="check"></span> DASH
                  </label>
                </div>
                <div class="form-group label-floating is-empty">
                  <label class="control-label">總額度</label>
                  <input type="number" step="0.00000001" name="amount" class="form-control">
                  <span class="material-input"></span>
                </div>
                <div class="form-group label-floating is-empty">
                  <label class="control-label">維護費用</label>
                  <input type="number" step="0.00000001" name="maintenance" class="form-control">
                  <span class="material-input"></span>
                </div>' }}"
              >
                挖礦獲利
              </button>
            </div>
            <div class="col-md-12">
              <button
                class="btn btn-danger btn-round btn-block confirm-button"
                data-method="POST"
                data-ajax="true"
                data-title="請輸入需要結算的幣種"
                data-action="{{ action('Panel\\Admin\\Api\\WithdrawController@store') }}"
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
                </div>' }}">
                帳戶結算
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
