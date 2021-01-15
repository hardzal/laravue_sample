<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('created_at', 'DESC')->get();
        $responses = [
            'message' => 'List of all users',
            'data' => $user
        ];

        return response()->json($responses, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $user = User::create($request->all());
            $response = [
                'message' => 'User created',
                'data' => $user
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Failed created user. Error: '. $e->errorInfo[2]
            ]);
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
        $user = User::findOrFail($id);
        $response = [
            'message' => 'Detail of user info',
            'data' => $user
        ];

        return response()->json($response, Response::HTTP_OK);
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
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'  => ['required'],
            'email' => ['required', 'email']
        ]);

        if($validator->fails()) {
            $response = [
                'message' => 'User updated',
                'data' => $user
            ];
        }

        try {
            $user->update($request->all());
            $response = [
                'message' => 'User updated',
                'data' => $user
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Failed updated user '. $e->errorInfo[2]
            ]);
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
        $user = User::findOrFail($id);

        try {
            $user->delete();
            $response = [
                'message' => 'User deleted'
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch(QueryException $e) {
            return response()->json([
                'message' => 'Failed '. $e->errorInfo[2]
            ]);
        }
    }
}
