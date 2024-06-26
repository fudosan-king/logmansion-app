<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>
<body>
    <p>{{ $user->client_name }}様</p>

    <p>いつもご利用いただきありがとうございます。<br>
    {{ $user->client_name }}様のログインIDは以下の通りです。</p>

    <p>ログインID：<strong>{{ $user->client_id }}</strong></p>

    <p>こちらのIDにてログインしてください。<br>
    IDをお忘れになった場合は、再度このメールをご確認ください。</p>

    <p>※本メールに心当たりが無い場合は破棄をお願いいたします。<br>
    ※送信専用メールアドレスのため、直接の返信はできません。</p>
</body>
</html>
