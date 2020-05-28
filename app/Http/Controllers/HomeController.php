<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use EasyRdf_Sparql_Client;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update'
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::all();
        return view('home', compact('user'));
    }

    public function userData()
    {
        $username = Auth::user()->username;
        global $endpoint;
        $obj = new UserProfileController();
        $result = $obj->endpoint->query(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>

            SELECT ?username ?nama ?biografi
            WHERE {?instance rdf:type silk:Pelamar . ?instance silk:username ?username . ?instance silk:nama_pelamar ?nama . ?instance silk:biografi ?biografi
	            FILTER regex(?username, '$username')}
            "
        );
        foreach ($result as $row) {
            $object = (object) ['username' => $row->username , 'nama' => $row->nama, 'biografi' => $row->biografi];
        }
        return view('profile')->with('userData', $object);
    }
}
