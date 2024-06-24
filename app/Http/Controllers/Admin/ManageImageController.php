<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Image;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lib\DownloadFile;
use App\Models\Color;
use App\Models\Reason;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Image as ImageFacade;
class ManageImageController extends Controller
{
    public function all()
    {
        $pageTitle = 'All Images';
        $images    = $this->imageData();
        return view('admin.images.list', compact('pageTitle', 'images'));
    }

    public function list()
    {
        $pageTitle = 'All Images';
        $images    = $this->imageData();
        return view('admin.images.admin_list', compact('pageTitle', 'images'));
    }

    public function add()
    {
        $pageTitle  = "Upload Image";
        $categories = Category::active()->orderBy('name')->get();
        $colors     = Color::all();
        return view('admin.images.upload', compact('pageTitle', 'categories', 'colors'));
    }

    public function store(Request $request)
    {
        $user           = auth()->user();
        $general        = gs();
        $dailyUpload    = Image::whereDate('created_at', Carbon::now())->count();

        if ($general->upload_limit < $dailyUpload) {
            $notify[] = ['error', 'لقد انتهى حد التحميل اليومي'];
            return back()->withNotify($notify);
        }

        $this->validation($request);


        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'لقد انتهى حد التحميل اليومي'];
            return back()->withNotify($notify);
        }

        $tagCount =  count($request->tags);

        if ($tagCount > 10) {
            $notify[] = ['error', 'لا يمكنك استخدام أكثر من 10 علامات'];
            return back()->withNotify($notify);
        }

        $image    = new Image();
        $response = $this->processImageData($image, $request);

        if (array_key_exists('error', $response)) {
            $notify[] = ['error', $response['error']];
        } else {
            $notify[] = ['success', $response['success']];
        }
        return redirect()->route('admin.images.list')->withNotify($notify);
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
            'photo'          => [$photoValidation, new FileTypeValidate(['jpg', 'png', 'jpeg'])],
            'file'           => [$fileValidation, new FileTypeValidate(['zip', '7z', 'rar', 'tar', 'wim'])],
            'title'          => 'required|max:40',
            'resolution'     => 'required|string|max:40',
            'description'    => 'required|string',
            'tags'           => 'required|array',
            'tags.*'         => 'required|string',
            'colors'         => 'required|array',
            'colors.*'       => 'required|in:' . $colors,
            'extensions'     => 'required|array',
            'extensions.*'   => 'required|string|in:' . implode(',', $fileExtensions),
            'price'          => 'nullable|required_if:is_free,0|numeric|gte:0'
        ], [
            'price.required_if' => 'Price field is required if the image is premium'
        ]);
    }
    protected function processImageData($image, $request, $isUpdate = false)
    {
        $user    = auth()->user();
        $general = gs();

        $directory     = date("Y") . "/" . date("m") . "/" . date("d");
        $imageLocation = getFilePath('stockImage') . '/' . $directory;
        $fileLocation  = getFilePath('stockFile') . '/' . $directory;

        if ($request->hasFile('photo')) {
            try {
                $filename  = uniqid() . time() . '.' . $request->photo->getClientOriginalExtension();
                $photo     = ImageFacade::make($request->photo);
                $watermark = ImageFacade::make('assets/images/watermark.png')->opacity(45)->rotate(45)->greyscale()->fit($photo->width(), $photo->height());
                $photo->insert($watermark, 'center');

                $thumb = ImageFacade::make($request->photo);
                $thumb->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $image->image_width = $thumb->width();
                $image->image_height = $thumb->height();

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

                $image->image_name = $directory . '/' . $filename;
                $image->thumb = $directory . '/thumb_' . $filename;
            } catch (\Exception $exp) {
                return ['error' =>  $exp->getMessage()];
            }
        }

        if ($request->hasFile('file')) {
            if ($general->storage_type == 1) {
                try {
                    $fileName    = fileUploader($request->file, $fileLocation);
                    $image->file_name = $directory . '/' . $fileName;
                } catch (\Exception $exp) {
                    return ['error' => $exp->getMessage()];
                }
            } else {
                try {
                    $fileName    = ftpFileUploader($request->file, 'files/' . $directory, null, @$image->file_name);
                    $image->file_name = $directory . '/' . $fileName;
                } catch (\Exception $exp) {
                    return ['error' =>  $exp->getMessage()];
                }
            }
        }

        $image->user_id     = 0;
        $image->category_id = $request->category;
        $image->title       = $request->title;
        $image->description = $request->description;

        if (!$isUpdate) {
            $image->upload_date        = now();
            $image->track_id    =  getTrx();
            $image->status      = $general->auto_approval ? 1 : 0;
        }

        $image->tags        = $request->tags;
        $image->extensions  = $request->extensions;
        $image->colors      = $request->colors;
        $image->resolution  = $request->resolution;
        $image->is_free     = $request->is_free? 1 : 0;
        $image->attribution = $request->is_free ? 1 : 0;
        $image->price = $request->is_free ? 0 : 0.000;
        $image->save();

        $notification = 'Image uploaded successfully';
        if ($isUpdate) {
            $notification = 'Image updated successfully';
        }

        return ['success' => $notification];
    }
    public function edit($id)
    {
        $image = Image::findOrFail($id);

        $pageTitle  = 'Update image - ' . $image->title;
        $categories = Category::active()->orderBy('name')->get();
        $colors     = Color::all();
        return view('admin.images.upload', compact('pageTitle', 'categories', 'colors', 'image'));
    }
    public function updateImage(Request $request, $id)
    {
        $user           = auth()->user();
        $general        = gs();

        $image = Image::findOrFail($id);
        $this->validation($request, true);

        $category = Category::active()->find($request->category);
        if (!$category) {
            $notify[] = ['error', 'الفئة غير موجودة'];
            return back()->withNotify($notify);
        }

        if ($general->storage_type == 1) {
            if ($request->hasFile('photo')) {
                $photo      = getFilePath('stockImage') . '/' . $image->image_name;
                $photoThumb = getFilePath('stockImage') . '/' . $image->thumb;
                removeFile($photo);
                removeFile($photoThumb);
            }

            if ($request->hasFile('file')) {
                $file = getFilePath('stockFile') . '/' . $image->file_name;
                removeFile($file);
            }
        }

        $response = $this->processImageData($image, $request, true);

        if (array_key_exists('error', $response)) {
            $notify[] = ['error', $response['error']];
        } else {
            $notify[] = ['success', $response['success']];
        }
        return back()->withNotify($notify);
    }
    public function download($id)
    {


        $image = Image::FindOrFail($id);
        return DownloadFile::download($image);
        // $user = auth()->user()->load('downloads');
        // if ($image->user_id == $user->id || $user->downloads->where('image_id', $image->id)->first()) {
        // } else {
        //     $notify[] = ['error', 'Invalid Request'];
        //     return to_route('user.image.all')->withNotify($notify);
        // }
    }
    public function changeActiveStatus($id)
    {
        $image = Image::findOrFail($id);
        $image->is_active = $image->is_active ? Status::DISABLE : Status::ENABLE;
        $image->save();

        $notification = 'تم إلغاء تنشيط الصورة بنجاح';
        if ($image->is_active) {
            $notification = 'تم تنشيط الصورة بنجاح';
        }
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
    public function deleteImage($id)
    {

         Image::findOrFail($id)->delete();
        $notification = 'حذف الصورة بنجاح';
        $notify[] = ['success', $notification];
        return redirect()->route('admin.images.list')->withNotify($notify);


    }

    public function pending()
    {
        $pageTitle = 'Pending Images';
        $images    = $this->imageData('pending');
        return view('admin.images.list', compact('pageTitle', 'images'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Images';
        $images    = $this->imageData('rejected');
        return view('admin.images.list', compact('pageTitle', 'images'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Images';
        $images    = $this->imageData('approved');
        return view('admin.images.list', compact('pageTitle', 'images'));
    }

    public function updateFeature($id)
    {
        $image = Image::findOrFail($id);

        $notification = 'صورة غير مميزة بنجاح';
        $image->is_featured = $image->is_featured ? Status::DISABLE : Status::ENABLE;
        $image->save();

        if ($image->is_featured) {
            $notification = 'ظهرت الصورة بنجاح';
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $image      = Image::with('category', 'user')->findOrFail($id);
        $pageTitle  = 'Image Details - ' . $image->title;
        $categories = Category::active()->orderBy('name', 'asc')->get();
        $colors      = Color::orderBy('name', 'desc')->get();
        $extensions = getFileExt('file_extensions');
        $reasons = Reason::all();
        return view('admin.images.detail', compact('pageTitle', 'image', 'categories', 'colors', 'extensions', 'reasons'));
    }

    public function downloadLog($id)
    {
        $image     = Image::findOrFail($id);
        $logs      = Download::where('image_id', $image->id)->with('user', 'contributor', 'image')->paginate(getPaginate());
        $pageTitle = 'Download logs - ' . $image->title;
        return view('admin.images.download_log', compact('pageTitle', 'logs'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->is_free) {
            $priceValidation = 'required|numeric|gt:0';
        } else {
            $priceValidation = 'nullable';
        }

        $extensions = getFileExt('file_extensions');
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

        $image = Image::with('category')->findOrFail($id);

        $image->category_id   = $request->category;
        $image->title         = $request->title;
        $image->resolution    = $request->resolution;
        $image->tags          = $request->tags;
        $image->extensions    = $request->extensions;
        $image->colors        = $request->colors;
        $image->attribution   = $request->attribution ? Status::ENABLE : Status::DISABLE;
        $image->is_free       = $request->is_free ? Status::ENABLE : Status::DISABLE;
        $image->is_active     = $request->is_active ? Status::ENABLE : Status::DISABLE;
        $image->price         = $request->price;
        $image->status        = $request->status;
        $image->admin_id      = auth('admin')->id();
        $image->reviewer_id = 0;
        if ($image->status == 3) {
            $image->reason = $request->reason;
        }

        $image->save();

        if ($image->status == 3) {
            notify($image->user, 'IMAGE_REJECT', [
                'title' => $image->title,
                'category' => $image->category->name,
                'reason' =>  $image->reason
            ]);
        } elseif ($image->status == 1) {
            notify($image->user, 'IMAGE_APPROVED', [
                'title' => $image->title,
                'category' => $image->category->name
            ]);
        }

        $notify[] = ['success', 'تم تحديث الصورة بنجاح'];
        return back()->withNotify($notify);
    }

    public function downloadFile($id)
    {

        $image = Image::findOrFail($id);
        return DownloadFile::download($image);
    }

    protected function imageData($scope = null)
    {
        if ($scope) {
            $images = Image::$scope();
        } else {
            $images = Image::query();
        }
        return  $images->searchAble(['title', 'category:name', 'user:username,firstname,lastname', 'collections:title', 'admin:username,name', 'reviewer:username,name'])->orderBy('id', 'desc')->with('category', 'user')->paginate(getPaginate());
    }
}
