<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
</head>
<body>
    <h1>{{ session('name') }}</h1>
    @php
        $schoolYears = session('school_years')
    @endphp
    @foreach ($schoolYears as $school)
        <h2>{{ $school }}</h2>
    @endforeach
    <h2>日程：{{ session('date') }}</h2>
    <h2>会場：{{ session('plase') }}</h2>
    <h2>試合時間：{{ session('time') }}分1本</h2>
    <h2>試合人数：{{ session('people') }}人制</h2>

    @php
        use Carbon\Carbon;

        $n = 0;
        $count = session('number_of_matches',0);
        $endTime = session('end_time','00:00');
        $startTime = session('start_time');
        $time = session('time');
        $interval = session('interval');
        $halfTime = session('half_time',0);

        $carbonStartTime = Carbon::createFromFormat('H:i', $startTime);
        $carbonEndTime = Carbon::createFromFormat('H:i', $endTime);

        $opponents = session('opponents');
        $opponentsCount = session('opponents_count');
        $matches = [];

        for ($i = 0; $i < count($opponents); $i++) {
            for ($j = $i + 1; $j < count($opponents); $j++) {
                $matches[] = [$opponents[$i], $opponents[$j]];
            }
        }
    
        // 試合の順番を調整する
        $scheduled_matches = [];
        $last_match = []; // 直前の試合
        $consecutive_counts = array_fill_keys($opponents, 0);; // 連続試合回数
        $referee_counts = array_fill_keys($opponents, 0); // 審判回数を追跡する配列

        for ($i = 0; $i < $count; $i++) {
            foreach ($matches as $index => $match) {
                $t1 = $match[0];
                $t2 = $match[1];

                // 連続試合をチェック（同じチームが3試合連続しないように）
                if (
                    (isset($consecutive_counts[$t1]) && $consecutive_counts[$t1] >= 2) ||
                    (isset($consecutive_counts[$t2]) && $consecutive_counts[$t2] >= 2)
                ) {
                    continue; // 連続試合が3回以上になりそうならスキップ
                }

                // どちらのプレイヤーが審判をするか決定（審判回数が少ない方を選ぶ）
                $referee = ($referee_counts[$t1] <= $referee_counts[$t2]) ? $t1 : $t2;

                // スケジュールに追加
                $scheduled_matches[] = ['match' => $match, 'referee' => $referee];
                unset($matches[$index]); // 削除

                // 直前の試合を更新
                $last_match = $match;

                // 連続試合回数を更新
                $consecutive_counts[$t1] = isset($consecutive_counts[$t1]) ? $consecutive_counts[$t1] + 1 : 1;
                $consecutive_counts[$t2] = isset($consecutive_counts[$t2]) ? $consecutive_counts[$t2] + 1 : 1;

                // 他のチームの連続カウントをリセット
                foreach ($opponents as $opponent) {
                    if ($opponent !== $t1 && $opponent !== $t2) {
                        $consecutive_counts[$opponent] = 0;
                    }
                }
                // 審判の回数を更新
                $referee_counts[$referee]++;
            }
        }

    @endphp
    <div id="schedule">
    @if ($count > 0)

        @for ($i = 1; $i <= $count; $i++)
            <div class="match">
                

                <p>{{ $i }}試合目</p>
                <p>{{ htmlspecialchars($scheduled_matches[$n]['match'][0]) }} vs {{ htmlspecialchars($scheduled_matches[$n]['match'][1]) }}</p>

                <p>審判: {{ htmlspecialchars($scheduled_matches[$n]['referee']) }}</p>

                @if ($n < count($scheduled_matches) - 1)
                    @php
                        $n++;
                    @endphp
                @else
                    @php
                        $n = 0;
                    @endphp
                @endif

                @php
                    $newTime = $carbonStartTime->copy()->addMinutes($time)->format('H:i');
                @endphp
                @if ($halfTime > 0)
                    <p>前半</p>
                @endif

                <p>{{ $carbonStartTime->format('H:i') }} ~ {{ $newTime }}</p>

                @if ($halfTime > 0)

                    <p>後半</p>

                    @php
                        $carbonStartTime->addMinutes($time);
                        $carbonStartTime->addMinutes($halfTime);
                        $newTime = $carbonStartTime->copy()->addMinutes($time)->format('H:i');
                    @endphp

                    <p>{{ $carbonStartTime->format('H:i') }} ~ {{ $newTime }}</p>
                    
                @endif

                @php
                    $carbonStartTime->addMinutes($time + $interval);
                @endphp

            </div>
            
        @endfor

    @endif
    </div>

    <button onclick="location.href='{{ url()->previous() }}'" class="btn_back">戻る</button>
</body>
</html>