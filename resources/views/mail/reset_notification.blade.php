<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar container-fluid shadow" style="background-color: rgb(1, 104, 183);">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}/">
                    {{-- <img src="{{url('/')}}/vision/logo_watashiga.png" alt="Logo" class="d-inline-block align-text-top ms-2"> --}}
                </a>
            </div>
        </nav>
        <main>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        パスワード変更完了通知
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-left">
                                <h5 class="card-title">{{ $adminUser->name }} 様</h5>
                                <p class="card-text mt-2">
                                    ご登録されているアカウントのパスワードを変更しました。
                                    ※ロックアウトによりパスワードを変更された方は、15分経過後にログイン可能となります。
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row ms-2">
                            <div class="col">
                                <p class="card-text">ログインメールアドレス： {{ $adminUser->email }}</p>
                                <p class="card-text">パスワード： {{ $password }}</p>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <a href="{{url('/')}}/" class="btn btn-primary">ログイン画面へ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>


    {{-- <body>
        <main>
            <div class="card">
                <div class="card-header">
                    パスワード変更完了通知
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $adminUser->name }} 様</h5>
                    <p class="card-text">
                        リクリンクの管理画面へアクセスできるアカウントのパスワードを変更しました。
                    </p>
                    <p class="card-text">
                        ログインメールアドレス: {{ $adminUser->email }}
                    </p>
                    <p class="card-text">
                        パスワード: {{ $password }}
                    </p>
                    <a href="{{url('/')}}/admin" class="btn btn-primary">riclink 管理画面</a>
                </div>
            </div>
        </main>
    </body> --}}
</html>
