<?php

namespace App\Http\Controllers\Auth;

// require 'vendor/autoload.php';



use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use EasyRdf_Sparql_Client;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $endpoint;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->endpoint = new EasyRdf_Sparql_Client(
            'http://localhost:3030/silk/query',
            'http://localhost:3030/silk/update');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'min:11'],
            // 'birth_date' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $skill = $data['skill'];

        global $endpoint;
        $obj = new RegisterController();
        $result = $obj->endpoint->update(
            "
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            PREFIX silk: <http://www.silk.com#>
            
            INSERT DATA
                { 
                silk:$name rdf:type silk:Pelamar .
                silk:$name silk:name '$name' .
                silk:$name silk:phone '$phone' .
                silk:$name silk:email '$email' .      
                }     
            "
        );

        foreach($skill as $field_value){
            $skillString = var_dump($skill);
            $checkSkill = $obj->endpoint->query(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                ASK WHERE { FILTER NOT EXISTS { ?skill rdf:type silk:Keahlian . FILTER(?skill=<http://www.silk.com#$skillString>)} }
                "
            );

            if($checkSkill->isTrue()){
                $result2 = $obj->endpoint->update(
                    "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                        INSERT DATA
                            { 
                            silk:$field_value rdf:type silk:Keahlian .   
                            silk:$name silk:menguasai silk:$field_value .   
                            }
                    "
                );
            }else{
                $result2 = $obj->endpoint->update(
                    "
                    PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX silk: <http://www.silk.com#>
                    
                        INSERT DATA
                            { 
                            silk:$name silk:menguasai silk:$field_value .   
                            }
                    "
                );
            }

            
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'birth_date' => $data['date'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
