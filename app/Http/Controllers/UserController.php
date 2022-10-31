<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\userModel;
use App\SocietyModel;
use Hash;
use Auth;
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
    public function dashboard()
    {
        return view('dashboard');
    }
    public function receipt()
    {
        return view('receipt');
    }
    public function validatesocdetail(Request $request)
    {
        $result = SocietyModel::where(['pan'=> $request->pan,'email'=>$request->email])->get();
        
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
            return redirect()->route('register');
        }
    }

    public function registercomplete(){

        $User = userModel::find(request('id'));
        $User->soc_name = request('soc_name');
        $User->soc_address = request('soc_address');
        $User->gstin = request('gstin');
        $User->mfms =request('mfms');
        $User->ph_number =request('ph_number');
        $User->registration_status = '2';
        $User->status = '1';
        $User->updated_by =Session::get('soctemp_detail')[0]->email;
        $User->save();                                  
        Session::flash('msg','Registration is successfully');
        return view('login');

    }

    public function login(Request $request)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
        
        // $validator = Validator::make($request->all(), [
        //     'pan' => 'required',
        //     'password' => 'required',
        //                                                                                                                     'captcha' => 'required|captcha'                                                                                                                                                                                                     
        // ]);
                                                                                                                                                                                                                     
        $request->validate([
            'pan' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);
        // If ($validator->fails()){
        //     return view('login');
        // }else{
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
        // }
        

    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
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
