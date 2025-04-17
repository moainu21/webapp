<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Tournament;
use App\Models\Place;
use App\Models\Opponent;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Resources\Views\Create_form;

class CreateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $step = (int)$request->input('step', 1);
        $isBack = $request->input('back') === 'true';

        // POSTの時のみ保存処理
        if ($request->isMethod('post') && !$isBack) {
            $input = $request->except('_token', 'step');
            $formData = session('form_data', []);

            // ステップごとのデータをセッションにまとめて格納
            $formData["step{$step}"] = $input;

            // 特別処理：step1のopponentsに「アスリーナ」追加
            if ($step === 1 && isset($input['opponents'])) {
                $opponents = array_filter($input['opponents']); // 空要素除去
                array_push($opponents, 'アスリーナ');
                $formData['step1']['opponents'] = $opponents;
            }

            session(['form_data' => $formData]);

            // ステップを進める
            $step++;
        }

        // step 4 なら確認画面
        if ($step > 3) {
            $formData = session('form_data', []);
            return view('create.create_check', compact('formData'));
        }

        return view('create.create_form', [
            'step' => $step,
            'formData' => session('form_data', []),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $step = $request->session()->get('step', 1);

        return view('create.create_form', compact('step'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = session('form_data');

        if (!$formData || !isset($formData['step1'], $formData['step2'], $formData['step3'])) {
            return redirect()->route('create_form')->with('error', '入力内容が不足しています。');
        }
    
        // トーナメント名 & 会場名の取得または作成
        $tournament = Tournament::firstOrCreate(['name' => $formData['step1']['name']]);
        $place = Place::firstOrCreate(['name' => $formData['step1']['place']]);
    
        // schedulesテーブルに保存
        $schedule = new Schedule();
        $schedule->tournament_id = $tournament->id;
        $schedule->place_id = $place->id;
        $schedule->game = $formData['step3']['game'];
        $schedule->date = $formData['step1']['date'];
        $schedule->start_time = $formData['step1']['start_time'];
        $schedule->end_time = $formData['step3']['end_time'] ?? null;
        $schedule->time = $formData['step2']['time'];
        $schedule->interval = $formData['step3']['interval'] ?? 5;
        $schedule->preliminary_group = $formData['step3']['qualifying_group'] ?? null;
        $schedule->qualifying_interval = $formData['step3']['qualifying_interval'] ?? null;
        $schedule->semi_final_interval = $formData['step3']['semi_final_interval'] ?? null;
        $schedule->final_interval = $formData['step3']['final_interval'] ?? null;
        $schedule->number_of_matches = $formData['step3']['number_of_matches'] ?? null;
        $schedule->people = $formData['step2']['people'];
        $schedule->half_time_check = $formData['step3']['half_time_check'] === 'true';
        $schedule->half_time = $formData['step3']['half_time'] ?? null;
        $schedule->save();
    
        // 多対多：対戦相手・学年を中間テーブルに登録
        foreach ($formData['step1']['opponents'] as $opponentName) {
            $opponent = Opponent::firstOrCreate(['name' => $opponentName]);
            $schedule->opponents()->attach($opponent->id);
        }
    
        foreach ($formData['step1']['school_years'] as $schoolYearName) {
            $schoolYear = SchoolYear::firstOrCreate(['name' => $schoolYearName]);
            $schedule->schoolYears()->attach($schoolYear->id);
        }
    
        // セッションクリア
        session()->forget('form_data');
    
        return redirect()->route('index')->with('success', 'スケジュールを作成しました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $create)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $create)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $create)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'スケジュールを削除しました。');
    }
}
