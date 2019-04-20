<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Helpers\MailFailure;
use Illuminate\Http\Request;
use App\Mail\UserConfirmation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function unconfirm(Request $request, $action = 'unconfirm'){
        if ($action == 'resend'){
            $user = Auth::user();
            try{
                $user->confirmation_link = time();
                $user->save();
                Mail::send(new UserConfirmation($user));
                if (Mail::failures()) {
                    $body   = (new UserConfirmation( $user ))->render();

                    MailFailure::mail_failure($user->email, $user->name, 'Email Confirmation', $body);
                }
            }catch (\Exception $e){
                Log::error($e->getTraceAsString());
            }
            return redirect('owner/user/unconfirm/resend_success');
        }
        return $this->view(['action' => $action]);
    }

    public function not_active(){
    	return view('owner.user.not_active');
    }

    public function email_confirmation(Request $request, $link){
        try{
            $decrypt = explode(";", decrypt($link));
            if (count($decrypt) != 2){
                return redirect()->route('owner.home.index');
            }

            if(($user = User::where('email', $decrypt[0])->first()) !== null){
                if (($decrypt[1] + 3600) < time()){
                    $status = false;
                }else{
                    $user->update(['status'=> User::STATUS_CONFIRM]);
                    $status = true;
                }
                return $this->view(['status' => $status, 'user' => $user, ]);
            } else {
                return redirect()->route('owner.home.index');
            }

        }catch (\Exception $e){
            Log::error($e->getTraceAsString());
            return redirect()->route('owner.home.index');
        }
    }
}
