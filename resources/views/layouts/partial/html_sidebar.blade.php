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
      <a href="{{ action('Panel\Admin\PendingController@index') }}">
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
  </ul>
</div>
