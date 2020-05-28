<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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

            SELECT ?username ?nama ?biografi ?no_telepon ?email ?tanggal_lahir ?jurusan ?jenis_kelamin
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:nama_pelamar ?nama . ?instance silk:biografi ?biografi .
                ?instance silk:no_telepon_pelamar ?no_telepon . ?instance silk:email ?email . ?instance silk:tanggal_lahir ?tanggal_lahir . ?instance silk:lulusan ?jurusanInstance . ?jurusanInstance silk:major_name ?jurusan .
                ?instance silk:jenis_kelamin ?jenis_kelamin
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataSkill = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?skill
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:menguasai ?skillInstance . ?skillInstance silk:name ?skill .
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

            SELECT ?username ?nama ?biografi ?no_telepon ?email ?tanggal_lahir ?jurusan ?jenis_kelamin
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:nama_pelamar ?nama . ?instance silk:biografi ?biografi .
                ?instance silk:no_telepon_pelamar ?no_telepon . ?instance silk:email ?email . ?instance silk:tanggal_lahir ?tanggal_lahir . ?instance silk:lulusan ?jurusanInstance . ?jurusanInstance silk:major_name ?jurusan .
                ?instance silk:jenis_kelamin ?jenis_kelamin
	            FILTER regex(?username, '$username')}
            "
        );

        $userDataSkill = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?skill
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:menguasai ?skillInstance . ?skillInstance silk:name ?skill .
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
                'jenis_kelamin' => $row->jenis_kelamin
            ];
        }

        // return view('profile')->with('userData', $object);
        return view('updateProfile', compact('userData', 'userDataSkill', 'userDataPencapaian'));
    }

    public function update(Request $request)
    {
        $username = Auth::user()->username;
        $userData = $this->userData($username);
        $oldName = $userData->userData->nama;
        $oldPhone = $userData->userData->no_telepon;
        $oldBiografi = $userData->userData->biografi;
        $oldMajor = $userData->userData->jurusan;
        $oldSkill = $userData->userDataSkill;
        $oldAchievment = $userData->userDataPencapaian;

        $newName = $request->name;
        $newPhone = $request->newPhone;
        $newBiografi = $request->newBiography;
        $newMajor = $request->newMajor;
        $newSkill = $request->newSkill;
        $newAchievment = $request->newAchievment;

        $user = Auth::user();
        $user->name = $newName;

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
                <http://www.silk.com#$username> silk:nama_pelamar '$oldName' .
                <http://www.silk.com#$username> silk:no_telepon_pelamar '$oldPhone' .
                <http://www.silk.com#$username> silk:biografi '$oldBiografi' .
                <http://www.silk.com#$username> silk:lulusan <http://www.silk.com#$oldMajor> .
            };

            INSERT DATA{
                <http://www.silk.com#$username> silk:nama_pelamar '$newName' .
                <http://www.silk.com#$username> silk:no_telepon_pelamar '$newPhone' .
                <http://www.silk.com#$username> silk:biografi '$newBiografi' .
                <http://www.silk.com#$username> silk:lulusan <http://www.silk.com#$newMajor> .
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
                            silk:$skillValue silk:name '$field_value' .
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
}
