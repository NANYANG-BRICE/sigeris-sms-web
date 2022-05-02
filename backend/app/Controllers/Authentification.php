<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdministrateurModel;

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




    public function authentification()
    {
        $model_admin = new AdministrateurModel();
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_username'   => ['label' => 'Username',  'rules' => 'trim|required|min_length[6]|max_length[25]'],
            'admin_password'   => ['label' => 'Password',  'rules' => 'trim|required|min_length[6]|max_length[100]'],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data);
        }
        else{
            $admin_username = $this->request->getVar('admin_username');
            $admin_password = $this->request->getVar('admin_password');
            $array = $model_admin->where('admin_username', $admin_username)->first();

            if ($array) {
                $session = session();
                $password = $array['admin_password'];
                $authenticate_password = $this->verify_password($password, $admin_password);

                if ($authenticate_password == true) {
                    $data = [
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
                        'admin_code_activation' => $array['admin_code_activation'],
                        'logged_in'         => true
                    ];

                    $json = $this->request->getJSON();
                    return $this->respond($data, 200);
                }
                else{
                    return $this->failNotFound('Désolé mais votre password est incorrecte !');
                }
            } 
            else{
                return $this->failNotFound('Désolé mais vos Informations sont incorrectes !');
            }
        }
    }




   public function recover_password()
   {
       $model_admin = new AdministrateurModel();
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_username'    => ['label' => 'Username',  'rules' => 'trim|required|min_length[6]|max_length[25]'],
            'admin_email'       => ['label' => 'Email',  'rules' => 'trim|required|valid_email'],
            'admin_password'    => [ 'label' => 'Password',   'rules' => 'trim|required|min_length[6]|max_length[30]' ],
            'admin_type'        => [ 'label' => 'Type',   'rules' => 'trim|required' ],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data);
        }

        else{
            $admin_username = $this->request->getVar('admin_username');
            $admin_email    = $this->request->getVar('admin_email');
            $admin_type     = $this->request->getVar('admin_type');

            if ($admin_type == 'Administrateur') {
                $array = $model_admin->where('admin_username', $admin_username)->first();

                if ($array) {
                    $token      = $array['admin_email'];
                    $id_admin   = $array['id_admin'];
                    $authenticate_token = $this->verify_password($token, $admin_email);

                    if ($authenticate_token == true) {
                       $json = $this->request->getJSON();
                       $data = [
                            'admin_password'  => $json->admin_password,
                            'admin_update_as' => date('Y-m-d H:i:s')
                        ];

                        $model_admin = new AdministrateurModel();
                        $find = $model_admin->find(['id_admin' => $id_admin]);

                        if (!$find) {
                            return $this->fail('Aucune donnée trouvée', 404);
                        } else {
                            $administrateur = $model_admin->update($id_admin, $data);
                        }

                        if (!$administrateur) {
                            return $this->fail('Echec survenue durant la modification', 400);
                        } else {
                            return $this->respond($administrateur);
                        }
                    }
                    else{
                        return $this->failNotFound('Désolé mais votre token est incorrecte !');
                    }
                } 
                else{
                    return $this->failNotFound('Désolé mais vos Informations sont incorrectes !');
                }
            }
        }             
   }



   public function activate_account()
   {
       $model_admin = new AdministrateurModel();
        helper(['form', 'url']);
        $conditions_validations = [
            'matricule'     => ['label' => 'Matricule',  'rules' => 'trim|required|min_length[19]|max_length[19]'],
            'token'         => ['label' => 'Token',  'rules' => 'trim|required|min_length[25]|max_length[60]'],
            'password'      => ['label' => 'Password',  'rules' => 'trim|required|min_length[6]|max_length[100]'],
            'type'          => ['label' => "Type d'utilisateur",  'rules' => 'trim|required'],
        ];


        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
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
                    $key        = $array['admin_password'];
                    $$id_admin  = $array['$id_admin'];
                    $authenticate_password = $this->verify_password($password, $admin_password);

                    if ($authenticate_password == true) {
                        $data = [
                            'admin_statut'      => 'actif',
                            'admin_activate_at' => date('Y-m-d H:i:s')
                        ];

                        $model_admin = new AdministrateurModel();
                        $find = $model_admin->find(['id_admin' => $id_admin]);

                        if (!$find) {
                            return $this->fail('Aucune donnée trouvée', 404);
                        } else {
                            $administrateur = $model_admin->update($id_admin, $data);
                        }

                        if (!$administrateur) {
                            return $this->fail('Echec survenue durant l\'activation du compte', 400);
                        } else {
                            return $this->respond($administrateur);
                        }
                    }
                    else{
                        return $this->failNotFound('Désolé mais votre password est incorrecte !');
                    }
                }
                else{
                    return $this->failNotFound('Désolé mais vos Informations sont incorrectes !');
                }
            }
                
        }
   }
}