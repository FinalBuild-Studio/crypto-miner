@extends('layouts.base')

@section('title')
  設定
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
          <h4 class="title">匯款前請先確認以下資訊是否填寫正確</h4>
          <p class="category">處理匯款時，會依照請求款項提領匯款，相關資料依照下面設定的為準</p>
        </div>
        <div class="card-content">
          <form method="POST">
            {{ csrf_field() }}
            <div class="form-group label-floating is-empty">
              <label class="control-label">姓名</label>
              <input name="name" type="text" class="form-control">
              <span class="material-input"></span>
            </div>
            <div class="form-group label-floating is-empty">
              <label class="control-label">銀行代碼</label>
              <input name="bank_code" type="text" class="form-control">
              <span class="material-input"></span>
            </div>
            <div class="form-group label-floating is-empty">
              <label class="control-label">銀行帳號</label>
              <input name="bank_account" type="text" class="form-control">
              <span class="material-input"></span>
            </div>
            <div class="form-group form-button">
              <button type="submit" class="btn btn-fill btn-primary pull-right">更新</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
