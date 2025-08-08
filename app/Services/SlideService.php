<?php
namespace App\Services;


use App\Repositories\SlideRepository;
use App\Traits\ProcessImageTrait;
use Illuminate\Http\Request;

class SlideService{
    use ProcessImageTrait;
    protected SlideRepository $slideRepository;
    protected string $folderSlideName='slides_image';
    public function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository=$slideRepository;
    }

    private function prepareSlideData(Request $request): array
    {
       return $request->only([
           'tagline',
           'title',
           'subtitle',
           'link',
       ]);
    }

    public function handelSlideStore($request): void
    {
       $data=$this->prepareSlideData($request);
        $data['status'] = $request->has('status') ? $request->status : 0;
        if ($request->file('image')){
            $data['image']=$this->processImage($request->file('image'),400,690,'slides_image',$this->folderSlideName);
        }
        $this->slideRepository->create($data);
    }

    public function handleSlideUpdate($request){
        $slide=$this->slideRepository->find($request->id);
        $data=$this->prepareSlideData($request);
        if ($request->file('image')){
            $data['image']=$this->replaceImage($slide->image,$request->file('image'),540,689,$this->folderSlideName);
        }
        $this->slideRepository->update($slide,$data);
    }

    public function handleSlideDelete($id): void
    {
            $slide = $this->slideRepository->find($id);
if ($slide->image)
        {
            $this->deleteImage($slide->image, $this->folderSlideName);
        }

                $this->slideRepository->delete($slide);

    }
}
