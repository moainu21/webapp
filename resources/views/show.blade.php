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
        <div class="contents">
            @if (isset($schedules) && count($schedules) > 0)
                @foreach ($schedules as $schedule)
                    <div class="schedule-item">
                        <form method="POST" action="{{ route('show_schedule', $schedule->id) }}">
                            @csrf
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                            <button type="submit" class="date">{{ $schedule->date }}</button>
                        </form>
                        <form method="POST" action="{{ route('schedule.destroy', $schedule->id) }}" onsubmit="return confirm('本当に削除してもいいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>スケジュールが見つかりません。</p>
            @endif

        </div>
    </article>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>