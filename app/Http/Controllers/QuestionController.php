<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // protected $connections = 'mysqlSecond';
    // protected $table = 'mdl_question';
    
    public function index()
    {
        $question = DB::connection('moodle')->table('mdl_question')->get();

        if($question){
            return response()->json([
                'success' => true,
                'message' => 'Questions List',
                'data'    => $question
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Question Not Found',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questions = DB::connection('moodle')->table('mdl_question')->where('id', $id)->get();

        if ($questions) {
            return response()->json([
                'success' => true,
                'message' => 'Question List',
                'data'    => $questions
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Question Not Found',
            ], 404);
        }
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
    
    // Get Questions By LIKE % from Mooodle
    public function questions(Request $request){

        $questions = DB::connection('moodle')->table('mdl_question')->
        where('name', 'LIKE' , '%' . $request->name .'%')->get();

        if ($questions) {
            return response()->json([
                'success' => true,
                'message' => 'Question List',
                'data'    => $questions
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Question Not Found',
            ], 404);
        }
    }
}
