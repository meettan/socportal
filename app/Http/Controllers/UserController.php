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
    // Loading registeration First page  
    public function register()
    {
        return view('signup');
        //echo Hash::make('123');
    }
    // Loading registeration Second page
    public function register_second($id)
    {
        return view('signup2',['id'=>$id]);
    }
    // Here PAN is using as Uniquie Identifier,Using table v_ferti_soc for validating 
    // society exist or not . After that checking society already register or 
    // not using PAN  in this portal using table v_ferti_soc
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
                
            return view('signup2',['datas'=>$request,'soc_id'=>$result[0]->soc_id]);
            }else{
                Session::flash('error','Pan not available');
                return redirect()->route('register');
            }
       }
    }
    // Registration second Page using PAN, Password from first form Society name ,Society Address,Gistin,Mfms
    // form benfed fertilizer portal database.Using table v_ferti_soc  And
    // Inserting in table td_users
    public function registercomplete(Request $request){
        $dist_id  = Session::get('soctemp_detail')[0]->district;
        $dist_name= DB::select("select district_name FROM v_district WHERE district_code = '$dist_id'");
        $User = new userModel;
        $User->pan = request('prev_pan');
        $User->email = request('prev_email');
        $User->soc_id = request('prev_soc_id');
        $User->password = Hash::make(request('prev_password'));
        $User->soc_name = request('soc_name');
        $User->soc_address = request('soc_address');
        $User->district = $dist_id;
        $User->district_name = $dist_name[0]->district_name;
        $User->gstin = request('gstin');
        $User->mfms =request('mfms');
        $User->ph_number =request('ph_number');
        $User->registration_status = '2';
        $User->status = '1';
        $User->created_by =request('prev_email');
        $User->save();
        Session::forget('soctemp_detail') ;                            
        Session::flash('msg','Registration is successfully');
        return view('login');
    }
    // Login process using PAN and given password using table td_users
    public function login(Request $request)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
        // return Hash::make($request->password);                                                                                                                                                                                                 
        // $request->validate([
        //     'pan' => 'required',
        //     'password' => 'required',
        //     'captcha' => 'required|captcha',
        // ]);
            $user = userModel::where(['pan'=> $request->pan])->get();
            if (count($user) > 0) {
                if (Auth::attempt(['pan' => $request->pan, 'password' => $request->password])) {
                    $userdtl = DB::select("select a.*,b.district_name
                     from v_ferti_soc a,v_district b
                     where  a.district = b.district_code
                     and    a.pan   = '$request->pan' ");
                    session(['socuserdtls' => $userdtl[0]]);
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
    //  Valid PAN data for starting registration process using table 
    //  v_ferti_soc before submiting form.  
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
    // Here logout operation happen and destroying session using Laravel 
    // Predefined AUTH middleware. 
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

    public function forgot_password(){
        
    }
    //  Display page of privacypolicy as outer link without login .
    public function privacypolicy(){
        return view('outer_page/privacypolicy');
    }
    //  Display page of Refundpolicy as outer link without login .
    public function refundpolicy(){
        return view('outer_page/refundpolicy');
    }
    //  Display page of Term & Condition as outer link without login .
    public function termcondition(){
        return view('outer_page/termcondition');
    }
    

}
