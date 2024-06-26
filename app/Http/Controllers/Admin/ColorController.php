<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function all()
    {
        $pageTitle = "All Colors";
        $colors    = Color::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.color.all', compact('pageTitle', 'colors'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'       => 'required|string|max:40|unique:colors,name,' . $id,
            'color_code' => 'required|max:6|unique:colors,color_code,' . $id
        ]);

        if ($id) {
            $color        = Color::findOrFail($id);
            $notification = "يتم تحديث اللون بنجاح";
        } else {
            $color        = new Color();
            $notification = "أضاف اللون بنجاح";
        }

        $color->name       = $request->name;
        $color->color_code = $request->color_code;
        $color->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        $notify[] = ['success', 'تم حذف اللون بنجاح'];
        return back()->withNotify($notify);
    }
}
