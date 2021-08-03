<?php

namespace App\Http\Controllers;

use App\Authors;
use Illuminate\Database\Eloquent\Relations\paginate;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{

    public function addAuthor(Request $request)
    {
        //dd(request()->all());
        if (request("save") == "Submit") {
            $icon  = request('icon');
            $link  = request('link');
            $links = array();
            for ($a = 0; $a < count($link); $a++) {
                if ($link[$a] != "") {
                    $links[] = array(
                        "link" => $link[$a],
                        "icon" => $icon[$a],
                    );
                }
            }
            $social_links = (json_encode($links));
            $this->validate($request, [
                'name'       => 'required|max:500|regex:/^[a-zA-Z]+$/u',
                'cover_image'     => 'required',
                'detail'    => 'required',
            ]);

            $data['name']     = request('name');
            $data['details']  = request('detail');
            $data['cover'] = request('cover_image');
            $data['social_links'] = $social_links;
            //dd($data);
            $id = Authors::insertGetId($data);
            return redirect(route('add-author') . '?edit=' . $id)->with('success', 'Record is added successfully');
        } elseif (request("save") == "Update" and request()->has('edit')) {
           $icon  = request('icon');
            $link  = request('link');
            $links = array();
            for ($a = 0; $a < count($link); $a++) {
                if ($link[$a] != "") {
                    $links[] = array(
                        "link" => $link[$a],
                        "icon" => $icon[$a],
                    );
                }
            }
            $social_links = (json_encode($links));
            
            $this->validate($request, [
                'name'       => 'required|max:500|regex:/^[a-zA-Z]+$/u',
                'cover_image'     => 'required',
                'detail'    => 'required',
            ]);
            $data = [
                'name'     => request('name'),
                'details'  => request('detail'),
                'cover' => request('cover_image'),
                'social_links' => $social_links,
            ];
            //dd($data);
            Authors::where('id', request('edit'))->update($data);
            return back()->with('success', 'Authors Record updated successfully');

        } elseif (request()->has('edit')) {
            $data = Authors::where('id', request('edit'))->first();
            return view('admin.authors.add-author', compact('data'));

        } elseif (request()->has('delete') and is_numeric(request('delete'))) {
            Authors::where('id', request('delete'))->delete();
            return back()->with('success', 'Authors Record deleted successfully');

        } elseif (request()->has('publish')) {
            $id = request('publish');
            Authors::where('id', $id)->update(['status' => 'publish']);
            return redirect(route('authors-list'))->with('success', 'Status is Changed To Publish Successfully');
        }
        if (request()->has('draft')) {
            $id = request('draft');
            Authors::where('id', $id)->update(['status' => 'draft']);
            return redirect(route('authors-list'))->with('alert', 'Status is Changed To Draft Successfully');
        }
        return view('admin.authors.add-author');
    }
    public function authorsList()
    {

        $data = Authors::orderBy('id', 'DESC')->paginate(10);
        return view('admin.authors.authors-list', compact('data'));
    }

}
