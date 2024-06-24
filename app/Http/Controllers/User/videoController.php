<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Image as ImageFacade;
use App\Lib\FTPFileManager;
use App\Constants\Status;
use App\Lib\DownloadFile;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;

class videoController extends Controller
{
    public function all()
    {

        $pageTitle = "All videos";
        $videos    = $this->videoData();

        return view($this->activeTemplate . 'user.video.list', compact('pageTitle', 'videos'));
    }
    public function pending()
    {
        $pageTitle = "Pending videos";
        $videos    = $this->videoData('pending');
        return view($this->activeTemplate . 'user.video.list', compact('pageTitle', 'videos'));
    }

    public function rejected()
    {
        $pageTitle = "Rejected videos";
        $videos    = $this->videoData('rejected');
        return view($this->activeTemplate . 'user.video.list', compact('pageTitle', 'videos'));
    }

    public function approved()
    {
        $pageTitle = "Approved videos";
        $videos    = $this->videoData('approved');
        return view($this->activeTemplate . 'user.video.list', compact('pageTitle', 'videos'));
    }

    public function add()
    {
        $pageTitle  = "Upload video";
        $categories = Category::active()->orderBy('name')->get();
        $colors     = Color::all();
        return view($this->activeTemplate . 'user.video.upload', compact('pageTitle', 'categories', 'colors'));
    }

    public function store(Request $request)
    {
        $user           = auth()->user();
        $general        = gs();
        $dailyUpload    = Video::where('user_id', $user->id)->whereDate('created_at', Carbon::now())->count();

        if ($general->upload_limit < $dailyUpload) {
            $notify[] = ['error', 'لقد انتهى حد التحميل اليومي'];
            return back()->withNotify($notify);
        }

        $this->validation($request);

        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'الفئة غير موجودة'];
            return back()->withNotify($notify);
        }

        $tagCount =  count($request->tags);

        if ($tagCount > 10) {
            $notify[] = ['error', 'لا يمكنك استخدام أكثر من 10 علامات'];
            return back()->withNotify($notify);
        }

        $video    = new video();
        $response = $this->processvideoeData($video, $request);

        if (array_key_exists('error', $response)) {
            $notify[] = ['error', $response['error']];
        } else {
            $notify[] = ['success', $response['success']];
        }
        return back()->withNotify($notify);
    }
    public function edit($id)
    {
        $video      = video::where('user_id', auth()->id())->findOrFail($id);
        $pageTitle  = 'Update video - ' . $video->title;
        $categories = Category::active()->orderBy('name')->get();
        return view($this->activeTemplate . 'user.video.upload', compact('pageTitle', 'categories',  'video'));
    }
    public function updateImage(Request $request, $id)
    {
        $user           = auth()->user();
        $general        = gs();

        $video = video::where('user_id', $user->id)->findOrFail($id);
        $this->validation($request, true);

        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'فالفئة غير موجودة'];
            return back()->withNotify($notify);
        }

        if ($general->storage_type == 1) {
            if ($request->hasFile('video')) {
                $path = $request->file('video')->store('videos', ['disk' =>'my_files']);
                $video->thumb = $path ;
            }

            if ($request->hasFile('file')) {
                $file = getFilePath('stockFile') . '/' . $video->file_name;
                removeFile($file);
            }
        }

        $response = $this->processvideoeData($video, $request, true);

        if (array_key_exists('error', $response)) {
            $notify[] = ['error', $response['error']];
        } else {
            $notify[] = ['success', $response['success']];
        }
        return back()->withNotify($notify);
    }
    public function updateLike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = auth()->user();
        $video = video::where('id', $request->image)->first();

        if (!$video) {
            return response()->json(['error' => 'video not found']);
        }

        $like = Like::where('image_id', $video->id)->where('user_id', $user->id)->first();

        if (!$like) {
            $like           = new Like();
            $like->user_id  = $user->id;
            $like->image_id = $video->id;
            $like->save();
            $video->total_like += 1;
        } else {
            $like->delete();
            $video->total_like -= 1;
        }

        $video->save();
        $userTotalLike = video::where('user_id', $video->user_id)->sum('total_like');

        return response()->json(['status' => 'success', 'total_like' => $video->total_like, 'user_total_like' => $userTotalLike]);
    }
    public function download($id)
    {
        $video = video::FindOrFail($id);
        $user = auth()->user()->load('downloads');
        if ($video->user_id == $user->id || $user->downloads->where('image_id', $image->id)->first()) {
            return DownloadFile::download($video);
        } else {
            $notify[] = ['error', 'طلب غير صالح'];
            return to_route('user.video.all')->withNotify($notify);
        }
    }
    public function changeActiveStatus($id)
    {
        $video = video::where('user_id', auth()->id())->findOrFail($id);
        $video->is_active = $video->is_active ? Status::DISABLE : Status::ENABLE;
        $video->save();

        $notification = 'تم إلغاء تنشيط الفيديو بنجاح';
        if ($video->is_active) {
            $notification = 'تم تنشيط الفيديو بنجاح';
        }
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    protected function videoData($scope = null)
    {
        $user   = auth()->user();
        $videos = Video::where('user_id', $user->id);

        if ($scope) {
            $videos = $videos->$scope();
        }

        return $videos->with('category')->orderBy('id', 'desc')->paginate(getPaginate(21));
    }

    protected function processvideoeData($video, $request, $isUpdate = false)
    {

        $filename  = uniqid() . time() . '.' . $request->video->getClientOriginalExtension();
        $path = $request->file('video')->store('videos', ['disk' =>'my_files']);
// dd(Str::random(10).$fileName);
        FFMpeg::fromDisk('my_files')
        ->open($path)
        ->addWatermark(function(WatermarkFactory $watermark) {
            $watermark    ->open('assets/images/watermark.png')
                ->right(20)
                ->bottom(25);
        })        ->export()
        ->toDisk('converted_videos')
        ->inFormat(new \FFMpeg\Format\Video\X264)
        ->addFilter(function (VideoFilters $filters) {
            $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
        })
        ->save($filename) ;
        $user    = auth()->user();
        $general = gs();

        $directory     = date("Y") . "/" . date("m") . "/" . date("d");

        $imageLocation = getFilePath('stockImage') . '/' . $directory;
        $fileLocation  = getFilePath('stockFile') . '/' . $directory;

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', ['disk' =>'my_files']);
            $video->thumb =  $filename ;
            // dd( $path);

            // try {
            //     $filename  = uniqid() . time() . '.' . $request->video->getClientOriginalExtension();
            //     // $photo     = ImageFacade::make($request->video);
            //     // $watermark = ImageFacade::make('assets/images/watermark.png')->opacity(45)->rotate(45)->greyscale()->fit($photo->width(), $photo->height());
            //     // $photo->insert($watermark, 'center');

            //     // $thumb = ImageFacade::make($request->photo);
            //     // $thumb->resize(600, null, function ($constraint) {
            //     //     $constraint->aspectRatio();
            //     //     $constraint->upsize();
            //     // });

            //     // $image->image_width = $thumb->width();
            //     // $image->image_height = $thumb->height();

            //     if ($general->storage_type == 1) {
            //         //configure image and thumb
            //         if (!file_exists($imageLocation)) {
            //             mkdir($imageLocation, 0755, true);
            //         }
            //         $video->save($imageLocation . '/' . $filename);
            //         // $thumb->save($imageLocation . '/thumb_' . $filename);
            //     } else {
            //         $ftpFileManager       = new FTPFileManager();
            //         $ftpFileManager->path = 'videos/' . $directory;
            //         $ftpFileManager->old  = @$video->image_name;
            //         $ftpFileManager->uploadImage($video, $filename);
            //         $ftpFileManager->uploadImage($video, $filename, true);
            //     }

            //     $video->image_name = $directory . '/' . $filename;
            //     $video->thumb = $directory . '/thumb_' . $filename;
            // } catch (\Exception $exp) {
            //     return ['error' =>  $exp->getMessage()];
            // }
        }

        // if ($request->hasFile('file')) {
        //     if ($general->storage_type == 1) {
        //         try {
        //             $fileName    = fileUploader($request->file, $fileLocation);
        //             $video->file_name = $directory . '/' . $fileName;
        //         } catch (\Exception $exp) {
        //             return ['error' => $exp->getMessage()];
        //         }
        //     } else {
        //         try {
        //             $fileName    = ftpFileUploader($request->file, 'files/' . $directory, null, @$video->file_name);
        //             $video->file_name = $directory . '/' . $fileName;
        //         } catch (\Exception $exp) {
        //             return ['error' =>  $exp->getMessage()];
        //         }
        //     }
        // }

        $video->user_id     = $user->id;
        $video->category_id = $request->category;
        $video->title       = $request->title;
        $video->description = $request->description;

        if (!$isUpdate) {
            $video->upload_date        = now();
            $video->track_id    =  getTrx();
            $video->status      = $general->auto_approval ? 1 : 0;
        }

        $video->tags        = $request->tags;
        $video->extensions  = $request->extensions;
        $video->resolution  = $request->resolution;
        $video->is_free     = $request->is_free;
        $video->attribution = $request->is_free ? 1 : 0;
        $video->price = $request->is_free ? 0 : $request->price;
        $video->save();

        $notification = 'video uploaded successfully';
        if ($isUpdate) {
            $notification = 'video updated successfully';
        }

        return ['success' => $notification];
    }

    protected function validation($request, $isUpdate = false)
    {

        $fileExtensions = getFileExt('file_extensions');
        $colors         = Color::pluck('color_code')->implode(',');

        $photoValidation = 'required';
        $fileValidation  = 'required';

        if ($isUpdate) {
            $photoValidation = 'nullable';
            $fileValidation  = 'nullable';
        }

        $request->validate([
            'category'       => 'required|integer|gt:0',
            'video'          => [$photoValidation, new FileTypeValidate(['mp4'])],
            'file'           => [$fileValidation, new FileTypeValidate(['zip', '7z', 'rar', 'tar', 'wim'])],
            'title'          => 'required|max:40',
            'resolution'     => 'required|string|max:40',
            'description'    => 'required|string',
            'tags'           => 'required|array',
            'tags.*'         => 'required|string',
            'extensions'     => 'required|array',
            'extensions.*'   => 'required|string|in:' . implode(',', $fileExtensions),
            'is_free'        => 'required|in:0,1',
            'price'          => 'nullable|required_if:is_free,0|numeric|gte:0'
        ], [
            'price.required_if' => 'Price field is required if the image is premium'
        ]);
    }
}
