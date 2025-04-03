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
    </header>
    <hr>
    <form action="{{ route('create_check') }}" method="POST">
        @csrf
        <div id="basic_info">
            <h1>基本情報</h1>
            <div class="item">
                <label>学年:</label><br>
                @php
                $schoolYears = session('school_years', []);
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
                <input type="text" name="name" id="name" value="{{ session('name', '') }}" required>
            </div><br>

            <div class="item">
                <label for="plase">会場:</label>
                <input type="text" name="plase" id="plase" value="{{ session('plase', '') }}" required>
            </div><br>

            <div class="item">
                <label for="opponents">対戦相手:</label>
                <div id="opponent-container">
                    @php
                        $opponents = session('opponents', []);
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
                <input type="date" name="date" id="date" value="{{ session('date', '') }}" required>
            </div><br>

            <div class="item">
                <label for="start_time">開始時刻:</label>
                <input type="time" name="start_time" id="start_time" value="{{ session('start_time', '') }}" required>
            </div><br>
        </div>
        <div id="game_info">
            <h1>試合情報</h1>
            <div class="item">
                <label for="time">試合時間:</label>
                <input type="number" name="time" id="time" value="{{ session('time', '10') }}" min="1" max="45" required><label for="time">分</label>
            </div><br>

            <div class="item">
                <label for="court">コート数:</label>
                <input type="number" name="court" id="court" min="1" value="{{ session('court', '1') }}" required><label for="court">個</label>
            </div><br>

            <div class="item">
                <label for="people">試合人数:</label>
                <input type="number" name="people" id="people" min="1" value="{{ session('people', '6') }}" required><label for="people">人</label>
            </div><br>
        </div>

        <div id="detail_info">
            <div class="item">
                <label class="my-radio">試合形式:</label>
                <label for="interleague_match"><input type="radio" name="game" id="interleague_match" value="interleague_match" {{ session('game') == 'interleague_match' ? 'checked' : 'on' }}>交流戦</label>
                <label for="tournament"><input type="radio" name="game" id="tournament" value="tournament" {{ session('game') == 'tournament' ? 'checked' : '' }}>トーナメント</label>
            </div><br>

            <div id="practice_match">
                <div class="item" id="count">
                    <div class="btn_label">
                        <label for="number_of_matches" class="lavel">試合回数:</label>
                        <button type=”button” id="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                    </div>
                    <input type="number" name="number_of_matches" id="number_of_matches" min="1" value="{{ session('number_of_matches', '') }}"><label for="number_of_matches">回</label>
                </div><br>

                <div class="item" id="finish">
                    <div class="btn_label">
                        <label for="end_time" class="lavel">終了時間:</label>
                        <button type=”button” id="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                    </div>
                    <input type="time" name="end_time" id="end_time" value="{{ session('end_time', '') }}">
                </div><br>

                <div class="item" id=interval_div>
                    <label for="interval">試合間隔:</label>
                    <input type="number" name="interval" id="interval" min="0" value="{{ session('interval', '5') }}"><label for="interval">分</label>
                </div><br>
            </div>

            <div id="official_match">
                <div class="item">
                    <label for="qualifying_interval">予選試合間隔:</label>
                    <input type="number" name="qualifying_interval" id="qualifying_interval" min="0" value="{{ session('qualifying_interval', '') }}"><label for="qualifying_interval">分</label>
                </div><br>

                <div class="item">
                    <label for="semi_final_interval">準決勝準備時間:</label>
                    <input type="number" name="semi_final_interval" id="semi_final_interval" min="0" value="{{ session('semi_final_interval', '') }}"><label for="semi_final_interval">分</label>
                </div><br>

                <div class="item">
                    <label for="final_interval">決勝準備時間:</label>
                    <input type="number" name="final_interval" id="final_interval" min="0" value="{{ session('final_interval', '') }}"><label for="final_interval">分</label>
                </div><br>
            </div>

            <div class = half_time>
                <label for="half_time" class="my-radio">ハーフタイム:</label>
                <label for="true"><input type="radio" name="half_time_check" id="true" value="true" {{ session('half_time_check') == 'true' ? 'checked' : 'on' }}>あり</label>
                <label for="false"><input type="radio" name="half_time_check" id="false" value="false" {{ session('half_time_check') == 'false' ? 'checked' : '' }}>なし</label>
                <button type="submit" id="next_btn">次へ</button>
            </div><br>

            <div id="half_time_input">
                <input type="number" name="half_time" id="half_time" min="0" value="{{ session('half_time', '') }}"><label for="half_time">分</label>
            </div>
        </div>
    </form>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>
    <script src="js/create_form.js"></script>
</body>
</html>