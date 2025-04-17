<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>試合スケジュール</title>
    <link rel="stylesheet" href="css/index.css">

</head>
<body>
    <header>
        <h1>試合スケジュール管理システム</h1><br>
    </header>
    <hr>
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    <article>
        <div class="side">
            <button id="create">作成</button>
            <button id="show">閲覧</button>
        </div>
        <div class="contents">
            <div class="create-contents">
                <h2>スケジュール作成</h2>
                <a href="{{ route('create_form') }}">試合</a><br>
                <a href="#">カレンダー</a><br>
            </div>
            <div class="show-contents">
                <h2>試合スケジュール（過去）</h2>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="1">
                    <button type="submit" class="school_years">１年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="2">
                    <button type="submit" class="school_years">２年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="3">
                    <button type="submit" class="school_years">３年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="4">
                    <button type="submit" class="school_years">４年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="5">
                    <button type="submit" class="school_years">５年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="6">
                    <button type="submit" class="school_years">６年生</button>
                </form>
                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="calender">カレンダー</button>
                </form>
                <h2>試合スケジュール（予定）</h2>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="1">
                    <button type="submit" class="school_years">１年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="2">
                    <button type="submit" class="school_years">２年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="3">
                    <button type="submit" class="school_years">３年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="4">
                    <button type="submit" class="school_years">４年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="5">
                    <button type="submit" class="school_years">５年生</button>
                </form>
                <form method="POST" action="{{ route('show') }}">
                    @csrf
                    <input type="hidden" name="school_year" value="6">
                    <button type="submit" class="school_years">６年生</button>
                </form>
                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="calender">カレンダー</button>
                </form>
            </div>

        </div>
    </article>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>