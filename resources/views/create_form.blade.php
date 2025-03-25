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
        <label for="name">大会名:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="school_year">学年:</label>
        <input type="text" name="school_year" id="school_year" required><br>

        <button type="submit">送信</button>
    </form>
    <footer>
        <p>&copy; 2025 試合スケジュール管理システム</p>
    </footer>
</body>
</html>