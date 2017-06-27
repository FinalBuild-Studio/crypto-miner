@extends('layouts.base')

@section('title')
  未處理訂單
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-1">類型</th>
                <th class="col-md-2">平台</th>
                <th class="col-md-3">使用者</th>
                <th class="col-md-1">總額</th>
                <th class="col-md-1">匯款後四碼</th>
                <th class="col-md-2">建立日期</th>
                <th class="col-md-1">狀態</th>
                <th class="col-md-1 text-right">操作</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($investments as $investment)
                <tr>
                  <td>{{ $investment->currency->name }}</td>
                  <td>{{ $investment->user->platform }}</td>
                  <td>{{ $investment->user->email }}</td>
                  <td>{{ $investment->amount }}</td>
                  <td>{{ $investment->code ?? '-' }}</td>
                  <td>{{ $investment->created_at->format('Y/m/d H:i:s') }}</td>
                  <td>
                    @if ($investment->status == App\Investment::UNCONFIRMED)
                      <span class="label label-warning">未確認</span>
                    @elseif ($investment->status == App\Investment::ENABLED)
                      <span class="label label-success">處理中</span>
                    @else
                      <span class="label label-danger">已過期</span>
                    @endif
                  </td>
                  <td class="td-actions text-right">
                    <button
                      class="btn btn-round btn-success btn-xs confirm-button"
                      type="button"
                      data-action="{{ action('Panel\Admin\InvestmentController@update', $investment->id) }}"
                      data-method="PUT"
                      data-title="警告"
                      data-message="請問是否手動更新"
                      data-payload="{{ json_encode([
                          'status' => App\Investment::ENABLED
                      ]) }}"
                    >
                      <i class="material-icons">done</i>
                    </button>
                    <button
                      class="btn btn-round btn-danger btn-xs confirm-button"
                      type="button"
                      data-action="{{ action('Panel\Admin\InvestmentController@update', $investment->id) }}"
                      data-method="PUT"
                      data-title="警告"
                      data-message="請問是否手動更新"
                      data-payload="{{ json_encode([
                          'status' => App\Investment::EXPIRED
                      ]) }}"
                    >
                      <i class="material-icons">clear</i>
                    </button>
                  </td>
                </tr>
              @endforeach
              @if (!$investments->count())
                <tr>
                  <td colspan="8" class="text-muted text-center">沒有任何紀錄</td>
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
