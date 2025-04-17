<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <link rel="stylesheet" href="css/create_check.css">
</head>
<body>
    <h1>{{ $schedule->tournament->name }}</h1>
    <div class="school">
        <span class="schoolyear">
            @foreach ($schedule->schoolYears as $schoolYear)
                <h2>{{ $schoolYear->name }}</h2>
            @endforeach
        </span>

        <h2>日程：{{ $schedule->date }}</h2>
    </div>
    <div class="address">
        <h2>会場：{{  $schedule->place->name }}</h2>
    </div>
    <div class="gameinfo">
        <h2>試合時間：{{ $schedule->time }}分1本</h2>
        <h2>試合人数：{{ $schedule->people }}人制</h2>
    </div>


    @php
        use Carbon\Carbon;

        $n = 0;
        $count = $schedule->number_of_matches ?? 0;
        $endTime = $schedule->end_time ?? '00:00';
        $startTime = $schedule->start_time ?? '00:00';
        $time = $schedule->time ?? 0;
        $interval = $schedule->interval ?? 0;
        $halfTime = $schedule->half_time ?? 0;
        $halfTimeCheck = $schedule->half_time_check ?? 'false';

        $carbonStartTime = Carbon::parse($startTime);
        $carbonEndTime = Carbon::parse($endTime);

        $opponents = [];

        foreach ($schedule->opponents as $opponent){
            $opponents[] = $opponent->name;
        }
        dd($opponents);
        $opponentsCount = count($opponents);
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
                $scheduled_matches[] = ['match' => $match, 'referee' => $halfTimeCheck == 'true'? $match : $referee,];     // halfTimeありなら両者
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
    <div class="schedule">
        @if ($count > 0)

            @for ($i = 1; $i <= $count; $i++)

                <div class="match">
                    <h3>{{ $i }}試合目</h3>

                    <div class="match-info">
                    
                        <p>{{ htmlspecialchars($scheduled_matches[$n]['match'][0]) }} vs {{ htmlspecialchars($scheduled_matches[$n]['match'][1]) }}</p>

                        @php
                            $teamA = $scheduled_matches[$n]['match'][0];
                            $teamB = $scheduled_matches[$n]['match'][1];
                        @endphp

                        @php
                            $newTime = $carbonStartTime->copy()->addMinutes($time)->format('H:i');
                        @endphp
                        <div class="halftime">
                            @if ($halfTimeCheck == 'true')
                                {{-- halfTime がある場合 --}}
                                <h4>前半</h4>
                            @endif

                            <p>{{ $carbonStartTime->format('H:i') }} ~ {{ $newTime }}</p>

                            @if ($halfTimeCheck == 'true')

                                <h4>後半</h4>

                                @php
                                    $carbonStartTime->addMinutes($time + $halfTime);
                                    $newTime = $carbonStartTime->copy()->addMinutes($time)->format('H:i');
                                @endphp

                                <p>{{ $carbonStartTime->format('H:i') }} ~ {{ $newTime }}</p>
                                
                            @endif
                        </div>
                        
                        @php
                            $carbonStartTime->addMinutes($time + $interval);
                        @endphp

                        <div class="referee">
                            @if ($halfTimeCheck == 'true')
                                {{-- 前半 --}}
                                <h4>前半審判</h4>
                                <p>{{ $teamA }}</p>
                                {{-- 後半 --}}
                                <h4>後半審判</h4>
                                <p>{{ $teamB }}</p>
                            @else
                                {{-- halfTime がない通常試合 --}}
                                @if ($opponentsCount == 2)
                                    <h4>審判</h4>
                                    @if ($i % 2 == 0)
                                        <p>{{ $teamB }}</p>
                                    @elseif ($i % 2 == 1)
                                        <p>{{ $teamA }}</p>
                                    @endif
                                @else
                                    <h4>審判</h4>
                                    <p>{{ $scheduled_matches[$n]['referee'] }}</p>
                                @endif
                            @endif
                        </div>

                        @if ($n < count($scheduled_matches) - 1)
                            @php
                                $n++;
                            @endphp
                        @else
                            @php
                                $n = 0;
                            @endphp
                        @endif
                    </div>

                </div>
                
            @endfor

        @endif
    </div>

    <div class="btn">

        <form id="BackHome" method="POST" action="{{ route('index') }}">
            @csrf
            <button type="submit" class="btn_back">戻る</button>
        </form>

        <form id="edit" method="POST" action="#">
            @csrf
            <button type="submit" class="btn_edit">編集</button>
        </form>

        <form method="POST" action="{{ route('schedule.destroy', $schedule->id) }}" onsubmit="return confirm('本当に削除してもいいですか？');">
            @csrf
            @method('DELETE')
            <button type="submit">削除</button>
        </form>
        
    </div>
</body>
</html>