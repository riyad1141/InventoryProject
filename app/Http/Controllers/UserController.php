<?php

namespace App\Http\Controllers;

use App\Helper\JWT_CLASS;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{


    public function LoginPage (): View {
        return view('pages.auth.login-page');
    }
    public function RegistrationPage (): View {
        return view('pages.auth.registration-page');
    }
    public function SendOtpPage (): View {
        return view('pages.auth.send-otp-page');
    }
    public function VerifyOtpPage (): View {
        return view('pages.auth.verify-otp-page');
    }
    public function ResetPasswordPage (): View {
        return view('pages.auth.reset-password-page');
    }




    public function UserRegistration (Request $request): JsonResponse
    {

        try {

            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $email = $request->input('email');
            $mobile = $request->input('mobile');
            $password = $request->input('password');

            User::create([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'mobile' => $mobile,
                'password' => $password,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully Completed'
            ]);
        }catch (Exception $exception){
            return response()->json([
                'status' => 'Failed',
                'message' => 'User Registration Failed',
                'Exception' => $exception->getMessage()
            ]);
        }
    }

    public function UserLogin (Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email','=',$email)->where('password','=',$password)->select('id')->first();

        if ($user !== null){
            $token = JWT_CLASS::createToken($email,$user->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successfully Completed',
                'token' => $token
            ])->cookie('token',$token,60*60*24);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function SendOtpCode (Request $request) {
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email','=',$email)->count();
        if ($count == 1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => '4 Digit Otp was sent your Email'
            ])->cookie('token','',-1);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function VerifyOtp (Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $user = User::where('email','=',$email)->where('otp','=',$otp)->select('id')->first();
        if ($user  !== null){
            User::where('email','=',$email)->update(['otp' => '0']);
            $token = JWT_CLASS::createToken($email,$user->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Otp Verify Successfully Completed'
            ])->cookie('token',$token,60*60);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function PasswordReset (Request $request) {
        $email = $request->header('email');
        $password = $request->input('password');
        $count = User::where('email','=',$email)->count();

        if ($count == 1){
            User::where('email','=',$email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset Successfully Completed'
            ])->cookie('token','',-1);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function Logout (Request $request)
    {
        return redirect("/LoginPage")->cookie('token','',-1);
    }

    public function UserProfile (Request $request): JsonResponse
    {
        try {
            $email = $request->header('email');
            $user = User::where('email','=',$email)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successfully',
                'data' => $user
            ]);
        }catch (Exception $exception){
            return response()->json([
                'status' => 'Failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function UpdateProfile (Request $request): JsonResponse
    {
        $email = $request->header('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $password = $request->input('password');
        $count = User::where('email','=',$email)->count();
        if ($count == 1){
            User::where('email','=',$email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mobile' => $mobile,
                'password' => $password,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Profile Update Successfully Completed',
            ]);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something Went Wrong'
            ]);
        }
    }




}
