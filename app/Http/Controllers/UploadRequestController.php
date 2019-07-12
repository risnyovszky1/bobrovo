<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadRequestController extends Controller
{
    //

    public function postUploadQuestionImage(Request $request)
    {

        if ($request->input('froala')) {
            $file = $request->file('image_param');
            $path = '/' . $file->store('img/questions', 'public_uploads');

            return stripslashes(response()->json(['link' => $path])->content());
        }

        return "";
    }
}
