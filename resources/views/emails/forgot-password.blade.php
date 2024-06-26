<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>
<body>
    <p>{{ $user->client_name }}様</p>

    <p>いつもご利用いただきありがとうございます。<br>
    {{ $user->client_name }}様のパスワードを以下に変更させていただきました。</p>

    <p>パスワード：<strong>{{ $newPassword }}</strong></p>

    <p>こちらのパスワードにてログインしてください。<br>
    パスワードの変更を希望される方は、このパスワードでログイン後、マイアカウント＞パスワードの変更にてお手続きください。</p>

    <p>※送信専用メールアドレスのため、直接の返信はできません。</p>

    <p>ログマンションオーナーズクラブ事務局</p>
</body>
</html>
