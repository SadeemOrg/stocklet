<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Lib\DownloadFile;
use App\Models\Category;
use App\Models\Color;
use App\Constants\Status;
use App\Models\Download;
use App\Models\Reason;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use FFMpeg\Filters\Video\VideoFilters;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Image as ImageFacade;
use Spatie\Image\Image;
class ManageVideoController extends Controller
{
    public function all()
    {


        $pageTitle = "All videos";
        $videos    = $this->videoData();

        return view('admin.videos.list', compact('pageTitle', 'videos'));
    }
    public function list()
    {

        $pageTitle = "All videos";
        $videos    = $this->videoData();

        return view('admin.videos.admin_list', compact('pageTitle', 'videos'));
    }
    public function add()
    {
        $pageTitle  = "Upload video";
        $categories = Category::active()->orderBy('name')->get();
        $colors     = Color::all();
        return view('admin.videos.upload', compact('pageTitle', 'categories', 'colors'));
    }
    public function store(Request $request)
    {

        $user           = auth()->user();
        $general        = gs();
        $dailyUpload    = Video::whereDate('created_at', Carbon::now())->count();

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
        return redirect()->route('admin.videos.list')->withNotify($notify);
    }
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $pageTitle  = 'Update video - ' . $video->title;
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.videos.upload', compact('pageTitle', 'categories',  'video'));
    }
    public function updateVideo(Request $request, $id)
    {
        $user           = auth()->user();
        $general        = gs();

        $video = video::findOrFail($id);
        $this->validation($request, true);

        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'الفئة غير موجودة'];
            return back()->withNotify($notify);
        }

        if ($general->storage_type == 1) {
            if ($request->hasFile('video')) {
                $path = $request->file('video')->store('videos', ['disk' => 'my_files']);
                $video->thumb = $path;
            }

            if ($request->hasFile('file')) {
                $file = getFilePath('stockFile') . '/' . $video->file_name;
                removeFile($file);
            }
            if ($request->hasFile('cover_image')) {
                $file = getFilePath('stockFile') . '/' . $video->cover_image;
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



    protected function processvideoeData($video, $request, $isUpdate = false)
    {


        $user    = auth()->user();
        $general = gs();

        $directory     = date("Y") . "/" . date("m") . "/" . date("d");

        $imageLocation = getFilePath('stockImage') . '/' . $directory;
        $fileLocation  = getFilePath('stockFile') . '/' . $directory;

        if ($request->hasFile('video')) {
            $filename  = uniqid() . time() . '.' . $request->video->getClientOriginalExtension();
            $path = $request->file('video')->store('videos', ['disk' => 'my_files']);



            FFMpeg::fromDisk('my_files')
                ->open($path)
                ->addWatermark(function (WatermarkFactory $watermark) {
                    $watermark->fromDisk('my_fileseer')
                        ->open('watermark.png')
                        ->right(25)
                        ->top(25)
                        ->width(150)
                        ->height(150)
                        ->greyscale();

                })
                ->export()
                ->toDisk('converted_videos')
                ->inFormat(new \FFMpeg\Format\Video\X264)
                ->addFilter(function (VideoFilters $filters) {
                    $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
                })
                ->save($filename);
            $path = $request->file('video')->store('videos', ['disk' => 'my_files']);
            $video->thumb =  $filename;
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

        if ($request->hasFile('file')) {
            if ($general->storage_type == 1) {
                try {
                    $fileName    = fileUploader($request->file, $fileLocation);
                    $video->file_name = $directory . '/' . $fileName;
                } catch (\Exception $exp) {
                    return ['error' => $exp->getMessage()];
                }
            } else {
                try {
                    $fileName    = ftpFileUploader($request->file, 'files/' . $directory, null, @$video->file_name);
                    $video->file_name = $directory . '/' . $fileName;
                } catch (\Exception $exp) {
                    return ['error' =>  $exp->getMessage()];
                }
            }
        }
        if ($request->hasFile('cover_image')) {
            try {
                $filename  = uniqid() . time() . '.' . $request->cover_image->getClientOriginalExtension();
                $photo     = ImageFacade::make($request->cover_image);
                $watermark = ImageFacade::make('assets/images/watermark.png')->opacity(45)->rotate(45)->greyscale()->fit($photo->width(), $photo->height());
                $photo->insert($watermark, 'center');

                $thumb = ImageFacade::make($request->cover_image);
                $thumb->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });



                if ($general->storage_type == 1) {
                    //configure image and thumb
                    if (!file_exists($imageLocation)) {
                        mkdir($imageLocation, 0755, true);
                    }
                    $photo->save($imageLocation . '/' . $filename);
                    $thumb->save($imageLocation . '/thumb_' . $filename);
                } else {
                    $ftpFileManager       = new FTPFileManager();
                    $ftpFileManager->path = 'images/' . $directory;
                    $ftpFileManager->old  = @$image->image_name;
                    $ftpFileManager->uploadImage($photo, $filename);
                    $ftpFileManager->uploadImage($thumb, $filename, true);
                }

                $video->cover_image = $directory . '/' . $filename;
            } catch (\Exception $exp) {
                return ['error' =>  $exp->getMessage()];
            }
        }

        $video->user_id     = 0;
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

        $fileExtensions = getFileExt('video_extensions');
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
    public function changeActiveStatus($id)
    {
        $video = video::findOrFail($id);
        $video->is_active = $video->is_active ? Status::DISABLE : Status::ENABLE;
        $video->save();

        $notification = 'تم إلغاء تنشيط الفيديو بنجاح';
        if ($video->is_active) {
            $notification = 'تم تنشيط الفيديو بنجاح';
        }
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function download($id)
    {
        $video = video::FindOrFail($id);
        return DownloadFile::download($video);
        // $user = auth()->user()->load('downloads');
        // if ($video->user_id == $user->id || $user->downloads->where('image_id', $image->id)->first()) {
        //     return DownloadFile::download($video);
        // } else {
        //     $notify[] = ['error', 'Invalid Request'];
        //     return to_route('admin.videos.all')->withNotify($notify);
        // }
    }

    public function deletevideo($id)
    {

        video::findOrFail($id)->delete();
        $notification = 'حذف الفيديو بنجاح';
        $notify[] = ['success', $notification];
        return redirect()->route('admin.videos.list')->withNotify($notify);
    }
    public function pending()
    {
        $pageTitle = "Pending videos";
        $videos    = $this->videoData('pending');
        return view('admin.videos.list', compact('pageTitle', 'videos'));
    }

    public function rejected()
    {
        $pageTitle = "Rejected videos";
        $videos    = $this->videoData('rejected');
        return view('admin.videos.list', compact('pageTitle', 'videos'));
    }

    public function approved()
    {
        $pageTitle = "Approved videos";
        $videos    = $this->videoData('approved');
        return view('admin.videos.list', compact('pageTitle', 'videos'));
    }


    public function updateFeature($id)
    {
        $Video = Video::findOrFail($id);

        $notification = 'صورة غير مميزة بنجاح';
        $Video->is_featured = $Video->is_featured ? Status::DISABLE : Status::ENABLE;
        $Video->save();

        if ($Video->is_featured) {
            $notification = 'ظهرت الصورة بنجاح';
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $Video      = Video::with('category', 'user')->findOrFail($id);
        $pageTitle  = 'Image Details - ' . $Video->title;
        $categories = Category::active()->orderBy('name', 'asc')->get();
        $colors      = Color::orderBy('name', 'desc')->get();
        $extensions = getFileExt('video_extensions');
        $reasons = Reason::all();
        return view('admin.Videos.detail', compact('pageTitle', 'Video', 'categories', 'colors', 'extensions', 'reasons'));
    }

    public function downloadLog($id)
    {
        $Video     = Video::findOrFail($id);
        $logs      = Download::where('image_id', $Video->id)->with('user', 'contributor', 'image')->paginate(getPaginate());
        $pageTitle = 'Download logs - ' . $Video->title;
        return view('admin.Videos.download_log', compact('pageTitle', 'logs'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->is_free) {
            $priceValidation = 'required|numeric|gt:0';
        } else {
            $priceValidation = 'nullable';
        }

        $extensions = getFileExt('video_extensions');
        $colors = Color::select('color_code')->pluck('color_code')->toArray() ?? [];

        $request->validate([
            'category'      => 'required|integer|gt:0',
            'title'         => 'required|string|max:40',
            'resolution'    => 'required|string|max:40',
            'tags'          => 'required|array',
            'tags.*'        => 'required|string',
            'extensions'    => 'required|array',
            'extensions.*'  => 'required|in:' . implode(',', $extensions),
            'colors'        => 'required|array',
            'colors.*'      => 'required|in:' . implode(',', $colors),
            'status'        => 'nullable|in:0,1,3',
            'is_free'       => 'nullable',
            'price'         => $priceValidation,
            'reason'        => 'required_if:status,3'
        ], [
            'extensions.*.in' => 'Extensions are invalid',
            'colors.*.in' => 'Colors are invalid'
        ]);

        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'الفئة غير موجودة'];
            return back()->withNotify($notify);
        }

        $Video = Video::with('category')->findOrFail($id);

        $Video->category_id   = $request->category;
        $Video->title         = $request->title;
        $Video->resolution    = $request->resolution;
        $Video->tags          = $request->tags;
        $Video->extensions    = $request->extensions;
        $Video->colors        = $request->colors;
        $Video->attribution   = $request->attribution ? Status::ENABLE : Status::DISABLE;
        $Video->is_free       = $request->is_free ? Status::ENABLE : Status::DISABLE;
        $Video->is_active     = $request->is_active ? Status::ENABLE : Status::DISABLE;
        $Video->price         = $request->price;
        $Video->status        = $request->status;
        $Video->admin_id      = auth('admin')->id();
        $Video->reviewer_id = 0;
        if ($Video->status == 3) {
            $Video->reason = $request->reason;
        }

        $Video->save();

        if ($Video->status == 3) {
            notify($Video->user, 'IMAGE_REJECT', [
                'title' => $Video->title,
                'category' => $Video->category->name,
                'reason' =>  $Video->reason
            ]);
        } elseif ($Video->status == 1) {
            notify($Video->user, 'IMAGE_APPROVED', [
                'title' => $Video->title,
                'category' => $Video->category->name
            ]);
        }

        $notify[] = ['success', 'تم تحديث الصورة بنجاح'];
        return back()->withNotify($notify);
    }

    public function downloadFile($id)
    {
        $image = Video::findOrFail($id);
        return DownloadFile::download($image);
    }

    protected function videoData($scope = null)
    {
        if ($scope) {
            $videos = Video::$scope();
        } else {
            $videos = Video::query();
        }
        return  $videos->searchAble(['title', 'category:name', 'user:username,firstname,lastname', 'collections:title', 'admin:username,name', 'reviewer:username,name'])->orderBy('id', 'desc')->with('category')->paginate(getPaginate());
    }
}
