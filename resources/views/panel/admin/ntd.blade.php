@extends('layouts.base')

@section('title')
  台幣帳戶
@endsection

@section('search')
  <form class="navbar-form navbar-right" role="search">
    <div class="form-group is-empty">
      <input name="email" type="text" class="form-control" placeholder="請輸入email">
      <span class="material-input"></span>
      <span class="material-input"></span>
    </div>
    <button type="submit" class="btn btn-white btn-round btn-just-icon">
      <i class="material-icons">search</i>
      <div class="ripple-container"></div>
    </button>
  </form>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-1">平台</th>
                <th class="col-md-4">E-mail</th>
                <th class="col-md-1">銀行代碼</th>
                <th class="col-md-3">帳號</th>
                <th class="col-md-2">餘額</th>
                <th class="col-md-1">操作</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->platform }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->bank_code ?? '-' }}</td>
                  <td>{{ $user->bank_account ?? '-' }}</td>
                  <td>{{ App\Wallet::who($user->id)->currencyType(App\Currency::TWD)->sum('amount') }}</td>
                  <td class="td-actions">
                    <button
                      class="btn btn-round btn-danger btn-xs confirm-button"
                      type="button"
                      data-method="POST"
                      data-title="警告"
                      data-message="請問是否已經匯款到指定帳戶"
                      data-payload="{{ json_encode(['user_id' => $user->id]) }}"
                    >
                      <i class="material-icons">attach_money</i>
                    </button>
                  </td>
                </tr>
              @endforeach
              @if (!$users->count())
                <tr>
                  <td colspan="6" class="text-muted text-center">沒有任何紀錄</td>
                </tr>
              @endif
            </tbody>
          </table>
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
