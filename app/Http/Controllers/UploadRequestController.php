<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadRequestController extends Controller
{
    //

    public function postUploadQuestionImage(Request $request)
    {
        $file = $request->file('image');

        if (!$file) {
            return response()->json(['error' => 'ERROR'], 400);
        }

        $path = $file->store(public_path('img/uploads/') . $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension());

        return response()->json([
            'data' => [
                'url' => $path
            ]
        ]);
    }
}
