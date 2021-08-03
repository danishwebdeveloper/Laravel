<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;
use DB;

class AdsController extends Controller
{

    public function index(Request $request)
    {

        if (request('submit')) {
            //dd(request()->all());
            $ads_id = request('ads_id');
            $title = request('title');
            $alt = request('alt');
            $url      = request('url');
            $num      = request('num');
            $_data     = array();
            $mi       = 0;

            for ($a = 0; $a < count($num); $a++) {
                $validation['img' . $a] = 'required';
            }
            $this->validate($request, $validation);

            // \DB::beginTransaction();
            try {
                // Store into database
                for ($a = 0; $a < count($num); $a++) {
                    $mi  = (array_key_exists("img" . $mi, request()->all())) ? $mi : $mi + 1;
                    $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    if ($img != "") {
                        $_data[] = array(
                            "title" => $title[$a],
                            "ads_id" => $ads_id[$a],
                            "alt" => $alt[$a],
                            "url"      => $url[$a],
                            "num"      => $num[$a],
                            "img"      => $img,
                        );
                    }
                    $mi++;
                }
                 
                $ads = json_encode($_data);
               // dd($ads);
                DB::table('ads')->updateOrInsert(
                    ['id' => request('id')],
                    [
                        'ads' => $ads,
                    ]);
                return back()->with('flash_message', 'Settings are Updated successfully');

            } catch (Exception $e) {
                // \DB::rollBack();
                Session::put('error', 'Something Went Wrong. Please try again..!!');
                return redirect()->back();
            }

            \DB::commit();

        } else {
            $data = Ads::select('id', 'ads')->first();
            //dd($data);
            return view('admin.ads', compact('data'));
        }
    }
}
