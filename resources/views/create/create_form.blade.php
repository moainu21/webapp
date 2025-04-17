<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入力画面</title>
    <link rel="stylesheet" href="css/create_form.css">
</head>
<body>
    <header>
        <h1>スケジュール作成画面</h1><br>
        @php
            $formData = session('form_data', []);
            $currentStep = $step ?? 1;

            $steps = [
                1 => ['label' => '基本情報', 'key' => 'step1'],
                2 => ['label' => '試合情報', 'key' => 'step2'],
                3 => ['label' => '詳細情報', 'key' => 'step3'],
                4 => ['label' => '確認', 'key' => null], // 確認画面はセッションには依存しない
            ];
        @endphp

        <div class="steps">
            @foreach ($steps as $num => $stepData)
                @php
                    $key = $stepData['key'];
                    $label = $stepData['label'];

                    $status = 'step';
                    if ($currentStep == $num) {
                        $status = 'current-step';
                    } elseif ($key && !empty($formData[$key])) {
                        $status = 'completed-step';
                    }
                @endphp

                <span class="{{ $status }}">{{ $label }}</span>
                @if (!$loop->last)
                    →
                @endif
            @endforeach
        </div>
    </header>
    <hr>
    <form action="{{ route('create_check') }}" method="POST">
        @csrf
        @php
            $formData = session('form_data', []);
            $step1 = $formData['step1'] ?? [];
            $step2 = $formData['step2'] ?? [];
            $step3 = $formData['step3'] ?? [];
        @endphp

        <input type="hidden" name="step" id="step_num" value="{{ $step ?? 1 }}">
        @if ($step == 1)
            <div id="basic_info" class="fixed-section">
                <h2>基本情報</h2>
                <div class="item">
                    <label>学年:</label><br>
                    @php
                        $schoolYears = $step1['school_years'] ?? [];
                    @endphp
                    @foreach (['１年生', '２年生', '３年生', '４年生', '５年生', '６年生'] as $year)
                        <label>
                            <input type="checkbox" name="school_years[]" value="{{ $year }}" 
                                {{ in_array($year, $schoolYears) ? 'checked' : '' }}>
                            {{ $year }}
                        </label><br>
                    @endforeach
                </div><br>

                <div class="item">
                    <label for="name">大会名:</label>
                    <input type="text" name="name" id="name" value="{{ $step1['name'] ?? '' }}" required>
                </div><br>

                <div class="item">
                    <label for="place">会場:</label>
                    <input type="text" name="place" id="place" value="{{ $step1['place'] ?? '' }}" required>
                </div><br>

                <div class="item">
                    <label for="opponents">対戦相手:</label>
                    <div id="opponent-container">
                        @php
                            $opponents = $step1['opponents'] ?? [];
                            if (!empty($opponents)) {
                                array_pop($opponents); // 配列の最後の値を削除
                            }
                        @endphp
                        @if (empty($opponents))
                            <div class="opponent-item">
                                <input type="text" name="opponents[]" class="opponents" required>
                            </div>
                            <div class="opponent-item">
                                <input type="text" name="opponents[]" class="opponents">
                            </div>
                            <div class="opponent-item">
                                <input type="text" name="opponents[]" class="opponents">
                            </div>
                        @endif
                        @foreach ($opponents as $opponent)
                            <div class="opponent-item">
                                <input type="text" name="opponents[]" class="opponents" value="{{ $opponent }}">
                            </div>
                        @endforeach
                        <div class="opponent-item">
                            <input type="text" name="opponents[]" class="opponents">
                        </div>
                    </div>

                    <div id="button_opponent">
                        <button type="button" id="add-opponent">＋追加</button>
                        <button type="button" id="remove-opponent">削除</button>
                    </div>

                </div><br>

                <div class="item">
                    <label for="date">日程:</label>
                    <input type="date" name="date" id="date" value="{{ $step1['date'] ?? '' }}" required>
                </div><br>

                <div class="item">
                    <label for="start_time">開始時刻:</label>
                    <input type="time" name="start_time" id="start_time" value="{{ $step1['start_time'] ?? '' }}" required>
                </div><br>
            </div>
        @elseif ($step == 2)
            <div id="game_info" class="fixed-section">
                <h2>試合情報</h2>
                <div class="item">
                    <label for="time">試合時間:</label>
                    <input type="number" name="time" id="time" value="{{ $step2['time'] ?? '10' }}" min="1" max="45" required><label for="time">分</label>
                </div><br>

                <div class="item">
                    <label for="court">コート数:</label>
                    <input type="number" name="court" id="court" min="1" value="{{ $step2['court'] ?? '1' }}" required><label for="court">個</label>
                </div><br>

                <div class="item">
                    <label for="people">試合人数:</label>
                    <input type="number" name="people" id="people" min="1" value="{{ $step2['people'] ?? '6' }}" required><label for="people">人</label>
                </div><br>
            </div>
        @elseif ($step == 3)
            <div id="detail_info" class="fixed-section">
                <h2>詳細情報</h2>
                <div class="item">
                    <label class="my-radio">試合形式:</label>
                    <label for="interleague_match"><input type="radio" name="game" id="interleague_match" value="interleague_match" {{ ($step2['game'] ?? 'interleague_match') == 'interleague_match' ? 'checked' : '' }}>交流戦</label>
                    <label for="tournament"><input type="radio" name="game" id="tournament" value="tournament" {{ ($step2['game'] ?? '') == 'tournament' ? 'checked' : '' }}>トーナメント</label>
                </div><br>

                <div id="practice_match">
                    <div class="item" id="count">
                        <div class="btn_label">
                            <label for="number_of_matches" class="lavel">試合回数:</label>
                            <button type="button" class="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                        </div>
                        <input type="number" name="number_of_matches" id="number_of_matches" min="1" value="{{ $step3['number_of_matches'] ?? '' }}"><label for="number_of_matches">回</label>
                    </div><br>

                    <div class="item" id="finish">
                        <div class="btn_label">
                            <label for="end_time" class="lavel">終了時間:</label>
                            <button type="button" class="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                        </div>
                        <input type="time" name="end_time" id="end_time" value="{{ $step3['end_time'] ?? '' }}">
                    </div><br>

                    <div class="item" id=interval_div>
                        <label for="interval">試合間隔:</label>
                        <input type="number" name="interval" id="interval" min="0" value="{{ $step3['interval'] ?? '5' }}"><label for="interval">分</label>
                    </div><br>
                </div>

                <div id="official_match">
                    <div class="item">
                        <label for="qualifying_group">予選グループ数:</label>
                        <input type="number" name="qualifying_group" id="qualifying_group" min="0" value="{{ $step3['qualifying_group'] ?? '' }}"><label for="qualifying_group">個</label>
                    </div><br>

                    <div class="item">
                        <label for="qualifying_interval">予選試合間隔:</label>
                        <input type="number" name="qualifying_interval" id="qualifying_interval" min="0" value="{{ $step3['qualifying_interval'] ?? '' }}"><label for="qualifying_interval">分</label>
                    </div><br>

                    <div class="item">
                        <label for="semi_final_interval">準決勝準備時間:</label>
                        <input type="number" name="semi_final_interval" id="semi_final_interval" min="0" value="{{ $step3['semi_final_interval'] ?? '' }}"><label for="semi_final_interval">分</label>
                    </div><br>

                    <div class="item">
                        <label for="final_interval">決勝準備時間:</label>
                        <input type="number" name="final_interval" id="final_interval" min="0" value="{{ $step3['final_interval'] ?? '' }}"><label for="final_interval">分</label>
                    </div><br>
                </div>

                <div class = "half_time">
                    <label for="half_time" class="my-radio">ハーフタイム:</label>
                    <label for="true"><input type="radio" name="half_time_check" id="true" value="true" {{ ($step3['half_time_check'] ?? 'true') == 'true' ? 'checked' : '' }}>あり</label>
                    <label for="false"><input type="radio" name="half_time_check" id="false" value="false" {{ ($step3['half_time_check'] ?? '') == 'false' ? 'checked' : '' }}>なし</label>
                </div><br>

                <div id="half_time_input">
                    <input type="number" name="half_time" id="half_time" min="1" value="{{ $step3['half_time'] ?? '' }}"><label for="half_time">分</label>
                </div>
            </div>
        @endif
        <button type="submit" id="next_btn">次へ</button>
    </form>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>
    <script src="js/create_form.js"></script>
</body>
</html>