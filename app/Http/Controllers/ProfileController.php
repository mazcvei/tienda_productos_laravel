<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {

        $userProducts = Auth::user()->productos;
        $usuarios =User::all();
        return view('profile.edit', [
            'user' => Auth::user(),
            'userProducts' =>$userProducts,
            'usuarios' =>$usuarios,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $user = Auth::user();
        $user->name= $request->name;
        $user->email= $request->email;
        if($request->password!=null){
            $user->password = Hash::make($request->password);
        }
        if(!$user->addressUser){
            UserAddress::create([
                'user_id'=>Auth::id(),
                'address'=>$request->address,
                'city'=>$request->ciudad,
                'cp'=>$request->cp,
            ]);
        }else{
            $user->addressUser->address = $request->address;
            $user->addressUser->city = $request->ciudad;
            $user->addressUser->cp = $request->cp;
            $user->addressUser->save();
        }
        $user->save();


        return response()->json(['status'=>'ok','message'=>'Datos actualizados correctamente.']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
