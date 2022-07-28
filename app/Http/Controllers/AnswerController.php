<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a answers from moodle database
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answer = DB::connection('moodle')->table('mdl_question_answers')->get();

        if ($answer) {
            return response()->json([
                'success' => true,
                'message' => 'List Answer',
                'data'    => $answer
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Answer Not Found',
            ], 404);
        }
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
        // Validations Input !
        $validator = Validator::make($request->all(), [
            'answer_id' => 'required',
            'question_id' => 'required',
            'user_id' => 'required',
            'answer' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Checking Answer from Moodle
        $check = DB::connection('moodle')->table('mdl_question_answers')->
        where('id','=',$request->answer_id)->first();

        if($check->fraction == "1.0000000"){
            $answer = Answer::create([
                'quiz_id' => $request->quiz_id,
                'question_id' => $request->question_id,
                'user_id' => $request->user_id,
                'answer' => $request->answer,
                'result' => "correct",
            ]);
            return response()->json([
                'success' => true,
                'message' => 'correct Answer',
                'data'    => $answer
            ], 201);
        }else{
            $answer = Answer::create([
                'quiz_id' => $request->quiz_id,
                'question_id' => $request->question_id,
                'user_id' => $request->user_id,
                'answer' => $request->answer,
                'result' => "wrong",
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Wronng Answer',
                'data'    => $answer
            ], 201);
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
        // Validations Input !
        $validator = Validator::make($request->all(), [
            'answer_id' => 'required',
            'question_id' => 'required',
            'user_id' => 'required',
            'answer' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        // find answer id 
        $answer = Answer::findOrFail($id);

        // find Answer
        if($answer){

            // checking answer from moodle
            $check = DB::connection('moodle')->table('mdl_question_answers')
            ->where('id', '=', $request->answer_id)->first();
            
            // checking answer with value fraction 1 = correct , 0 = wrong
            if ($check->fraction == "1.0000000") {
                //updating answer data
                $answer->update([
                    'answer' => $request->answer,
                    'result' => "correct",
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'correct Answer',
                    'data'    => $answer
                ], 201);
            } else {
                $answer->update([
                    'answer' => $request->answer,
                    'result' => "wrong",
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Wronng Answer',
                    'data'    => $answer
                ], 201);
            }
            
        }else{
            // if answer not found
            return response()->json([
                'success' => false,
                'message' => 'Answer Not Found !',
            ], 404);
        }
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

    // Showing Answer by Question ID From Moodle
    public function answers(Request $request){

        $answer = DB::connection('moodle')->table('mdl_question_answers')
            ->where('question', $request->question_id )->get();

        if ($answer) {
            return response()->json([
                'success' => true,
                'message' => 'Answer Found !',
                'total answer' => $answer->count(),
                'answer'    => $answer
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Answer Not Found !',
            ], 404);
        }
    }

    // Checking Answer by id
    public function checking(Request $request){

        $check = Answer::where([
            ['user_id','=',$request->user_id],
            ['quiz_id','=',$request->quiz_id],
            ['question_id','=',$request->question_id],
        ])->first();

        if($check){
            return response()->json([
                'success' => true,
                'message' => 'You Have Answered !',
                'data' => $check
            ], 200);
        }else{
            return response()->json([
                'success' => true,
                'message' => "You Haven't Answered !",
                'data' => $check
            ], 200);
        }
    }


}
