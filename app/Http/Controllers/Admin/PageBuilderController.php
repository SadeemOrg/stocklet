<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function managePages()
    {
        $pdata = Page::where('tempname', $this->activeTemplate)->get();
        $pageTitle = 'Manage Pages';
        return view('admin.frontend.builder.pages', compact('pageTitle', 'pdata'));
    }

    public function managePagesSave(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => 'required|min:3|string|max:40',
        ]);

        $exist = Page::where('tempname', $this->activeTemplate)->where('slug', slug($request->slug))->count();
        if ($exist != 0) {
            $notify[] = ['error', 'هذه الصفحة موجودة بالفعل على القالب الحالي. الرجاء تغيير الرخية.'];
            return back()->withNotify($notify);
        }
        $page = new Page();
        $page->tempname = $this->activeTemplate;
        $page->name = $request->name;
        $page->slug = slug($request->slug);
        $page->save();
        $notify[] = ['success', 'تمت إضافة صفحة جديدة بنجاح'];
        return back()->withNotify($notify);
    }

    public function managePagesUpdate(Request $request)
    {

        $page = Page::where('id', $request->id)->firstOrFail();
        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => 'required|min:3|string|max:40'
        ]);

        $slug = slug($request->slug);

        $exist = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->first();
        if (($exist) && $exist->slug != $page->slug) {
            $notify[] = ['error', 'هذه الصفحة موجودة بالفعل على القالب الحالي. الرجاء تغيير الرخية.'];
            return back()->withNotify($notify);
        }

        $page->name = $request->name;
        $page->slug = slug($request->slug);
        $page->save();

        $notify[] = ['success', 'تم تحديث الصفحة بنجاح'];
        return back()->withNotify($notify);
    }

    public function managePagesDelete($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        $page->delete();
        $notify[] = ['success', 'تم حذف الصفحة بنجاح'];
        return back()->withNotify($notify);
    }



    public function manageSection($id)
    {
        $pdata = Page::findOrFail($id);
        $pageTitle = 'Manage Section of ' . $pdata->name;
        $sections =  getPageSections(true);
        return view('admin.frontend.builder.index', compact('pageTitle', 'pdata', 'sections'));
    }



    public function manageSectionUpdate($id, Request $request)
    {
        $request->validate([
            'secs' => 'nullable|array',
        ]);

        $page = Page::findOrFail($id);
        if (!$request->secs) {
            $page->secs = null;
        } else {
            $page->secs = json_encode($request->secs);
        }
        $page->save();
        $notify[] = ['success', 'تم تحديث أقسام الصفحة بنجاح'];
        return back()->withNotify($notify);
    }
}
