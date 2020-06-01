<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Alert;
use App\Http\Requests\UpdatePasswordPerusahaanRequest;

class PerusahaanProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }

    public function userData($username)
    {
        // $username = Auth::user()->username;
        global $endpoint;
        $obj = new UserProfileController();
        $result = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?username ?name ?phone ?email ?information
            WHERE {?instance rdf:type silk:Perusahaan . ?instance silk:username ?username . ?instance silk:name ?name . ?instance silk:phone ?phone .
                ?instance silk:email ?email . ?instance silk:information ?information .
	            FILTER regex(?username, '$username')}
            "
        );

        foreach ($result as $row) {
            $userData = (object) [
                'username' => $row->username,
                'nama' => $row->name,
                'no_telepon' => $row->phone,
                'email' => $row->email,
                'informasi' => $row->information,
            ];
        }

        // return view('profile')->with('userData', $object);
        return view('profilePerusahaan', compact('userData'));
    }

    public function sendUserData($id)
    {
        $username = Auth::user()->username;
        global $endpoint;
        $obj = new UserProfileController();
        $result = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?username ?name ?phone ?email ?information
            WHERE {?instance rdf:type silk:Perusahaan . ?instance silk:username ?username . ?instance silk:name ?name . ?instance silk:phone ?phone .
                ?instance silk:email ?email . ?instance silk:information ?information .
	            FILTER regex(?username, '$username')}
            "
        );

        foreach ($result as $row) {
            $userData = (object) [
                'username' => $row->username,
                'nama' => $row->name,
                'no_telepon' => $row->phone,
                'email' => $row->email,
                'informasi' => $row->information,
            ];
        }

        // return view('profile')->with('userData', $object);
        return view('updateProfilePerusahaan', compact('userData'));
    }

    public function update(Request $request)
    {
        $username = Auth::user()->username;
        $userData = $this->userData($username);
        $oldName = $userData->userData->nama;
        $oldPhone = $userData->userData->no_telepon;
        $oldInformasi = $userData->userData->informasi;

        $newName = $request->name;
        $newPhone = $request->newPhone;
        $newInformasi = $request->newInformasi;

        $user = Auth::user();
        $user->name = $newName;

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.perusahaan.edit', ['id' => $user->id])
                ->withErrors($validator)
                ->withInput();
        }

        global $endpoint;
        $obj = new UserProfileController();
        $result = $obj->endpoint->update(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            DELETE DATA{
                <http://www.silk.com#$username> silk:name '$oldName' .
                <http://www.silk.com#$username> silk:phone '$oldPhone' .
                <http://www.silk.com#$username> silk:information '$oldInformasi' .
                
            };

            INSERT DATA{
                <http://www.silk.com#$username> silk:name '$newName' .
                <http://www.silk.com#$username> silk:phone '$newPhone' .
                <http://www.silk.com#$username> silk:information '$newInformasi' .
                
            }
            "
        );

        $user->save();

        return redirect()->route('profile.perusahaan', ['username' => $user->username]);
    }

    public function changeEmail(Request $request)
    {
        $username = Auth::user()->username;
        $userData = $this->userData($username);
        $oldEmail = $userData->userData->email;

        $newEmail = $request->email;

        $user = Auth::user();
        $user->email = $newEmail;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.perusahaan', ['username' => $user->username])
                ->withErrors($validator)
                ->withInput(['tab' => 'v-pills-change-email']);
        }

        global $endpoint;
        $obj = new UserProfileController();
        $result = $obj->endpoint->update(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            DELETE DATA{
                <http://www.silk.com#$username> silk:email '$oldEmail' .
            };

            INSERT DATA{
                <http://www.silk.com#$username> silk:email '$newEmail' .
            }
            "
        );

        $user->save();
        Alert::success('Sukses', 'Email berhasil diganti');

        return redirect()->route('profile.perusahaan', ['username' => $user->username]);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {

        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return redirect()->route('profile.perusahaan', ['username' => $request->user()->username])->withInput(['tab' => 'v-pills-change-password']);
    }
}
