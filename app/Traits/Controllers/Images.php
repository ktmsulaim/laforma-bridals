<?php

namespace App\Traits\Controllers;
use Illuminate\Http\Request;

trait Images {
    public function saveImages(Request $request, $model)
    {
        if($model->images()->exists()) {
            $images = [];

            if($request->has('base_image')) {
                $images[$request->get('base_image')] = ['type' => 'base_image'];
            }

            if($request->has('additional_images')) {
                $additional_images = $request->get('additional_images');
                if(is_array($additional_images) && count($additional_images)) {
                    foreach($additional_images as $ai) {
                        $images[$ai] = ['type' => 'additional_images'];
                    }
                }
            }

            if($images && count($images)) {
                $model->images()->sync($images);
            }
    
        } else {
            if($request->has('base_image')) {
                $model->images()->attach($request->get('base_image'), [
                    'type' => 'base_image'
                ]);
            }
    
            if($request->has('additional_images')) {
                $additional_images = $request->get('additional_images');
    
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