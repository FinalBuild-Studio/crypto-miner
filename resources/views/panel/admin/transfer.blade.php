@extends('layouts.base')

@section('title')
  待轉帳
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
                <th class="col-md-3">使用者</th>
                <th class="col-md-3">總額</th>
                <th class="col-md-3">賣點</th>
                <th class="col-md-2 text-right">操作</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transfers as $transfer)
                <tr>
                  <td>{{ $transfer->currency->name }}</td>
                  <td>{{ $transfer->user->name }}</td>
                  <td>{!! amount_output($transfer->amount) !!}</td>
                  <td>{{ $transfer->price_at }}</td>
                  <td class="td-actions text-right">
                    @if ($transfer->status == App\Transfer::WAITING)
                      <button
                        class="btn btn-round btn-warning btn-xs confirm-button"
                        type="button"
                        data-action="{{ action('Panel\Admin\TransferController@update', $transfer->id) }}"
                        data-method="PUT"
                        data-title="警告"
                        data-message="請問是否手動更新"
                        data-payload="{{ json_encode([
                            'status' => App\Transfer::PROCESSING
                        ]) }}"
                      >
                        <i class="material-icons">shopping_cart</i>
                      </button>
                    @else
                      <button
                        class="btn btn-round btn-success btn-xs confirm-button"
                        type="button"
                        data-action="{{ action('Panel\Admin\TransferController@update', $transfer->id) }}"
                        data-method="PUT"
                        data-title="警告"
                        data-message="請問是否手動更新"
                        data-payload="{{ json_encode([
                            'status' => App\Transfer::DONE
                        ]) }}"
                      >
                        <i class="material-icons">done</i>
                      </button>
                    @endif
                  </td>
                </tr>
              @endforeach
              @if (!$transfers->count())
                <tr>
                  <td colspan="5" class="text-muted text-center">沒有任何紀錄</td>
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
