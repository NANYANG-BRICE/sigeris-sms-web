<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdministrateurModel;
use \Firebase\JWT\JWT;

class Authentification extends ResourceController {
    use ResponseTrait;

    public function verify_password($value1, $value2)
    {
        $response = "";
        if ($value1 == $value2) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }




    private function getKey()
    {
        return getenv('JWT_SECRET');
    }




    public function authentification()
    {
        $model_admin = new AdministrateurModel();
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_username'   => [
                'label' => 'Username',  
                'rules' => 'trim|required|min_length[6]|max_length[25]'
            ],

            'admin_password'   => [
                'label' => 'Password',  
                'rules' => 'trim|required|min_length[6]|max_length[100]'
            ],
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Désolé Msr/Mme mais vos données sont abscentes ou incorrectes",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $admin_username = $this->request->getVar('admin_username');
            $admin_password = $this->request->getVar('admin_password');

            $array = $model_admin->where('admin_username', $admin_username)->first();

            if (!empty($array)) {
                $password = $array['admin_password'];
                $authenticate_password = $this->verify_password($password, $admin_password);

                if ($authenticate_password == true) {
                    $key = getenv('JWT_SECRET');
                    $iat = time(); // current timestamp value
                    $nbf = $iat + 100000;
                    $exp = $iat + 360000;

                    $table = [
                        'id_admin' => $array['id_admin'],
                        'admin_matricule'   => $array['admin_matricule'],
                        'admin_username'    => $array['admin_username'],
                        'admin_email'       => $array['admin_email'],
                        'admin_password'    => $array['admin_password'],
                        'admin_firstname'   => $array['admin_firstname'],
                        'admin_lastname'    => $array['admin_lastname'],
                        'admin_picture'     => $array['admin_picture'],
                        'admin_contact1'    => $array['admin_contact1'],
                        'admin_contact2'    => $array['admin_contact2'],
                        'admin_privileges'  => $array['admin_privileges'],
                        'admin_statut'      => $array['admin_statut'],
                        'admin_token'       => $array['admin_token'],
                        'logged_in'         => true,
                    ];

                    $payload = array(
                        "iss"   => "The_claim",
                        "aud"   => "The_Aud",
                        "iat"   => $iat, // issued at
                        "nbf"   => $nbf, //not before in seconds
                        "exp"   => $exp, // expire time in seconds
                        "data"  => $table,
                    );
                    $token = JWT::encode($payload, $key, 'HS256'); 

                    $data = [
                        'status'    => 200,
                        'error'     => false,
                        'icon'      => "success",
                        'title'     => "Félicitations !",
                        'timer'     =>  30000,
                        'alert'     => "Félicitations Msr/Mme".$table['admin_lastname']." ".$table['admin_firstname'].", authentification réussie ",
                        'msg'       => '',
                        'data'      => ['token' => $token]
                    ];
                    return $this->respondCreated($data);
                }
                else{
                    $data = [
                        'status'    => 500,
                        'error'     => true,
                        'icon'      => "error",
                        'title'     => "Erreur !",
                        'timer'     =>  30000,
                        'alert'     => "Désolé Msr/Mme mais votre mot de passe est incorrectes",
                        'msg'       => $this->validator->getErrors(),
                        'data'      => []
                    ];
                    return $this->respondCreated($data);
                }
            }
            else{
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Désolé Msr/Mme mais votre nom d'utilisateur est incorrectes",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }




   public function recover_password()
   {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_matricule'    => [ 
                'label' => 'Token Personnel',   
                'rules' => 'trim|required|min_length[6]' 
            ],

            'admin_email'    => [ 
                'label' => 'Email',   
                'rules' => 'trim|required|min_length[6]' 
            ],

            'admin_password'        => [ 
                'label' => 'Password',   
                'rules' => 'trim|required|min_length[6]|max_length[30]' 
            ],

            'admin_confirm_password'        => [ 
                'label' => 'Confirm Password',   
                'rules' => 'trim|required|matches[admin_password]' 
            ],

            'admin_type'        => [ 
                'label' => 'Type',   
                'rules' => 'trim|required' 
            ],
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  60000,
                'alert'     => "Désolé Msr/Mme mais vos données sont abscentes ou incorrectes",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }

        else{
            $admin_matricule        = $this->request->getVar('admin_matricule');
            $admin_email            = $this->request->getVar('admin_email');
            $admin_type             = $this->request->getVar('admin_type');

            if ($admin_type == 'Administrateur') 
            {
                $model_admin = new AdministrateurModel();
                $array = $model_admin->where('admin_email', $admin_email)->first();

                if ($array) 
                {
                    $id_admin   = $array['id_admin'];
                    $authenticate_token = $this->verify_password($admin_matricule, $array['admin_matricule']);

                    if ($authenticate_token == true) 
                    {
                        $json = $this->request->getJSON();
                        $data = [
                            'admin_password'  => $json->admin_password,
                            'admin_update_as' => date('Y-m-d H:i:s')
                        ];

                        $find = $model_admin->find(['id_admin' => $id_admin]);
                        if (!$find) {
                            $data = [
                                'status'    =>  404,
                                'error'     =>  true,
                                'icon'      =>  "warning",
                                'title'     =>  "Erreur !",
                                'timer'     =>  60000,
                                'alert'     =>  "Désolé mais aucun identifiant existant pour ce compte !",
                                'msg'       =>  "",
                                'data'      =>  []
                            ];
                            return $this->respondCreated($data);
                        } else {
                            
                            $administrateur = $model_admin->update($id_admin, $data);
                            $data = [
                                'status'    =>  200,
                                'error'     =>  false,
                                'icon'      =>  "success",
                                'title'     =>  "Félicitations !",
                                'timer'     =>  60000,
                                'alert'     =>  "Félicitations Msr/Mme ".$array['admin_lastname']." ".$array['admin_firstname'].", votre mot de passe a été modifié avec succès !",
                                'msg'       =>  "",
                                'data'      =>  []
                            ];
                            return $this->respondCreated($data);
                        }
                    }
                    else{
                        $data = [
                            'status'    =>  500,
                            'error'     =>  true,
                            'icon'      =>  "warning",
                            'title'     =>  "Erreur !",
                            'timer'     =>  60000,
                            'alert'     =>  "Désolé mais aucun identifiant existant pour ce compte !",
                            'msg'       =>  "",
                            'data'      =>  []
                        ];
                        return $this->respondCreated($data);
                    }
                } 
                else{
                    $data = [
                        'status'    =>  500,
                        'error'     =>  true,
                        'icon'      =>  "warning",
                        'title'     =>  "Erreur !",
                        'timer'     =>  60000,
                        'alert'     =>  "Désolé mais votre adresse email n'est assoiée à aucun compte !",
                        'msg'       =>  "",
                        'data'      =>  []
                    ];
                    return $this->respondCreated($data);
                }
            }
        }             
   }



   public function activate_account()
   {
       $model_admin = new AdministrateurModel();
        helper(['form', 'url']);
        $conditions_validations = [
            'matricule'     => [
                'label' => 'Matricule',  
                'rules' => 'trim|required|min_length[19]|max_length[19]'
            ],

            'token'         => [
                'label' => 'Token',  
                'rules' => 'trim|required|min_length[25]|max_length[60]'
            ],

            'password'      => [
                'label' => 'Password',  
                'rules' => 'trim|required|min_length[6]|max_length[100]'
            ],

            'type'          => [
                'label' => "Type d'utilisateur",  
                'rules' => 'trim|required'
            ],
        ];


        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  60000,
                'alert'     => "Désolé Msr/Mme mais vos données sont abscentes ou incorrectes",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $type       = $this->request->getVar('types');
            $token      = $this->request->getVar('token');
            $password   = $this->request->getVar('password');
            $matricule  = $this->request->getVar('matricule');

            if ($type == 'Administrateur') {
                $array = $model_admin->where('admin_matricule', $matricule)->where('admin_token', $token)->first();

                if ($array) {
                    $id_admin           = $array['$id_admin'];
                    $admin_password     = $array['admin_password'];
                    $authenticate_password = $this->verify_password($password, $admin_password);

                    if ($authenticate_password == true) {
                        $data = [
                            'admin_statut'      => 'actif',
                            'admin_activate_at' => date('Y-m-d H:i:s')
                        ];

                        $model_admin = new AdministrateurModel();
                        $find = $model_admin->find(['id_admin' => $id_admin]);

                        if (!$find) {
                            $data = [
                                'status'    =>  404,
                                'error'     =>  true,
                                'icon'      =>  "warning",
                                'title'     =>  "Erreur !",
                                'timer'     =>  60000,
                                'alert'     =>  "Désolé mais aucun identifiant existant pour ce compte !",
                                'msg'       =>  "",
                                'data'      =>  []
                            ];
                            return $this->respondCreated($data);
                        } 
                        else {
                            $administrateur = $model_admin->update($id_admin, $data);
                            $data = [
                                'status'    =>  200,
                                'error'     =>  false,
                                'icon'      =>  "success",
                                'title'     =>  "Félicitations !",
                                'timer'     =>  60000,
                                'alert'     =>  "Félicitations Msr/Mme ".$array['admin_lastname']." ".$array['admin_firstname'].", votre compte a bien été initialisé !",
                                'msg'       =>  "",
                                'data'      =>  []
                            ];
                            return $this->respondCreated($data);
                        }
                    }
                    else{
                        $data = [
                            'status'    =>  500,
                            'error'     =>  true,
                            'alert'     =>  "Désolé mais votre mot de passe semble incorrect incorrectes !",
                            'icon'      =>  "error",
                            'title'     =>  "Erreur !",
                            'timer'     =>  60000,
                            'msg'       =>  "",
                            'data'      =>  []
                        ];
                        return $this->respondCreated($data);
                    }
                }
                else{
                    $data = [
                        'status'    => 500,
                        'error'     => true,
                        'alert'     => "Désolé mais Informations sont totalemnt incorrectes veillez les corrigées !",
                        'icon'      =>  "error",
                        'title'     =>  "Erreur !",
                        'timer'     =>  60000,
                        'msg'       =>  "",
                        'data'      =>  []
                    ];
                    return $this->respondCreated($data);
                }
            }
        }
   }
}