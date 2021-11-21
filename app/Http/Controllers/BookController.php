<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class BookController extends BaseController
{
    public function index()
    {
        $data = Book::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        //find post by ID
        $data = Book::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Book',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $data = Book::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //success save to database
        if ($data) {

            return response()->json([
                'success' => true,
                'message' => 'Book Created',
                'data'    => $data
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'book Failed to Save',
        ], 409);
    }

    public function update(Request $request, Book $book)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find book by ID
        $data = Book::findOrFail($book->id);

        if ($data) {

            //update book
            $data->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Book Updated',
                'data'    => $data
            ], 200);
        }

        //data book not found
        return response()->json([
            'success' => false,
            'message' => 'Book Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        //find book by ID
        $data = Book::findOrfail($id);

        if ($data) {

            //delete book
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Book Deleted',
            ], 200);
        }

        //data book not found
        return response()->json([
            'success' => false,
            'message' => 'Book Not Found',
        ], 404);
    }
}
