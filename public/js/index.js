document.addEventListener("DOMContentLoaded", function () {
    const createBtn = document.getElementById("create");
    const showBtn = document.getElementById("show");
    const createContents = document.querySelector(".create-contents");
    const showContents = document.querySelector(".show-contents");

    // 初期状態でどちらも非表示
    createContents.classList.remove("active");
    showContents.classList.remove("active");

    // ボタンの状態をリセットする関数
    function resetButtons() {
        createBtn.classList.remove("active");
        showBtn.classList.remove("active");
    }

    resetButtons();

    // 「作成」ボタンが押されたとき
    createBtn.addEventListener("click", function () {
        createContents.classList.add("active");
        showContents.classList.remove("active");

        // ボタンのスタイル変更
        resetButtons();
        createBtn.classList.remove("inactive");
        showBtn.classList.add("inactive");
    });

    // 「閲覧」ボタンが押されたとき
    showBtn.addEventListener("click", function () {
        showContents.classList.add("active");
        createContents.classList.remove("active");

        // ボタンのスタイル変更
        resetButtons();
        showBtn.classList.remove("inactive");
        createBtn.classList.add("inactive");
        
    });
});
