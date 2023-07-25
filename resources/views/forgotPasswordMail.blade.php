<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data['title']}}</title>
</head>
<body style="margin: 100px;">
    <h1>You have requested to reset your password</h1>
    <hr>
    <p>We cannot simply send you your old password. A unique link to reset your
        password has been generated for you. To reset your password, click the
        following link and follow the instructions.</p>
    <p>{{$data['body']}}</p>
    <h1><a href="{{$data['url']}}">please click this link to reset your password</a></h1>
    <p>thank you</p>
</body>
</html>