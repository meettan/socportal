<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Mail;
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
    public function forgotpassword(Request $request)
    {
        if ($request->isMethod('post')) {

            $user = userModel::where(['pan'=> $request->pan])->get();
            if($user[0]->pan !=''){

                DB::table('td_users')->where('pan', $user[0]->pan)->update(['forgot_pass_otp' => sha1($user[0]->pan),'otp_date'=>date('Y-m-d')]);
                $link = '<!DOCTYPE html><html><head><title>Password Change Email</title></head><body>';
                $link .='<h2>Welcome to the Benfed</h2><br/>Your registered email-id is "'.$user[0]->email.'" , Please click on the below link to Chnage your Password <br/>';
                $url = route('setuppassword',['pan'=>$user[0]->pan,'emailid'=>$user[0]->email,'token'=>sha1($user[0]->pan)]);
                $link .= '<a href="'.$url.'" target="_blank">Verify Link</a>';
                $link .= '</body></html>';
                //$data = array('name'=>"Virat Gandhi");
                $result = Mail::send('mail', $link, function($message) {
                    $message->to('lk60588@gmail.com', 'Benfed')->subject
                        ('Change Password');
                    $message->from('lokesh@synergicsoftek.com','Lokesh');
                });
                if($result){
                    Session::flash('msg','Mail Sent successfully');
                    return redirect()->route('login');
                }
                Session::flash('error_msg','Mail not sent ! Failed');
                return redirect()->route('login');
            }
            
            //echo $user[0]->email;

        }else{
            return view('forgotpassword');
        }
        
    }
    public function setuppassword(Request $request){
        if($request->isMethod('post')) {
            $token = $request->token;
            $user = userModel::where(['pan'=> $request->pan])->get();
            if($token == $user[0]->forgot_pass_otp){
                $pass = Hash::make(request('password'));
                DB::table('td_users')->where('pan', $request->pan)->update(['password' => $pass,'forgot_pass_otp'=>'' ]);
                Session::flash('msg','Password change successfully');
                return redirect()->route('login');
            }else{
                Session::flash('error_msg','Token mismatch ! Failed');
                return redirect()->route('login');
            }
            
        }else{
            $pan = $request->pan;
            $token = $request->token;
           return view('setuppassword',['datas'=>$request]);
        }
         
    }
    // Here PAN is using as Uniquie Identifier,Using table v_ferti_soc for validating 
    // society exist or not . After that checking society already register or 
    // not using PAN  in this portal using table v_ferti_soc
    public function validatesocdetail(Request $request)
    {
        $user = userModel::where(['pan'=> $request->pan])->get();
        if (count($user) > 0) {
            Session::flash('msg','You already registered');
            return redirect()->route('login');
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
        return redirect()->route('login');
    }
    // Login process using PAN and given password using table td_users
    public function login(Request $request)
    {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
            $user = userModel::where(['pan'=> $request->pan])->get();
            if (count($user) > 0) {
                if (Auth::attempt(['pan' => $request->pan, 'password' => $request->password])) {
                    $userdtl =DB::table('v_ferti_soc')
                    ->leftJoin('v_district','v_ferti_soc.district','=','v_district.district_code')
                    ->select('v_ferti_soc.*','v_district.district_name')
                    ->where('v_ferti_soc.pan','=',$request->pan)
                    ->first();
                    session(['socuserdtls' => $userdtl]);
                    Session::put('raw_password', $request->password);

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
    public function panvalidateforpassword(Request $request){
        $pan = $request->pan;
        // $panexist = SocietyModel::where(['pan'=> $request->pan])->get();
        // if (count($panexist) > 0) {
            $user = userModel::where(['pan'=> $request->pan])->get();
            if (count($user) > 0) {
                return response()->json(['status'=> 1]);
            }else{
                return response()->json(['status'=> 0]);
            }
        // }else{
        //     return response()->json(['status'=> 2]);
        // }
    }
    
    // Here logout operation happen and destroying session using Laravel 
    // Predefined AUTH middleware. 
    public function logout(){

        
        Auth::logout();
        Session::flush();
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
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");
     
       
        // echo "Basic Email Sent. Check your inbox.";
        // Mail::send([], [], function ($message) { 
        //     $message->to('lk60588@gmail.com', 'Tutorials Point')
        //        ->subject('subject')
        //        ->from('lokesh@synergicsoftek.com','Virat Gandhi') 
        //        ->setBody('some body', 'text/html'); 
        // });

        $to = "lk60588@gmail.com";
        $subject = "My subject";
        $txt = "Hello world!";
        $headers = "From: lokesh@synergicsoftek.com" . "\r\n";
        //"CC: somebodyelse@example.com"
        
        $result = mail($to,$subject,$txt,$headers);
        if(!$result) {   
            echo "Error";   
        } else {
            echo "Success";
        }
     }
    

}