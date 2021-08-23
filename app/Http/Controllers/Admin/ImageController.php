<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function media()
    {
        return view('admin.media.index');
    }

    public function index(Request $request)
    {
        if($request->has('offset') && $request->has('limit')) {
            
            $images = Image::latest('id')->skip($request->get('offset'))->take($request->get('limit'))->get();
        } elseif($request->has('count')) {
            return Image::count();
        } else {
            $images = Image::latest('id')->get(); 
        }

        $images = $this->formatData($images);
        return response()->json($images);   
    }

    public function listImages()
    {
        $images = Image::latest()->get();
        $images = $this->formatData($images);

        return response()->json($images);
    }

    private function formatData($images) {
        return  $images->transform(function($image){
            $meta = getimagesize($image->path);
            $data = [
                'id' => $image->id,
                'path' => $image->path,
                'filename' => $image->filename,
                'size' => $image->size,
                'created_at' => $image->created_at->format('d F, Y'),
            ];

            if($meta) {
                $data['width'] = $meta[0];
                $data['height'] = $meta[1];
            }

            return $data;
        });
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
        if(request()->ajax()){
            $data = request()->get('data');

            if(is_array($data) && count($data)) {
                foreach($data as $id) {
                    $image = Image::find($id);

                    if($image->isFileExists()){
                        Storage::delete('media/' . pathinfo($image->path, PATHINFO_BASENAME));
                    }
            
                    $image->delete();
                }

            } elseif($data) {
                $image = Image::find($data);

                if($image) {
                    if($image->isFileExists()){
                        Storage::delete('media/' . pathinfo($image->path, PATHINFO_BASENAME));
                    }
            
                    $image->delete();
                } else {
                    return response()->json(['message' => 'Unable to find the image', 404]);
                }
            }


            return response()->json(['message' => 'The image has been deleted'], 204);
        }

        if($image->isFileExists()){
            Storage::delete('media/' . pathinfo($image->path, PATHINFO_BASENAME));
        }

        $image->delete();

        return response()->json(['message' => 'The image has been deleted'], 204);
    }
}
