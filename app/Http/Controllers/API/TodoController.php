<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Repositories\TodoRepository;

class TodoController extends BaseController
{
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }

    public function create(Request $request) {
        $response = $this->todoRepository->createByRequest($request);

        if(!$response['success']) {
            return $this->sendError('Validation error', $response['data']);
        }

        return $this->sendResponse($response['data'], $response['message']);
    }

    public function get_my_todos() {
        $response = $this->todoRepository->getTodosByAuth();
        return $this->sendResponse($response['data'], $response['message']);
    }

    public function toggle_status($id) {
        $response = $this->todoRepository->toggleStatus($id);
        return $this->sendResponse($response['data'], $response['message']);
    }

}
