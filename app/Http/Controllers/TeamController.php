<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Database\Eloquent\Relations\paginate;
use Illuminate\Http\Request;

class teamController extends Controller
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
            $id = Team::insertGetId($data);
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
            Team::where('id', request('edit'))->update($data);
            return back()->with('success', 'team Record updated successfully');

        } elseif (request()->has('edit')) {
            $data = Team::where('id', request('edit'))->first();
            return view('admin.team.add-author', compact('data'));

        } elseif (request()->has('delete') and is_numeric(request('delete'))) {
            Team::where('id', request('delete'))->delete();
            return back()->with('success', 'team Record deleted successfully');

        } elseif (request()->has('publish')) {
            $id = request('publish');
            Team::where('id', $id)->update(['status' => 'publish']);
            return redirect(route('team-list'))->with('success', 'Status is Changed To Publish Successfully');
        }
        if (request()->has('draft')) {
            $id = request('draft');
            Team::where('id', $id)->update(['status' => 'draft']);
            return redirect(route('team-list'))->with('alert', 'Status is Changed To Draft Successfully');
        }
        return view('admin.team.add-author');
    }
    public function teamList()
    {

        $data = Team::orderBy('id', 'DESC')->paginate(10);
        return view('admin.team.team-list', compact('data'));
    }

}
