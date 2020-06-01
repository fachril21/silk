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
            'http://localhost:3030/silk/update'
        );
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
        $username = $data['username'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];


        $status = $data['status'];



        if ($status == 'Pelamar') {

            $birth_date = $data['birth_date'];
            $skill = $data['skill'];
            $major_name = $data['major'];
            $major = str_replace(' ', '_', $major_name);
            $biography = $data['biography'];
            $achievment = $data['achievment'];
            $gender = $data['gender'];

            $user = User::create([
                'status' => $data['status'],
                'username' => $data['username'],
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if (isset($data['avatar'])) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

            global $endpoint;
            $obj = new RegisterController();
            $result = $obj->endpoint->update(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA
                    { 
                    silk:$username rdf:type silk:Pelamar .
                    silk:$username silk:nama_pelamar '$name' .
                    silk:$username silk:username '$username' .
                    silk:$username silk:no_telepon_pelamar '$phone' .
                    silk:$username silk:email '$email' .      
                    silk:$username silk:jenis_kelamin '$gender' .      
                    silk:$username silk:tanggal_lahir '$birth_date' .      
                    silk:$username silk:biografi '$biography' .      
                    }     
                "
            );

            $checkMajor = $obj->endpoint->query(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>

                ASK WHERE { FILTER NOT EXISTS { ?major rdf:type silk:Jurusan . FILTER(?skill=<http://www.silk.com#$major>)} }
                "
            );

            if ($checkMajor->isTrue()) {
                $resultMajor = $obj->endpoint->update(
                    "
                        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX silk: <http://www.silk.com#>
    
                        INSERT DATA
                        { 
                            silk:$major rdf:type silk:Jurusan .   
                            silk:$major silk:major_name '$major_name' .
                            silk:$username silk:lulusan silk:$major .   
                        }
    
                    "
                );
            } else {
                $resultMajor = $obj->endpoint->update(
                    "
                        PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX silk: <http://www.silk.com#>
    
                        INSERT DATA
                        {  
                            silk:$username silk:lulusan silk:$major .   
                        }
    
                    "
                );
            }



            foreach ($skill as $field_value) {
                $skillString = var_dump($skill);
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

            foreach ($achievment as $field_value) {
                $achievmentString = var_dump($achievment);

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
        } elseif ($status == 'Perusahaan') {

            $information = $data['information'];

            $user = User::create([
                'status' => $data['status'],
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            if (isset($data['avatar'])) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

            global $endpoint;
            $obj = new RegisterController();
            $result = $obj->endpoint->update(
                "
                PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX silk: <http://www.silk.com#>
                
                INSERT DATA
                    { 
                    silk:$username rdf:type silk:Perusahaan .
                    silk:$username silk:username '$username' .
                    silk:$username silk:name '$name' .
                    silk:$username silk:phone '$phone' .
                    silk:$username silk:email '$email' .    
                    silk:$username silk:information '$information' .  
                         
                    }     
                "
            );
        }



        return $user;
    }
}
