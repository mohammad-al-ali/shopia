<?php
namespace App\Services;

use App\Repositories\SlideRepository;
use App\Traits\ProcessImageTrait;
use Illuminate\Http\Request;

/**
 * Class SlideService
 *
 * Handles all operations related to slide, including creating,
 * updating, deleting, and managing slide images.
 */
class SlideService
{
    use ProcessImageTrait;

    /**
     * Slide repository instance.
     *
     * @var SlideRepository
     */
    protected SlideRepository $slideRepository;

    /**
     * Folder path to store slide images.
     *
     * @var string
     */
    protected string $folderSlideName = 'slides_image';

    /**
     * SlideService constructor.
     *
     * @param SlideRepository $slideRepository
     */
    public function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    /**
     * Prepare slide data from the request.
     *
     * @param Request $request
     * @return array
     */
    private function prepareSlideData(Request $request): array
    {
        return $request->only([
            'tagline',
            'title',
            'subtitle',
            'link',
        ]);
    }

    /**
     * Handle storing a new slide.
     *
     * @param Request $request
     * @return void
     */
    public function handelSlideStore(Request $request): void
    {
        $data = $this->prepareSlideData($request);
        $data['status'] = $request->has('status') ? $request->status : 0;

        if ($request->file('image')) {
            $data['image'] = $this->processImage(
                $request->file('image'),
                400,
                690,
                'slides_image',
                $this->folderSlideName
            );
        }

        $this->slideRepository->create($data);
    }

    /**
     * Handle updating an existing slide.
     *
     * @param Request $request
     * @return void
     */
    public function handleSlideUpdate(Request $request): void
    {
        $slide = $this->slideRepository->find($request->id);
        $data = $this->prepareSlideData($request);

        if ($request->file('image')) {
            $data['image'] = $this->replaceImage(
                $slide->image,
                $request->file('image'),
                540,
                689,
                $this->folderSlideName
            );
        }

        $this->slideRepository->update($slide, $data);
    }

    /**
     * Handle deleting a slide and its image.
     *
     * @param int $id
     * @return void
     */
    public function handleSlideDelete(int $id): void
    {
        $slide = $this->slideRepository->find($id);

        if ($slide->image) {
            $this->deleteImage($slide->image, $this->folderSlideName);
        }

        $this->slideRepository->delete($slide);
    }
}
