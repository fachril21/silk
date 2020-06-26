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


class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }

    

    public function edit($id)
    {
        return view('updateProfile', ['profile' => Auth::user()->id]);
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

            SELECT ?username ?nama ?biografi ?no_telepon ?email ?tanggal_lahir ?jurusan ?universitas ?jenis_kelamin
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:nama ?nama . ?instance silk:biografi ?biografi .
                ?instance silk:no_telepon ?no_telepon . ?instance silk:email ?email . ?instance silk:tanggal_lahir ?tanggal_lahir . ?instance silk:mengambil ?jurusanInstance . ?jurusanInstance silk:nama ?jurusan .
                ?instance silk:lulusan_dari ?universitasInstance . ?universitasInstance silk:nama ?universitas . ?instance silk:jenis_kelamin ?jenis_kelamin
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataSkill = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?skill
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:menguasai ?skillInstance . ?skillInstance silk:nama ?skill .
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataPencapaian = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?pencapaian
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:pencapaian ?pencapaian . 
	            FILTER regex(?username, '$username')}
            "
        );
        foreach ($result as $row) {
            $userData = (object) [
                'username' => $row->username,
                'nama' => $row->nama,
                'biografi' => $row->biografi,
                'no_telepon' => $row->no_telepon,
                'email' => $row->email,
                'tanggal_lahir' => $row->tanggal_lahir,
                'jurusan' => $row->jurusan,
                'universitas' => $row->universitas,
                'jenis_kelamin' => $row->jenis_kelamin
            ];
        }

        // return view('profile')->with('userData', $object);
        return view('profile', compact('userData', 'userDataSkill', 'userDataPencapaian'));
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

            SELECT ?username ?nama ?biografi ?no_telepon ?email ?tanggal_lahir ?jurusan ?universitas ?jenis_kelamin
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:nama ?nama . ?instance silk:biografi ?biografi .
                ?instance silk:no_telepon ?no_telepon . ?instance silk:email ?email . ?instance silk:tanggal_lahir ?tanggal_lahir . ?instance silk:mengambil ?jurusanInstance . ?jurusanInstance silk:nama ?jurusan .
                ?instance silk:lulusan_dari ?universitasInstance . ?universitasInstance silk:nama ?universitas . ?instance silk:jenis_kelamin ?jenis_kelamin
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataSkill = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?skill
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:menguasai ?skillInstance . ?skillInstance silk:nama ?skill .
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataPencapaian = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?pencapaian
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:pencapaian ?pencapaian . 
	            FILTER regex(?username, '$username')}
            "
        );
        foreach ($result as $row) {
            $userData = (object) [
                'username' => $row->username,
                'nama' => $row->nama,
                'biografi' => $row->biografi,
                'no_telepon' => $row->no_telepon,
                'email' => $row->email,
                'tanggal_lahir' => $row->tanggal_lahir,
                'jurusan' => $row->jurusan,
                'universitas' => $row->universitas,
                'jenis_kelamin' => $row->jenis_kelamin
            ];
        }

        global $endpoint;
        $obj = new UserProfileController();
        $dataUniversitas = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?universitas
                WHERE {
                    ?instanceUniversitas rdf:type silk:Universitas . ?instanceUniversitas silk:nama ?universitas .
                }
            "
        );
        $dataJurusan = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?jurusan
                WHERE {
                    ?instanceJurusan rdf:type silk:Jurusan . ?instanceJurusan silk:nama ?jurusan .
                }
            "
        );
        $dataKeahlian = $obj->endpoint->query(
            "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                SELECT ?skill
                WHERE {
                    ?instanceKeahlian rdf:type silk:Keahlian . ?instanceKeahlian silk:nama ?skill .
                }
            "
        );

        // return view('profile')->with('userData', $object);
        return view('updateProfile', compact('userData', 'userDataSkill', 'userDataPencapaian', 'dataUniversitas', 'dataJurusan', 'dataKeahlian'));
    }

    public function update(Request $request)
    {
        $username = Auth::user()->username;
        $userData = $this->userData($username);
        $oldName = $userData->userData->nama;
        $oldPhone = $userData->userData->no_telepon;
        $oldBiografi = $userData->userData->biografi;

        $oldMajorString = $userData->userData->jurusan;
        $oldMajor = str_replace(' ', '_', $oldMajorString);
        $oldUniversitasString = $userData->userData->universitas;
        $oldUniversitas = str_replace(' ', '_', $oldUniversitasString);

        $oldSkill = $userData->userDataSkill;
        $oldAchievment = $userData->userDataPencapaian;

        $newName = $request->name;
        $newPhone = $request->newPhone;
        $newBiografi = $request->newBiography;

        $newMajorString = $request->newMajor;
        $newMajor = str_replace(' ', '_', $newMajorString);
        $newUniversitasString = $request->newUniversitas;
        $newUniversitas = str_replace(' ', '_', $newUniversitasString);


        $newSkill = $request->newSkill;
        $newAchievment = $request->newAchievment;

        $user = Auth::user();
        $user->name = $newName;
        $user->phone = $newPhone;

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit', ['id' => $user->id])
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
                <http://www.silk.com#$username> silk:nama '$oldName' .
                <http://www.silk.com#$username> silk:no_telepon '$oldPhone' .
                <http://www.silk.com#$username> silk:biografi '$oldBiografi' .
                <http://www.silk.com#$username> silk:mengambil <http://www.silk.com#$oldMajor> .
                <http://www.silk.com#$username> silk:lulusan_dari <http://www.silk.com#$oldUniversitas> .
            };

            INSERT DATA{
                <http://www.silk.com#$username> silk:nama '$newName' .
                <http://www.silk.com#$username> silk:no_telepon '$newPhone' .
                <http://www.silk.com#$username> silk:biografi '$newBiografi' .
                <http://www.silk.com#$username> silk:mengambil <http://www.silk.com#$newMajor> .
                <http://www.silk.com#$username> silk:lulusan_dari <http://www.silk.com#$newUniversitas> .
            }
            "
        );

        foreach ($oldSkill as $row) {
            $skill = $row->skill;
            global $endpoint;
            $obj = new UserProfileController();
            $result = $obj->endpoint->update(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                DELETE DATA{
                    <http://www.silk.com#$username> silk:menguasai <http://www.silk.com#$skill>
                }
                "
            );
        }

        foreach ($oldSkill as $row) {
            $skill = $row->skill;
            global $endpoint;
            $obj = new UserProfileController();
            $result = $obj->endpoint->update(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                DELETE DATA{
                    <http://www.silk.com#$username> silk:menguasai <http://www.silk.com#$skill>
                }
                "
            );
        }

        foreach ($newSkill as $field_value) {
            $skillString = var_dump($newSkill);
            $skillValue = str_replace(' ', '_', $field_value);
            $checkSkill = $obj->endpoint->query(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                ASK WHERE { FILTER NOT EXISTS { ?skill rdf:type silk:Keahlian . FILTER(?skill=<http://www.silk.com#$skillValue>)} }
                "
            );

            if ($checkSkill->isTrue()) {
                $result2 = $obj->endpoint->update(
                    "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                        INSERT DATA
                            { 
                            silk:$skillValue rdf:type silk:Keahlian .   
                            silk:$skillValue silk:nama '$field_value' .
                            silk:$username silk:menguasai silk:$skillValue .   
                            }
                    "
                );
            } else {
                $result2 = $obj->endpoint->update(
                    "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                        INSERT DATA
                            { 
                            silk:$username silk:menguasai silk:$skillValue .   
                            }
                    "
                );
            }
            $skillString = null;
        }

        foreach ($oldAchievment as $row) {
            $pencapaian = $row->pencapaian;
            global $endpoint;
            $obj = new UserProfileController();
            $result = $obj->endpoint->update(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                DELETE DATA{
                    <http://www.silk.com#$username> silk:pencapaian '$pencapaian' .
                }
                "
            );
        }

        foreach ($newAchievment as $field_value) {
            $achievmentString = var_dump($newAchievment);

            $result2 = $obj->endpoint->update(
                "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                        INSERT DATA
                            { 
                            silk:$username silk:pencapaian '$field_value' .   
                            }
                    "
            );

            $achievmentString = null;
        }

        $user->save();

        return redirect()->route('profile', ['username' => $user->username]);
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
            return redirect()->route('profile', ['username' => $user->username])
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

        return redirect()->route('profile', ['username' => $user->username]);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {

        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return redirect()->route('profile', ['username' => $request->user()->username])->withInput(['tab' => 'v-pills-change-password']);
    }
}
