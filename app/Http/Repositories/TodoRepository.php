<?php
namespace App\Http\Repositories;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
Class TodoRepository {

    public function createByRequest($request) {

        $result = [];
        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'end_date' => 'nullable|date',
            'parent_id' => 'nullable|exists:todos,id'
        ]);
        if($validation->fails()) {
            $result['success'] = false;
            $result['data'] = $validation->errors();
            return $result;
        }

        $todo = Todo::create([
            'title' => $request->title,
            'status' => 'pending',
            'user_id' => $request->user()->id
        ]);

        if($request->has('description')) {
            $todo->description = $request->description;
        }
        if($request->has('end_date')) {
            $todo->end_date = $request->end_date;
        }
        if($request->has('parent_id')) {
            $todo->todo_id = $request->parent_id;
        }
        $todo->save();
        $result['success'] = true;
        $result['message'] = 'the Todo was created successfully';
        $result['data'] = new TodoResource($todo);

        return $result;
    }

    public function getTodosByAuth() {
        $result = [];
        $authID = auth()->user()->id;
        $todos = Todo::where('user_id', $authID)->get();

        $result['success'] = true;
        $result['message'] = "Successfully retrieved your todos";
        $result['data'] = TodoResource::collection($todos);

        return $result;
    }

    public function toggleStatus($id) {
        $result = [];
        $todo = Todo::find($id);
        if($todo->status == "pending") {
            $todo->status = "completed";
            $this->makeSubTodosCompleted($todo);
        }else {
            $todo->status = "pending";
        }
        $todo->save();

        $result['success'] = true;
        $result['message'] = "Successfully updated the todo!";
        $result['data'] = new TodoResource($todo);

        return $result;
    }



    private function makeSubTodosCompleted($parent) {
        foreach($parent->nested as $todo) {
            $todo->status = "completed";
            $todo->save();
        }
    }

}
