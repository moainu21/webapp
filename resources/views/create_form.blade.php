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
        <div class="item">
            <label for="school_years">学年:</label>
            <select name="school_years[]" class="school_years" required>
                <option value="">学年を選択してください</option>
                <option value="１年生">１年生</option>
                <option value="２年生">２年生</option>
                <option value="３年生">３年生</option>
                <option value="４年生">４年生</option>
                <option value="５年生">５年生</option>
                <option value="６年生">６年生</option>
            </select>
        </div><br>

        <div class="item">
            <label for="name">大会名:</label>
            <input type="text" name="name" id="name" required>
        </div><br>

        <div class="item">
            <label for="plase">会場:</label>
            <input type="text" name="plase" id="plase" required>
        </div><br>

        <div class="item">
            <label for="opponents">対戦相手:</label>
            <input type="text" name="opponents[]" class="opponents" required>
        </div><br>

        <div class="item">
            <label for="date">日程:</label>
            <input type="date" name="date" id="date" required>
        </div><br>

        <div class="item">
            <label for="start_time">開始時刻:</label>
            <input type="time" name="start_time" id="start_time" required>
        </div><br>

        <div class="item">
            <label for="time">試合時間:</label>
            <input type="number" name="time" id="time" required><label for="time">分</label>
        </div><br>

        <div class="item">
            <label for="court">コート数:</label>
            <input type="number" name="court" id="court" required><label for="court">個</label>
        </div><br>

        <div class="item">
            <label for="people">試合人数:</label>
            <input type="number" name="people" id="people" required><label for="people">人</label>
        </div><br>

        <div class="item">
            <label class="my-radio">試合形式:</label>
            <label for="interleague_match"><input type="radio" name="game" id="interleague_match" value="interleague_match" checked="on">交流戦</label>
            <label for="tournament"><input type="radio" name="game" id="tournament" value="tournament">トーナメント</label>
        </div><br>

        <div id="practice_match">
            <div class="item" id="count">
                <div class="btn_label">
                    <label for="number_of_matches" class="lavel">試合回数:</label>
                    <button type=”button” id="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                </div>
                <input type="number" name="number_of_matches" id="number_of_matches"><label for="number_of_matches">回</label>
            </div><br>

            <div class="item" id="finish">
                <div class="btn_label">
                    <label for="end_time" class="lavel">終了時間:</label>
                    <button type=”button” id="toggle_btn"><img src="image/change.jpg" alt="変化させるボタン"></button>
                </div>
                <input type="time" name="end_time" id="end_time">
            </div><br>

            <div class="item" id=interval_div>
                <label for="interval">試合間隔:</label>
                <input type="number" name="interval" id="interval"><label for="interval">分</label>
            </div><br>
        </div>

        <div id="official_match">
            <div class="item">
                <label for="qualifying_interval">予選試合間隔:</label>
                <input type="number" name="qualifying_interval" id="qualifying_interval"><label for="qualifying_interval">分</label>
            </div><br>

            <div class="item">
                <label for="semi_final_interval">準決勝準備時間:</label>
                <input type="number" name="semi_final_interval" id="semi_final_interval"><label for="semi_final_interval">分</label>
            </div><br>

            <div class="item">
                <label for="final_interval">決勝準備時間:</label>
                <input type="number" name="final_interval" id="final_interval"><label for="final_interval">分</label>
            </div><br>
        </div>

        <div class = half_time>
            <label for="half_time" class="my-radio">ハーフタイム:</label>
            <label for="true"><input type="radio" name="half_time_check" id="true" value="true" checked="on">あり</label>
            <label for="false"><input type="radio" name="half_time_check" id="false" value="false">なし</label>
            <button type="submit" id="next_btn">次へ</button>
        </div><br>

        <div id="half_time_input">
            <input type="number" name="half_time" id="half_time"><label for="half_time">分</label>
        </div>
    </form>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>
    <script src="js/create_form.js"></script>
</body>
</html>