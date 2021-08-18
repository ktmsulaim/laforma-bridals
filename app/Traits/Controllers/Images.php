<?php

namespace App\Traits\Controllers;
use Illuminate\Http\Request;

trait Images {
    public function saveImages(Request $request, $model, $baseImage = 'base_image', $additionalImages = 'additional_images')
    {
        if($model->images()->exists()) {
            $images = [];

            if($request->has($baseImage)) {
                $images[] = ['image_id' => $request->get($baseImage), 'type' => 'base_image'];
            }

            if($request->has($additionalImages)) {
                $additional_images = $request->get($additionalImages);
                if(is_array($additional_images) && count($additional_images)) {
                    foreach($additional_images as $ai) {
                        $images[] = ['image_id' => $ai, 'type' => 'additional_images'];
                    }
                }
            }

            if($images && count($images)) {
                $model->images()->sync($images);
            }
    
        } else {
            if($request->has($baseImage)) {
                $model->images()->attach($request->get($baseImage), [
                    'type' => 'base_image'
                ]);
            }
    
            if($request->has($additionalImages)) {
                $additional_images = $request->get($additionalImages);
    
                if(is_array($additional_images) && count($additional_images)) {
                    foreach($additional_images as $aimage) {
                        $model->images()->attach($aimage, [
                            'type' => 'additional_images'
                        ]);
                    }
                }
            }

        }
    }
}