document.addEventListener("DOMContentLoaded", function () {
    const halfTimeTrue = document.getElementById("true");
    const halfTimeFalse = document.getElementById("false");
    const halfTimeInput = document.getElementById("half_time_input");

    function toggleHalfTimeInput() {
        if (halfTimeFalse.checked) {
            halfTimeInput.style.display = "none"; // なしを選択したら非表示
        } else {
            halfTimeInput.style.display = "flex"; // ありを選択したら表示
        }
    }

    // 初期状態を設定（リロード時）
    toggleHalfTimeInput();

    // ラジオボタンの変更を監視
    halfTimeTrue.addEventListener("change", toggleHalfTimeInput);
    halfTimeFalse.addEventListener("change", toggleHalfTimeInput);
});

document.addEventListener("DOMContentLoaded", function () {
    const interleagueMatch = document.getElementById("interleague_match");
    const tournamentMatch = document.getElementById("tournament");
    const practiceMatch = document.getElementById("practice_match");
    const officialMatch = document.getElementById("official_match");

    function toggleMatch() {
        if (tournamentMatch.checked) {
            officialMatch.style.display = "block";
            practiceMatch.style.display = "none"; // なしを選択したら非表示
        } else {
            officialMatch.style.display = "none";
            practiceMatch.style.display = "block"; // ありを選択したら表示
        }
    }

    // 初期状態を設定（リロード時）
    toggleMatch();

    // ラジオボタンの変更を監視
    interleagueMatch.addEventListener("change", toggleMatch);
    tournamentMatch.addEventListener("change", toggleMatch);
});

document.addEventListener("DOMContentLoaded", function () {
    const countDiv = document.getElementById("count");
    const finishDiv = document.getElementById("finish");
    const toggleButtons = document.querySelectorAll(".toggle_btn");

    // 最初に `finish` を非表示にする
    finishDiv.style.display = "none";

    function toggleDisplay() {
        if (countDiv.style.display === "none") {
            countDiv.style.display = "flex";
            finishDiv.style.display = "none";
        } else {
            countDiv.style.display = "none";
            finishDiv.style.display = "flex";
        }
    }

    // すべての切り替えボタンにイベントリスナーを追加
    toggleButtons.forEach(button => {
        button.addEventListener("click", toggleDisplay);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const opponentContainer = document.getElementById("opponent-container");
    const addOpponentBtn = document.getElementById("add-opponent");
    const removeOpponentBtn = document.getElementById("remove-opponent");

    // 対戦相手の追加
    addOpponentBtn.addEventListener("click", function () {
        const newOpponent = document.createElement("div");
        newOpponent.classList.add("opponent-item");
        newOpponent.innerHTML = `
            <input type="text" name="opponents[]" class="opponents">
        `;
        opponentContainer.appendChild(newOpponent);
    });

    // 最後の対戦相手を削除
    removeOpponentBtn.addEventListener("click", function () {
        if (opponentContainer.children.length > 1) {
            opponentContainer.lastElementChild.remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', () => {
        const opponentInputs = document.querySelectorAll('input[name="opponents[]"]');
        opponentInputs.forEach(input => {
            if (input.value.trim() === '') {
                input.parentElement.remove(); // 空の入力フィールドを削除
            }
        });
    });
});