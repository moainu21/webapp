<?php

namespace App\Http\Controllers;

use App\Models\Create;
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

        // POSTの時のみ保存処理
        if ($request->isMethod('post')) {
            $input = $request->except('_token', 'step');
            $formData = session('form_data', []);

            // ステップごとのデータをセッションにまとめて格納
            $formData["step{$step}"] = $input;

            // 特別処理：step1のopponentsに「アスリーナ」追加
            if ($step === 1 && isset($input['opponents'])) {
                $opponents = array_filter($input['opponents']); // 空要素除去
                array_push($opponents, 'アスリーナ');
                $formData['step1']['opponents'] = $opponents;
                $formData['step1']['opponents_count'] = count($opponents);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Create $create)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Create $create)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Create $create)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Create $create)
    {
        //
    }
}
