<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use Inertia\Inertia;

class StaffController extends Controller
{
    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->userService->getUsers($request));
    }
    
    public function display() {
        return Inertia::render('Staff/Staff');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->storeUser($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->userService->showUser($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $this->userService->updateUser($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->userService->deleteUser($request);
    }

    public function restore(Request $request)
    {
        $this->userService->restoreUser($request);
    }

    public function forceDelete(Request $request) {
        $this->userService->forceDeleteUser($request);
    }

    public function count() {
        return response()->json($this->userService->getUserCount());
    }
}
