@extends('layouts.base')

@section('title')
  投資紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-nav-tabs">
        <div class="card-header" data-background-color="purple">
          <div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<span class="nav-tabs-title">操作:</span>
							<ul class="nav nav-tabs" data-tabs="tabs">
                <li>
									<a
                    href="#"
                    aria-expanded="false"
                    class="confirm-button"
                    data-method="POST"
                    data-title="請選擇想要投資的目標"
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
                        <div class="form-group label-floating is-empty">
													<label class="control-label">總價</label>
													<input type="number" step="0.1" name="amount" class="form-control" required>
												  <span class="material-input"></span>
                        </div>' }}"
                  >
										<i class="material-icons">attach_money</i>
										  再投資
									  <div class="ripple-container"></div>
                  </a>
								</li>
							</ul>
						</div>
					</div>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">投資類型</th>
                <th class="col-md-4">投資金額(USD)</th>
                <th class="col-md-3">建立時間</th>
                <th class="col-md-2">合約到期日</th>
    						<th class="col-md-1">狀態</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($investments as $investment)
                <tr>
                  <td>{{ $investment->currency->name }}</td>
                  <td>{{ $investment->amount }}</td>
                  <td>{{ $investment->created_at->format('Y/m/d H:i:s') }}</td>
                  <td>{{ $investment->expired_at ? $investment->expired_at->format('Y/m/d') : '-' }}</td>
                  <td>
                    @if ($investment->status == App\Investment::UNCONFIRMED)
                      <span class="label label-warning">未確認</span>
                    @elseif ($investment->status == App\Investment::ENABLED)
                      <span class="label label-success">處理中</span>
                    @else
                      <span class="label label-danger">已過期</span>
                    @endif
                  </td>
                </tr>
              @endforeach
              @if (!$investments->count())
                <tr>
                  <td colspan="5" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $investments->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
