<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\userModel;
use App\SocietyModel;
use Hash;
use Auth;
use DB;
use Captcha;

class UserController extends Controller
{
    public function register()
    {
        return view('signup');
        //echo Hash::make('123');
    }

    public function register_second($id)
    {
        return view('signup2',['id'=>$id]);
        //echo Hash::make('123');
    }
    
    public function validatesocdetail(Request $request)
    {
        $user = userModel::where(['pan'=> $request->pan])->get();
        if (count($user) > 0) {
            Session::flash('msg','You already registered');
            return view('login');
        }
        else{
            $result = SocietyModel::where(['pan'=> $request->pan])->get();
            if (count($result) > 0) {
                session(['soctemp_detail' => $result]);
                $User = new userModel;
                $User->pan = request('pan');
                $User->email = request('email');
                $User->soc_id = $result[0]->soc_id;
                $User->password = Hash::make(request('password'));
                $User->created_by =request('email');
                $User->save();
                $id = $User->id;
            return redirect()->route('registerse',['id'=>$id]);
            // return view('signup2.blade',['id'=>$id]);
            }else{
                Session::flash('error','Pan not available');
                return redirect()->route('register');
            }
       }
    }

    public function registercomplete(){
        $dist_id  = Session::get('soctemp_detail')[0]->district;
        $dist_name= DB::select("select district_name FROM v_district WHERE district_code = '$dist_id'");
        $User = userModel::find(request('id'));
        $User->soc_name = request('soc_name');
        $User->soc_address = request('soc_address');
        $User->district = $dist_id;
        $User->district_name = $dist_name[0]->district_name;
        $User->gstin = request('gstin');
        $User->mfms =request('mfms');
        $User->ph_number =request('ph_number');
        $User->registration_status = '2';
        $User->status = '1';
        $User->updated_by =Session::get('soctemp_detail')[0]->email;
        $User->save();
        Session::forget('soctemp_detail') ;                            
        Session::flash('msg','Registration is successfully');
        return view('login');
    }

    public function login(Request $request)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                           
        // $request->validate([
        //     'pan' => 'required',
        //     'password' => 'required',
        //     'captcha' => 'required|captcha',
        // ]);
        
            $user = userModel::where(['pan'=> $request->pan])->get();
            if (count($user) > 0) {
                if (Auth::attempt(['pan' => $request->pan, 'password' => $request->password])) {
                    // return "if";  // return redirect(session('url.intended'));
                        //  session(['user_detail' => $user]);
                        //session::put('username', $student[0]->user_name);
                        return redirect()->route('dashboard');
                }else{
                    return redirect()->back()->with('login_error','error')->withInput($request->only('email', 'remember'));
                }
                    //if unsuccessfull redirect back to the login form with form data
                    
            } else {
                return redirect()->back()->with('account_active_error', 'error');
            }
       
        

    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    public function panvalidate(Request $request){
        $pan = $request->pan;
        $panexist = SocietyModel::where(['pan'=> $request->pan])->get();
        if (count($panexist) > 0) {
            $user = userModel::where(['pan'=> $request->pan])->get();
            if (count($user) > 0) {
                return response()->json(['status'=> 1]);
            }else{
                return response()->json(['status'=> 0]);
            }
        }else{
            return response()->json(['status'=> 2]);
        }
        

    }
    public function logout(){

        Auth::logout();
        return redirect()->route('login');
        // return view('login');
    }

    public function Show(Type $var = null)
    {
        return view('login');
        # code...
    }
    

}
