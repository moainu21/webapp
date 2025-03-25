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
    <form action="#" method="POST">
        @csrf
        <div class="item">
            <label for="name">大会名:</label>
            <input type="text" name="name" id="name" required>
        </div><br>

        <div class="item">
            <label for="school_year">学年:</label>
            <select name="school_year" id="school_year">
                <option value="">学年を選択してください</option>
                <option value="one">１年生</option>
                <option value="two">２年生</option>
                <option value="three">３年生</option>
                <option value="four">４年生</option>
                <option value="five">５年生</option>
                <option value="six">６年生</option>
            </select>
        </div><br>

        <div class="item">
            <label for="plase">会場:</label>
            <input type="text" name="plase" id="plase" required>
        </div><br>

        <div class="item">
            <label for="date">日程:</label>
            <input type="date" name="date" id="date" required>
        </div><br>

        <div class="item">
            <label for="opponent">対戦相手:</label>
            <input type="text" name="opponent" id="opponent" required>
        </div><br>

        <div class="item">
            <label class="my-radio">試合形式:</label>
            <label for="tournament"><input type="radio" name="game" id="tournament" value="tournament">トーナメント</label>
            <label for="interleague_match"><input type="radio" name="game" id="interleague_match" value="interleague_match">交流戦</label>
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
            <label for="number_of_matches">試合回数:</label>
            <input type="number" name="number_of_matches" id="number_of_matches" required><label for="number_of_matches">回</label>
        </div><br>

        <div class="item">
            <label for="end_time">終了時間:</label>
            <input type="time" name="end_time" id="end_time" required>
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
            <label for="interval">試合間隔:</label>
            <input type="number" name="interval" id="interval" required><label for="interval">分</label>
        </div><br>

        <div class="item">
            <label for="qualifying_interval">予選試合間隔:</label>
            <input type="number" name="qualifying_interval" id="qualifying_interval" required><label for="interval">分</label>
        </div><br>

        <div class="item">
            <label for="semi_final_interval">準決勝準備時間:</label>
            <input type="number" name="semi_final_interval" id="semi_final_interval" required><label for="semi_final_interval">分</label>
        </div><br>

        <div class="item">
            <label for="final_interval">決勝準備時間:</label>
            <input type="number" name="final_interval" id="final_interval" required><label for="final_interval">分</label>
        </div><br>

        <div class="item">
            <label for="half_time" class="my-radio">ハーフタイム:</label>
            <label for="true"><input type="radio" name="half_time" id="true" value="true" checked="on">あり</label>
            <label for="false"><input type="radio" name="half_time" id="false" value="false">なし<br></label>
            <input type="number" name="half_time" id="half_time" required><label for="half_time">分</label>
            <button type="submit">次へ</button>
        </div><br>

    </form>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>
</body>
</html>