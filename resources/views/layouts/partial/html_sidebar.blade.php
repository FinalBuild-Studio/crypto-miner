<div class="logo">
  <a href="#" class="simple-text">
    BTC/ETH Miner
  </a>
</div>
<div class="sidebar-wrapper">
  <ul class="nav">
    <li>
      <a href="{{ action('Panel\DashboardController@index') }}">
        <i class="material-icons">dashboard</i>
        <p>總覽</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\RevenueController@index') }}">
        <i class="material-icons">bookmark</i>
        <p>收益紀錄</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\WalletController@index') }}">
        <i class="material-icons">library_books</i>
        <p>錢包紀錄</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\TransferController@index') }}">
        <i class="material-icons">swap_horiz</i>
        <p>轉帳紀錄</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\InvestmentController@index') }}">
        <i class="material-icons">content_paste</i>
        <p>投資紀錄</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\DisclaimController@index') }}">
        <i class="material-icons">error_outline</i>
        <p>聲明</p>
      </a>
    </li>
    <li>
      <a href="{{ action('Panel\ConfigController@index') }}">
        <i class="material-icons">build</i>
        <p>設定</p>
      </a>
    </li>
    @if (Auth::user()->is_admin)
      <li>
        <a href="{{ action('Panel\Admin\InvestmentController@index') }}">
          <i class="material-icons">content_paste</i>
          <p>未處理訂單</p>
        </a>
      </li>
      <li>
        <a href="{{ action('Panel\Admin\TransferController@index') }}">
          <i class="material-icons">feedback</i>
          <p>待轉帳</p>
        </a>
      </li>
      <li>
        <a href="{{ action('Panel\Admin\NTDController@index') }}">
          <i class="material-icons">credit_card</i>
          <p>台幣帳戶</p>
        </a>
      </li>
      <li>
        <a href="{{ action('Panel\Admin\OperationController@index') }}">
          <i class="material-icons">extension</i>
          <p>操控面板</p>
        </a>
      </li>
    @endif
  </ul>
</div>
