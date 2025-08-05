<?php
namespace App\Repositories;

use App\Models\Slide;

class SlideRepository{
    public function getAllSlidesPaginates($perPage=12){
        return Slide::orderBy('id','DESC')->paginate($perPage);
    }
    public function create($data){
        return Slide::create($data);
    }
    public function update(Slide $slide,$data): bool
    {
        return $slide->update($data);
    }

    public function find($id){
        return Slide::find($id);
    }
    public function delete(Slide $slide): void
    {
        $slide->delete();
    }







}
