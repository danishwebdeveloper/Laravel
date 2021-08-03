<?php
namespace App\Http\Controllers;

use App\ContactUs;
use App\Faqs;
use App\Models\Pages;
use App\Privacy;
use App\TermsCondition;
use DB;
use Illuminate\Http\Request;

class CmsController extends Controller
{

    public function contact()
    {

        $data   = ContactUs::first();
        $record = "";
        return view('admin.contact-us', compact('data', 'record'));
    }
    public function editcontactus(AboutUs $record)
    {
        // dd($record);
        $page_data = AboutUs::all();
        return view('admin.about-us', compact('page_data', 'record'));
    }
    public function storecontactus()
    {
        //  dd(request()->all());
        request()->validate([
            'meta_title' => ['required', 'min:3', 'max:250'],
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
        // store and update categories
        if (request()->has('id')) {
            ContactUs::where('id', request('id'))->update([
                'meta_title'       => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_tags'        => request('meta_tags'),
                'title'            => request('title'),
                'r_email'          => request('r_email'),
                'detail'           => request('detail'),
                'email_title'      => request('email_title'),
                'email_1'          => request('email_1'),
                'email_2'          => request('email_2'),
                'phone_title'      => request('phone_title'),
                'phone_1'          => request('phone_1'),
                'phone_2'          => request('phone_2'),
                'address_title'    => request('address_title'),
                'address'          => request('address'),
                'google_map'       => request('google_map'),
                'og_image'         => request('og_image'),
                'microdata'        => $schema,
            ]);
        }
        return back()->with('flash_message', 'Yours settings are updated successfully');
    }
    public function delete(AboutUs $record)
    {
        // deleting selected category
        $record->delete();
        // returning back to the same page
        return back()->with('flash_message', 'Yours settings are updated successfully');
    }
/*    public function contactstore() {
request()->validate([
'meta_title' => ['required', 'min:3'],
'meta_description' => ['required', 'min:5'],
'title' => ['required', 'min:5'],
'meta_tags' => ['required'],
'content' => ['required'],
]);
// store and update categories
ContactUs::updateOrCreate(
['id' => request('id')]
, [
'meta_title' => request('meta_title'),
'meta_descp' => request('meta_description'),
'title' => request('title'),
'meta_tags' => request('meta_tags'),
'content' => request('content'),
]);
return back()->with('flash_message', 'Yours settings are updated successfully');
}*/
    //Terms Condition
    public function privacy()
    {

        if (request('submit')) {
            //dd(request()->all());
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
                'content'          => ['required'],

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
            Pages::updateOrInsert(
                [
                    'id' => request('id')],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'content'          => request('content'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                    'updated_at'       => date("y-m-d h:i:s"),
                ]);
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = Pages::where('page_name', 'privacy')->first();
            return view('admin.privacy', compact('data'));
        }
    }

    //Terms Condition
    public function termscondition()
    {

        if (request('submit')) {
            //dd(request()->all());
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
                'content'          => ['required'],

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
            Pages::updateOrInsert(
                [
                    'id' => request('id')],
                [
                    'page_name'        => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'content'          => request('content'),
                    'microdata'        => $schema,
                    'og_image'         => request('og_image'),
                    'updated_at'       => date("y-m-d h:i:s"),
                ]);
            return back()->with('flash_message', 'Record is Updated successfully');
        } else {
            $data = Pages::where('page_name', 'terms-condition')->first();
            return view('admin.terms-condition', compact('data'));
        }
    }

    // FAQs
    public function faqs()
    {
        if (request()->isMethod('post')) {
            //dd(request()->all());
            request()->validate([
                'question' => ['required', 'min:10', 'max:250'],
                'answer'   => ['required', 'min:10', 'max:2000'],
            ]);
            // store and update categories
            Faqs::updateOrCreate(
                ['id' => request('id')]
                , [
                    'question' => request('question'),
                    'answer'   => request('answer'),
                ]);
            return back()->with('flash_message', 'Yours settings are updated successfully');
        } else {
            if (request('edit')) {
                $id   = request('edit');
                $edit = Faqs::where('id', $id)->first();
                $faqs = Faqs::all()->sortBy('tb_order');
                return view('admin.faqs', compact('edit', 'faqs'));
            }
            if (request('del')) {
                $id     = request('del');
                $delete = Faqs::where('id', $id)->first();
                $delete->delete();
                return back()->with('flash_message', 'Yours settings are updated successfully');
            }
            $edit = "";
            $faqs = Faqs::all()->sortBy('tb_order');
            return view('admin.faqs', compact('faqs', 'edit'));
        }
    }
    public function allfaqs()
    {
        $faqs = Faqs::all()->sortBy('id');
        return view('admin.faqs_list', compact('faqs'));
    }
    public function faqsorder()
    {
        $orders = request('order');
        foreach ($orders as $k => $v) {
            $page = Faqs::find($v);
            if ($page) {
                $page->tb_order = $k;
                $page->save();
            }
        }
        return back()->with('flash_message', 'Yours settings are updated successfully');
    }
       public function faqs_meta()
    {

        if (request('submit')) {
            $schema = request('schema');
            $type   = request('type');
            $schm   = array();
            if ($schema != "") {
                for ($a = 0; $a < count($type); $a++) {
                    if ($schema[$a] != "") {
                        $schm[] = array(
                            "schema" => $schema[$a],
                            "type"   => $type[$a],
                        );
                    }
                }
            }

            $schema = (json_encode($schm));
            request()->validate([
                'meta_title'       => ['required', 'max:255'],
                'meta_description' => ['required', 'max:500'],
            ]);
            DB::table('meta')->updateOrInsert(
                ['id' => request('id')],
                ['page_name'       => request('page_name'),
                    'meta_title'       => request('meta_title'),
                    'meta_description' => request('meta_description'),
                    'meta_tags'        => request('meta_tags'),
                    'og_image'         => request('og_image'),
                    'microdata'        => $schema,
                ]);
            return back()->with('flash_message', 'Settings are Updated successfully');
        } else {
            $data = DB::table('meta')->where('page_name', 'faqs')->first();
            return view('admin.faqs_meta', compact('data'));
        }
    }
}
