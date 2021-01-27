<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageStorageAction
{
    public static function execute(?UploadedFile $image, Model $model): void
    {
        if (!$image) {
            return;
        }

        $name = self::saveImage($image);

        $model->update([
            'image' => $name
        ]);
    }

    /**
     * Save image file on Storage
     *
     * @param UploadedFile $image
     * @return string
     */
    private static function saveImage(UploadedFile $image): string
    {
        $name = $image->getClientOriginalName();
        $img = Image::make($image)->fit(480, 320)->encode('jpg', 75);
        Storage::disk('images')->put($name, $img);

        return $name;
    }
}
