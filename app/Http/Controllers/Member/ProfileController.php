<?php

namespace App\Http\Controllers\Member;

use App\Models\File;
use App\Models\User;
use App\Models\Bank;
use App\Models\IdentityCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id)
    {
    	if( User::find($id)->privilege == 0 )
    		return $this->view(['data' => User::find($id)]);
    	else
    		abort(403, 'Tindakan tidak sah.');
    }

    public function update($id)
    {
    	if( $id == Auth::user()->id )
    		return $this->view(['data' => User::find($id),
                                'bank' => Bank::where('user_id', $id)->first()
                            ]);
    	else
    		abort(403, 'Tindakan tidak sah.');
    }

    public function setting(Request $request, $id)
    {
        $validator = $request->validate([
            'name'          => 'nullable|string|max:191',
            'phone'         => ['nullable', 'string', 'phone:ID', Rule::unique('users')->ignore($id)],
            'address'       => 'nullable|string',
            // 'age'           => 'nullable|numeric',
            'birthplace'    => 'nullable|string',
            'birthdate'     => 'nullable|date',
            'gender'        => 'nullable|in:Male,Female',
            // 'religion'      => 'nullable|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Kong Hu Cu',
        ]);

        $user = User::find($id);
        $user->name         = $request->name;   
        $user->phone        = $request->phone;
        $user->address      = $request->address;
        $user->age          = (getdate()['year']) - substr($request->birthdate, 0, 4);
        $user->birthplace   = $request->birthplace;
        $user->birthdate    = $request->birthdate;
        $user->gender       = $request->gender;
        // $user->religion     = $request->religion;

        if( $user->save() ){
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan Data berhasil disimpan.',
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan Data gagal disimpan',
            ]);
        }
    }

    public function password(Request $request, $id)
    {
        $user = User::find($id);

        if( !(Hash::check($request->current_password, $user->password)) ){
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi Anda saat ini tidak cocok dengan kata sandi yang Anda berikan. Silakan coba lagi.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        
        if( $user->save() ){
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Data berhasil disimpan.',
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Data gagal disimpan',
            ]);
        }
    }

    public function avatar(Request $request, $id)
    {
        $validator = $request->validate([
            'file_id'   => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $user = User::find($id);

        if( $request->file_id != null ){
            if( $request->hasFile('file_id') != null ){
                if( $user->file_id != null ){
                    $picture = File::find(intval($user->file_id));
                    Storage::delete($picture->path);
                    $picture->delete();
                }
            }

            $filename  = $request->file('file_id')->getClientOriginalName();
            $path      = $request->file('file_id')->store('member');
            $extension = $request->file('file_id')->getClientOriginalExtension();
            $size      = $request->file('file_id')->getClientSize();
            
            $file            = new File();
            $file->filename  = time() . '_' . $filename;
            $file->title     = $request->name;
            $file->path      = $path;
            $file->extension = $extension;
            $file->size      = $size;
            $file->save();

            $user->file()->associate($file);
        }

        $user->save();

        if( !$user->save() ){
            if ( $request->hasFile('file_id') ) {
               $fileDelete = File::where('path', '=', $file->path)->first();
               Storage::delete($fileDelete->path);
               $fileDelete->delete(); 
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Profil Foto Tidak Berhasil Diedit'
            ]);
        }
        else{
            return response()->json([
                'success'  => true,
                'message'  => 'Profil Foto Berhasil Diedit'
            ]);
        }
    }

    public function identity_card(Request $request, $id)
    {

        $user = User::find($id);

        if( $user->identity_card_id == null ){
            $validator = $request->validate([
                'file_identity_card'    => 'nullable|mimes:jpeg,jpg,png|max:5000',
                'number'                => 'required|numeric',
            ]);
            
            $identity_card = new IdentityCard();
            $identity_card->number  = $request->number;

            if( $request->file_identity_card != null ){
                if( $request->hasFile('file_identity_card') != null ){
                    if( $identity_card->file_id != null ){
                        $picture = File::find(intval($identity_card->file_id));
                        Storage::delete($picture->path);
                        $picture->delete();
                    }
                }

                $filename  = $request->file('file_identity_card')->getClientOriginalName();
                $path      = $request->file('file_identity_card')->store('member/' . Auth::user()->id . '/');
                $extension = $request->file('file_identity_card')->getClientOriginalExtension();
                $size      = $request->file('file_identity_card')->getClientSize();
                
                $file            = new File();
                $file->filename  = time() . '_' . $filename;
                $file->title     = $request->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $identity_card->file()->associate($file);
            }

            $identity_card->save();
            $user->identity_card()->associate($identity_card);
            $user->save();

            if( !$identity_card->save() ){
                if ( $request->hasFile('file_identity_card') ) {
                   $fileDelete = File::where('path', '=', $file->path)->first();
                   Storage::delete($fileDelete->path);
                   $fileDelete->delete(); 
                }

                return response()->json([
                    'success'   => false,
                    'message'   => 'Kartu Identitas Tidak Berhasil Disimpan.'
                ]);
            }
            else{
                return response()->json([
                    'success'  => true,
                    'message'  => 'Kartu Identitas Berhasil Disimpan.'
                ]);
            }
        }
        else{
            $validator = $request->validate([
                'file_identity_card'    => 'nullable|mimes:jpeg,jpg,png|max:5000',
                'number'                => ['required', 'numeric'],
            ]);

            $identity_card = IdentityCard::find($request->identity_card_id);
            $identity_card->number  = $request->number;
            $identity_card->status  = IdentityCard::STATUS_PENDING;

            if( $request->file_identity_card != null ){
                if( $request->hasFile('file_identity_card') != null ){
                    if( $identity_card->file_id != null ){
                        $picture = File::find(intval($identity_card->file_id));
                        Storage::delete($picture->path);
                        $picture->delete();
                    }
                }

                $filename  = $request->file('file_identity_card')->getClientOriginalName();
                $path      = $request->file('file_identity_card')->store('member/' . Auth::user()->id . '/');
                $extension = $request->file('file_identity_card')->getClientOriginalExtension();
                $size      = $request->file('file_identity_card')->getClientSize();
                
                $file            = new File();
                $file->filename  = time() . '_' . $filename;
                $file->title     = $request->name;
                $file->path      = $path;
                $file->extension = $extension;
                $file->size      = $size;
                $file->save();

                $identity_card->file()->associate($file);
            }

            $identity_card->save();

            if( !$identity_card->save() ){
                if ( $request->hasFile('file_identity_card') ) {
                   $fileDelete = File::where('path', '=', $file->path)->first();
                   Storage::delete($fileDelete->path);
                   $fileDelete->delete(); 
                }

                return response()->json([
                    'success'   => false,
                    'message'   => 'Kartu Identitas Tidak Berhasil Diedit.'
                ]);
            }
            else{
                return response()->json([
                    'success'  => true,
                    'message'  => 'Kartu Identitas Berhasil Diedit.'
                ]);
            }
        }
    }

    public function bank(Request $request, $id)
    {
        if( $request->bank_id == null )
        {
            $validator = $request->validate([
                'bank_name'         => 'required|string|max:191',
                'account_name'      => 'required|string|max:191',
                'account_number'    => 'required|numeric',
            ]);

            $bank           = new Bank();
            $bank->name     = $request->bank_name;
            $bank->owner    = $request->account_name;
            $bank->number   = $request->account_number;
            $bank->status   = 'publish';
            $bank->user_id  = Auth::user()->id;
            $bank->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Bank Berhasil Disimpan.'
            ]);
        }
        else{
            $validator = $request->validate([
                'bank_name'         => 'required|string|max:191',
                'account_name'      => 'required|string|max:191',
                'account_number'    => 'required|numeric',
            ]);


            $bank           = Bank::find($request->bank_id);
            $bank->name     = $request->bank_name;
            $bank->owner    = $request->account_name;
            $bank->number   = $request->account_number;
            $bank->status   = 'publish';
            $bank->user_id  = Auth::user()->id;
            $bank->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Bank Berhasil Diedit.'
            ]);
        }
    }
}
