@extends('layouts.base')

@section('title')
  收益紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-nav-tabs">
        <div class="card-header" data-background-color="blue">
          <div class="nav-tabs-wrapper">
            <span class="nav-tabs-title">操作:</span>
            <ul class="nav nav-tabs" data-tabs="tabs">
              <li>
                <a
                  href="#"
                  aria-expanded="false"
                  class="confirm-button"
                  data-method="POST"
                  data-title="請輸入想要轉讓的對象"
                  data-message="{{ '
                      <div class="radio">
                        <label>
                          <input type="radio" name="currency" value="ETH" required>
                          <span class="circle"></span>
                          <span class="check"></span> ETH
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="currency" value="BTC" required>
                          <span class="circle"></span>
                          <span class="check"></span> BTC
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="currency" value="DASH" required>
                          <span class="circle"></span>
                          <span class="check"></span> DASH
                        </label>
                      </div>
                      <div class="form-group label-floating is-empty">
                        <label class="control-label">單位</label>
                        <input type="number" step="0.00000000001" name="amount" class="form-control" required>
                        <span class="material-input"></span>
                      </div>
                      <div class="form-group">
                        <select class="member-search form-control" type="text" name="recipient" required>
                          '.member_search_options().'
                        <select>
                        <span class="material-input"></span>
                      </div>' }}"
                >
                  <i class="material-icons">attach_money</i>
                    轉讓
                  <div class="ripple-container"></div>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">類型</th>
                <th class="col-md-3">收益</th>
                <th class="col-md-2">分配比例</th>
                <th class="col-md-2">原因</th>
                <th class="col-md-3">入帳時間</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($revenues as $revenue)
                <tr>
                  <td>{{ $revenue->currency->name }}</td>
                  <td>{!! amount_output($revenue->amount) !!}</td>
                  <td>{{ $revenue->percentage ? ($revenue->percentage * 100) . '%' : '-' }}</td>
                  <td>{{ $revenue->reason->name }}</td>
                  <td>{{ $revenue->created_at->format('Y/m/d H:i:s') }}</td>
                </tr>
              @endforeach
              @if (!$revenues->count())
                <tr>
                  <td colspan="5" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $revenues->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
