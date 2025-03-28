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
        $game = $request->input('game');
        $number_of_matches = $request->input('number_of_matches');
        $end_time = $request->input('end_time');
        $half_time_check = $request->input('half_time_check');

        $request->session()->put('school_years', $request->input('school_years', []));
        $request->session()->put('name', $request->input('name'));
        $request->session()->put('plase', $request->input('plase'));

        $opponents = $request->input('opponent', []);

        // もし配列が空でない場合、「自分」を配列の先頭に追加
        if (!empty($opponents)) {
            array_unshift($opponents, '自分');  // 配列の先頭に「自分」を追加
        }
        // 配列の個数をカウント
        $opponentCount = count($opponents);

        $request->session()->put('opponents', $opponents);
        $request->session()->put('opponents_count', $opponentCount);
        
        $request->session()->put('date', $request->input('date'));
        $request->session()->put('start_time', $request->input('start_time'));
        $request->session()->put('time', $request->input('time'));
        $request->session()->put('court', $request->input('court'));
        $request->session()->put('people', $request->input('people'));
        $request->session()->put('game', $request->input('game'));

        if($game == "interleague_match"){

            if(filled($number_of_matches)){
                $request->session()->put('number_of_matches', $request->input('number_of_matches'));
            } else if(filled($end_time)){
                $request->session()->put('end_time', $request->input('end_time'));
            }

            $request->session()->put('interval', $request->input('interval'));

        } else if($game == "tournament"){
            $request->session()->put('qualifying_interval', $request->input('qualifying_interval'));
            $request->session()->put('end_semi_final_intervaltime', $request->input('semi_final_interval'));
            $request->session()->put('final_interval', $request->input('final_interval'));
        }

        $request->session()->put('half_time_check', $request->input('half_time_check'));

        if($half_time_check == "true"){
            $request->session()->put('half_time', $request->input('half_time'));
        }
        
        return view('create_check', compact('opponentCount', 'opponents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_form');
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
