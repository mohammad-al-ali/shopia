<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Laravel\Facades\Image;
use function Pest\Laravel\delete;

trait ProcessImageTrait
{
    public function processImage($image,$width,$height,$folder_name,$count=null): ?string
    {
        if (!$image) return null;
        $image_name=time() . ($count !== null ? "-$count":'').'.'. $image->extension();
// 🔹 تحديد المسار داخل storage
        $destinationPath = storage_path('app/public/'.$folder_name);
if (!file_exists($destinationPath))
{
    mkdir($destinationPath,0755,true);
}
// 🔹 قراءة الصورة باستخدام Intervention Image
        $img = Image::read($image->path());// 🔹 حفظ الصورة في storage

        $img->resize($width,$height);
        $img->save($destinationPath.'/'.$image_name);
        return $image_name;
    }
    public function deleteImage( ? string $ImageName,$folderName){
        if ($ImageName && Storage::disk('public')->exists($folderName.'/' . $ImageName)) {
            Storage::disk('public')->delete($folderName.'/' . $ImageName);
        }else return null;

    }
    public function replaceImage($oldImageName,$newImageFile,$width,$height,$folder_name): string
    {
        $this->deleteImage($oldImageName,$folder_name);
        return $this->processImage($newImageFile,$width,$height,$folder_name);
    }


}
