<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <link rel="stylesheet" href="css/create_check.css">
</head>
<header>
    <div class="steps">
        <span class="completed-step">基本情報→試合情報→詳細情報→</span><span class="current-step">確認</span>
    </div>
    <hr>
</header>
<body>
    @php
        $formData = session('form_data', []);
        $step1 = $formData['step1'] ?? [];
        $step2 = $formData['step2'] ?? [];
        $step3 = $formData['step3'] ?? [];
    @endphp

    <h1>{{ $step1['name'] ?? '' }}</h1>
    <div class="school">
        <span class="schoolyear">
            @foreach ($step1['school_years'] ?? [] as $school)
                <h2>{{ $school }}</h2>
            @endforeach
        </span>

        <h2>日程：{{ $step1['date'] ?? '' }}</h2>
    </div>
    <div class="address">
        <h2>会場：{{ $step1['plase'] ?? '' }}</h2>
    </div>
    <div class="gameinfo">
        <h2>試合時間：{{ $step2['time'] ?? '' }}分1本</h2>
        <h2>試合人数：{{ $step2['people'] ?? '' }}人制</h2>
    </div>


    @php
        use Carbon\Carbon;

        $n = 0;
        $count = $step3['number_of_matches'] ?? 0;
        $endTime = $step3['end_time'] ?? '00:00';
        $startTime = $step1['start_time'] ?? '00:00';
        $time = $step2['time'] ?? 0;
        $interval = $step3['interval'] ?? 0;
        $halfTime = $step3['half_time'] ?? 0;

        $carbonStartTime = Carbon::createFromFormat('H:i', $startTime);
        $carbonEndTime = Carbon::createFromFormat('H:i', $endTime);

        $opponents = $step1['opponents'] ?? [];
        $opponentsCount = $step1['opponents_count'];
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
                $scheduled_matches[] = ['match' => $match, 'referee' => $halfTime > 0 ? $match : $referee,];     // halfTimeありなら両者
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
                

                <h3>{{ $i }}試合目</h3>
                <p>{{ htmlspecialchars($scheduled_matches[$n]['match'][0]) }} vs {{ htmlspecialchars($scheduled_matches[$n]['match'][1]) }}</p>

                @php
                    $teamA = $scheduled_matches[$n]['match'][0];
                    $teamB = $scheduled_matches[$n]['match'][1];
                @endphp

                @php
                    $newTime = $carbonStartTime->copy()->addMinutes($time)->format('H:i');
                @endphp
                <div class="halftime">
                    @if ($halfTime > 0)
                        <h4>前半</h4>
                    @endif

                    <p>{{ $carbonStartTime->format('H:i') }} ~ {{ $newTime }}</p>

                    @if ($halfTime > 0)

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
                    @if ($halfTime > 0)
                        {{-- 前半 --}}
                        <h4>前半審判</h4>
                        <p>{{ $teamA }}</p>
                        {{-- 後半 --}}
                        <h4>後半審判</h4>
                        <p>{{ $teamB }}</p>
                    @else
                        {{-- halfTime がない通常試合 --}}
                        <p>審判: {{ $scheduled_matches[$i]['referee'] }}</p>
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
            
        @endfor

    @endif
    </div>

    <form id="backForm" method="POST" action="{{ route('create.form') }}">
        @csrf
        <input type="hidden" name="step" value="0">
        <button type="submit" class="btn_back">戻る</button>
    </form>

</body>
</html>