<?php

namespace App\Http\Controllers;

use App\Todo;
use http\Env\Response;
use Illuminate\Http\Request;
use Mockery\Exception;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Todo::all(), 200);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $todo = Todo::create($request->all());

            return response()->json($todo, 201);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        try {
            return response()->json($todo, 200);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        try {
            $todo->update($request->all());

            return response()->json($todo, 200);

        }catch (Exception $exception){

            return response()->json(['error'=>$exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        try {$todo->delete();

            return response()->json(['message' => 'Deleted'], 205);

        } catch (Exception $exception) {

            return response()->json(['error' => $exception], 500);
        }
    }

    public function search(Request $request){

        $result = Todo::where('todo', 'LIKE', '%' . $request->search . '%')->orwhere('id', 'LIKE', '%' . $request->search . '%')->get();

        if(count($result)){
            return response()->json($result);
        }
        else{
            return response()->json(['Result'=> 'Todo not Found'], 404);
        }
    }

       /* try {
            return response()->json(Todo::orderBy("updated_at", "desc")->where('todo', 'LIKE', '%' . $request->search . '%')->get(), 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }*/
}
