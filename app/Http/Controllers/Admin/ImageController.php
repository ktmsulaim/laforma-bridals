<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('offset') && $request->has('limit')) {
            
            $images = Image::latest('id')->skip($request->get('offset'))->take($request->get('limit'))->get();
        } elseif($request->has('count')) {
            return Image::count();
        } else {
            $images = Image::latest('id')->get(); 
        }

        return response()->json($images);
        
    }

    public function store(Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getClientMimeType();
            $disk = 'public';
            $size = $file->getSize();

            $path = $file->store('media');

            $image = Image::create([
                'filename' => $filename,
                'path' => $path,
                'disk' => $disk,
                'mime' => $mime,
                'size' => $size,
                'extension' => $extension
            ]);
            
        }
        return json_encode($image);
    }

    public function destroy(Image $image)
    {
        if($image->isFileExists()){
            Storage::delete('media/' . pathinfo($image->path, PATHINFO_BASENAME));
        }

        $image->delete();

        return response()->json(['message' => 'The image has been deleted'], 204);
    }
}
