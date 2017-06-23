@extends('layouts.base')

@section('title')
  收益紀錄
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="blue">
          <h4 class="title">收益明細列表</h4>
          <p class="category">此列表為詳細收益紀錄，但是不代表實際上的收入，實際上的收入請以 <a href="{{ action('Panel\WalletController@index') }}">錢包紀錄</a> 為準</p>
        </div>
        <div class="card-content table-responsive">
          <table class="table">
            <thead class="text-primary">
              <tr>
                <th class="col-md-2">類型</th>
                <th class="col-md-4">收益</th>
                <th class="col-md-3">分配比例</th>
                <th class="col-md-3">入帳時間</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($revenues as $revenue)
                <tr>
                  <td>{{ $revenue->currency->name }}</td>
                  <td>{!! amount_output($revenue->amount) !!}</td>
                  <td>{{ $revenue->percentage ? ($revenue->percentage * 100) . '%' : '-' }}</td>
                  <td>{{ $revenue->created_at->format('Y/m/d H:i:s') }}</td>
                </tr>
              @endforeach
              @if (!$revenues->count())
                <tr>
                  <td colspan="4" class="text-muted text-center">沒有任何紀錄</td>
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
