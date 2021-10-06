<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function getForm()
    {
        return view('image/main');
    }

    public function setWatermark(Request $request)
    {
        $input_image = $request->file('input_image')->store('public');
        $image = Image::make(Storage::get($input_image));

        $color = $this->defineColorImage($image);

        $watermarkUrl = $this->getCurrentWatermark($color);

        $watermark = Image::make(Storage::get($watermarkUrl))->trim('bottom-right', ['top', 'bottom', 'left', 'right'], 25);
        $watermark->resize(100, 50);
        $watermark->rotate(20);
        $image->insert($watermark, 'center', 20, 20);
        $image->save(Storage::path($input_image));
        $imageUrl = Storage::url($input_image);

        return view('image/watermark', ['output_image' => $imageUrl]);
    }

    private function getCurrentWatermark($color)
    {
        $markUrl = '';
        switch ($color){
            case "red" :
                $markUrl = 'images/black.jpeg';
                break;
            case "blue" :
                $markUrl = 'images/yellow.jpeg';
                break;
            default :
                $markUrl = 'images/red.jpeg';
        }
        return $markUrl;
    }

    private function defineColorImage(object $image)
    {
        $color = '';
        $countRed = 0;
        $countBlue = 0;

        $width = $image->width();
        $height = $image->height();
        $allIteration = 0;
        for($i = 0; $i < $width; $i++){
            for($b = 0; $b < $height; $b++) {
                $pixelColor = $image->pickColor($b, $i, 'array');
                $allIteration += 1;
                if ($pixelColor[0] > $pixelColor[1] && $pixelColor[0] > $pixelColor[2]) {
                    $countRed += 1;
                } elseif ($pixelColor[2] > $pixelColor[0] && $pixelColor[2] > $pixelColor[1]) {
                    $countBlue += 1;
                }
            }
        }

        $halfAreaImage = intval(($width * $height) / 4);

        if($halfAreaImage < $countRed){
            $color = 'red';
        } elseif ($halfAreaImage < $countBlue){
            $color = 'blue';
        } else {
            $color = 'green';
        }
        return $color;
    }
}
