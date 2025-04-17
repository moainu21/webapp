<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Models\Schedule;
use App\Models\Tournament;
use App\Models\Place;
use App\Models\Opponent;

class ShowController extends Controller
{

    public function showBySchoolYear(Request $request)
    {
        $yearValue = $request->input('school_year');

        $schoolYear = SchoolYear::find($yearValue);

        if (!$schoolYear) {
            return redirect()->route('index')->with('error', '指定された学年が見つかりませんでした。');
        }

        // 学年に関連するスケジュールを取得（トーナメント・会場も一緒に）
        $schedules = $schoolYear->schedules()->with(['tournament', 'place'])->orderBy('date')->get();

        return view('show', compact('schoolYear', 'schedules'));
    }

    public function show($id)
    {
        $schedule = Schedule::with(['tournament', 'place', 'opponents', 'schoolYears'])->findOrFail($id);

        return view('show_schedule', compact('schedule'));
    }
}
