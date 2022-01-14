<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <nav class="header-wrap container">
            <p ><a class="header-wrap__ttl" href="/">Study Timer</a></p>
            <div class="header-wrap__time">
                <span>今日の学習時間: </span>
                <span id="todayTime"><span>{{$data}}</span></span>

            </div>
        </nav>
    </header>
    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('/js/main.js') }}"></script>
</body>
</html>