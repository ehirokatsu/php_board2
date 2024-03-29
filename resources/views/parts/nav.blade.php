<div class="container">
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <nav class="navbar navbar-expand-sm navbar-light bg-light mt-3 mb-3 sticky-top offset-mt-3">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">My BBS</a>
        <div class="collapse navbar-collapse">
          <!--liクラス全てを中央配置にするのでulクラスにd-flex以降を記述する-->
          <ul class="navbar-nav d-flex align-items-center justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="/">TOP</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/create">新規投稿</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/search">検索</a>
            </li>
            <div></div>
            <li class="nav-item">
                <a class="nav-link" href="/user/{{ $user->id }}/edit">設定</a>
            </li>
            <li class="nav-item">
              <div class="icon">
                <!--ユーザー画像を表示する-->
                @include('parts.userImage')
                <!--ユーザ画像をマウスオーバーした時に表示する-->
                <div class="user-info">
                  <span>ユーザ名：{{$user->name}}</span>
                  <br>
                  <span>メールアドレス：{{$user->email}}</span>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <form action="/logout" method="post" style="margin: auto;">
                @csrf
                <button type="submit" class="btn btn-light">ログアウト</button>
              </form>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</div>