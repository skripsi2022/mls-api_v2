<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $total = 10;

        $finalgrade = floatval($total);

        $grade = DB::connection('moodle')->table('mdl_quiz_grades')->insert([
            'quiz' => $request->quiz_id,
            'userid' => $request->user_id,
            'grade' => $finalgrade,
            'timemodified' => Carbon::now()->timestamp
        ]);

        if ($grade) {
            return response()->json([
                'success' => true,
                'message' => 'Grading Success',
                'data' => $finalgrade
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Grading Failed',
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Adding Grade by Answers from Moodle
    public function grading(Request $request){

        // Getting Answers "Correct" from db
        $correct_answers = Answer::where([
            ['user_id', '=', $request->user_id],
            ['quiz_id', '=', $request->quiz_id],
            ['result', '=', 'correct'],
        ])->count();

        // Counting All Answers by Quiz from Moodle
        $answer = Answer::where([
            ['user_id', '=', $request->user_id],
            ['quiz_id', '=', $request->quiz_id]
        ])->count();

        // total grade 
        $total = $correct_answers / $answer * 10;
        // Converting to Double
        $finalgrade = floatval($total);

        $grade = DB::connection('moodle')->table('mld_quiz_grades')->insert([
            'quiz' => $request->quiz_id,
            'userid' => $request->user_id,
            'grade' => $finalgrade,
            'timemodified' => Carbon::now()->timestamp
        ]);

        if($grade){

            // Update state in attempt to finish
            
            // $attempt = DB::connection('moodle')->table('mdl_quiz_attempts')
            // ->where([
            //     'id' => $request->attemptid
            // ])
            // ->update([
            //     'state' => "finish",
            //     'timefinish' => Carbon::now()->timestamp,
            //     'sumgrades' => $finalgrade // if needed
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Grading Success',
                'data' => $finalgrade
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Grading Failed',
            ], 404);
        }

       


    }
}
