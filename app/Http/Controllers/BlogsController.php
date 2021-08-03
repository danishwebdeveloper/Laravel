<?php

namespace App\Http\Controllers;

use App\blogcats;
use App\Blogs;
use Illuminate\Database\Eloquent\Relations\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogsController extends Controller
{


    public function addBlogsSave()
    {

        if (request()->has("submit")) {
			//dd(request()->all());
            request()->validate([
                'title'   => ['required'],
                'slug'    => ['required'],
                'content' => ['required'],
            ]);
            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ($type != "") {
                for ($a = 0; $a < count($type); $a++) {
                    if ($type[$a] != "") {
                        $schm[] = array(
                            "schema" => $schema[$a],
                            "type"   => $type[$a],
                        );
                    }
                }
            }
            $schema   = (json_encode($schm));
            $category = (is_array(request('category'))) ? implode(",", request('category')) : request('category');
            $related  = (is_array(request('related'))) ? implode(",", request('related')) : request('related');
            $date     = (request()->filled('update_date')) ? strtotime(request('update_date')) : request('date');
            $question = request('question');
            $answer   = request('answer');
            $num      = request('num');
            // dd($num);
            $faqs = array();
            if (is_array(request("question"))) {
                for ($a = 0; $a < count($question); $a++) {
                    if ($question[$a] != "") {
                        $faqs[] = array(
                            "num"      => $num[$a],
                            "question" => $question[$a],
                            "answer"   => $answer[$a],
                        );
                    }
                }
                $faqs = json_encode($faqs);
            }
            $green_text = "";
            $gr_heading = request('gr_heading');
            $gr_body    = request('gr_body');
            $gr_text    = array();
            if (is_array(request("gr_body"))) {
                for ($a = 0; $a < count($gr_heading); $a++) {
                    if ($gr_body[$a] != "") {
                        $gr_text[] = array(
                            "gr_heading" => $gr_heading[$a],
                            "gr_body"    => $gr_body[$a],
                        );
                    }
                }
                $green_text = json_encode($gr_text);
            }
            $red_text    = "";
            $red_heading = request('red_heading');
            $red_body    = request('red_body');
            $red_t       = array();
            if (is_array(request("red_body"))) {
                for ($a = 0; $a < count($red_heading); $a++) {
                    if ($red_body[$a] != "") {
                        $red_t[] = array(
                            "red_heading" => $red_heading[$a],
                            "red_body"    => $red_body[$a],
                        );
                    }
                }
                $red_text = json_encode($red_t);
            }
            $black_text    = "";
            $black_heading = request('black_heading');
            $black_body    = request('black_body');
            $black_text    = array();
            if (is_array(request("black_body"))) {
                for ($a = 0; $a < count($black_heading); $a++) {
                    if ($black_body[$a] != "") {
                        $black_text[] = array(
                            "black_heading" => $black_heading[$a],
                            "black_body"    => $black_body[$a],
                        );
                    }
                }
                $black_text = json_encode($black_text);
            }

           // dd(request()->all());
            $data                     = array();
            $data["title"]            = request('title');
            $data["slug"]             = Str::slug(request('slug'), '-');
            $data["meta_title"]       = request('meta_title');
            $data["meta_description"] = request('meta_description');
            $data["meta_tags"]        = request('meta_tags');
            $data["cover"]            = request('cover-image');
            $data["og_image"]         = request('og-image');
            $data["status"]           = request('status');
            $data["author"]           = request('author');
            $data["category"]         = $category;
            $data["related"]          = $related;
            $data["faqs"]             = $faqs;
            $data["green_text"]       = $green_text;
            $data["red_text"]         = $red_text;
            $data["black_text"]       = $black_text;
            $data["content"]          = request('content');
            $data["internal_links"]   = request('internal_links');
            $data["status"]   = request('submit');
            $data["date"]             = $date;
            $data["microdata"]        = $schema;
            // dd($data);
            if (request()->has('id')) {
                DB::table('blogs')->where('id', request('id'))->update($data);
                return back()->with('flash_message', 'Blog Record Updated Successfully');
            } else {
                $id = DB::table('blogs')->insertGetId($data);
                return redirect(route('save-blog') . '?edit=' . $id)->with('flash_message', 'Blog Record Inserted Successfully');
            }

        }
        if (request('edit')) {
            $id   = request('edit');
            $data = DB::table('blogs')->where('id', $id)->first();
            return view('admin.blogs', compact('data'));
        }
        if (request('delete')) {
            $id   = request('delete');
            $data = DB::table('blogs')->where('id', $id)->delete();
            return back()->with('flash_message', 'Blog Post is deleted Successfully');
        }
        if (request('publish')) {
            $id = request('publish');
            DB::table('blogs')->where('id', $id)->update(['status' => 'publish']);
            return redirect('/' . admin . '/blogs/list')->with('flash_message', 'Blog Post Status is Changed To Publish Successfully');
        }
        if (request('draft')) {
            $id = request('draft');
            DB::table('blogs')->where('id', $id)->update(['status' => 'draft']);
            return redirect('/' . admin . '/blogs/list')->with('flash_message2', 'Blog Post Status is Changed To Draft Successfully');
        }
        return view('admin.blogs'); 
    }

    public function blogsList()
    {
        $num = Blogs::count();
        if (request()->has("st")) {
            $st   = request('st');
            $data = Blogs::where('status', '=', $st)->orderBy('id', 'DESC')->paginate(10);

        } else {
            $data = Blogs::orderBy('id', 'DESC')->paginate(10);
        }

        return view('admin.blogs_list', compact('data', 'num'));
    }
    public function meta()
    {

        if (request('submit')) {
            request()->validate([
                'meta_title' => ['required'],
            ]);
            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ($type != "") {
                for ($a = 0; $a < count($type); $a++) {
                    if ($type[$a] != "") {
                        $schm[] = array(
                            "schema" => $schema[$a],
                            "type"   => $type[$a],
                        );
                    }
                }
            }
            $schema = (json_encode($schm));
            DB::table('meta')->updateOrInsert(
                ['id' => request('id')],
                ['page_name'       => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                ]);
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = DB::table('meta')->where('page_name', 'blogs')->first();
            return view('admin.meta', compact('data'));
        }
    }
    public function blogCategory()
    {

        if (request('edit')) {
            $id   = request('edit');
            $edit = blogcats::where('id', $id)->first();
            $cats = blogcats::all()->sortBy('tb_order');
            return view('admin.blogcats', compact('edit', 'cats'));
        }
        if (request('del')) {
            $id     = request('del');
            $delete = blogcats::where('id', $id)->first();
            $delete->delete();
            return back()->with('flash_message', 'Category is Deleted successfully');

        }
        $edit = "";
        $cats = blogcats::all()->sortBy('tb_order');

        return view('admin.blogcats', compact('cats', 'edit'));
    }
    public function catsStore()
    {
        //  dd(request()->all());
        request()->validate([
            'title'      => ['required'],
            'slug'       => ['required'],
            'meta_title' => ['required'],
        ]);
        $schema = request('schema');
        $type   = request('type');
        $schm   = array();
        if ($type != "") {
            for ($a = 0; $a < count($type); $a++) {
                if ($type[$a] != "") {
                    $schm[] = array(
                        "schema" => $schema[$a],
                        "type"   => $type[$a],
                    );
                }
            }
        }
        $schema = (json_encode($schm));
        //  dd($schema);
        // store and update categories
        blogcats::updateOrCreate(
            ['id' => request('id')]
            , [
                'title'            => request('title'),
                'slug'             => request('slug'),
                'meta_title'       => request('meta_title'),
                'popular_title'    => request('popular_title'),
                'meta_description' => request('meta_description'),
                'details'          => request('details'),
                'meta_tags'        => request('meta_tags'),
                'before_popular'   => request('before_popular'),
                'after_popular'    => request('after_popular'),
                'after_title'      => request('after_title'),
                'og_image'         => request('og_image'),
                'microdata'        => $schema,
            ]);

        return back()->with('flash_message', 'Category is updated successfully');
    }

    public function catsorder()
    {
        $orders = request('order');
        foreach ($orders as $k => $v) {
            $page = blogcats::find($v);
            if ($page) {
                $page->tb_order = $k;
                $page->save();
            }

        }
        return back()->with('flash_message', 'Yours settings are updated successfully');
    }

}
