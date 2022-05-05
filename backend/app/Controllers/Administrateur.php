<?php

namespace App\Controllers;
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdministrateurModel;

class Administrateur extends ResourceController {
    use ResponseTrait;



        
    public function select_all_administrateur()
    {
        $model_admin = new AdministrateurModel();
        $data = $model_admin->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun administrateur dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    public function select_one_administrateur($id_admin = null)
    {
        $model_admin = new AdministrateurModel();
        $data = $model_admin->find(['id_admin' => $id_admin]);
        
        if (!$data) {
            return $this->failNotFound('Aucun administrateur dans la base de données');
        } else {
            return $this->respond($data[0]);
        }
    }



    public function create_new_administrateur()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_username'     => [
                'label' => 'Username',  
                'rules' => 'trim|required|is_unique[administrateur.admin_username]'
            ],
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'trim|required|is_unique[administrateur.admin_username]|valid_email'
            ],
            'admin_password'  => [
                'label' => 'Password',  
                'rules' => 'trim|required'
            ],
            'admin_firstname'    => [
                'label' => 'First Name',
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'admin_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'admin_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'trim|required|is_unique[administrateur.admin_contact1]|is_unique[administrateur.admin_contact2]|exact_length[9]'
            ],
            'admin_contact2'         => [
                'label' => 'Contact MTN', 
                'rules' => 'trim|required|exact_length[9]|is_unique[administrateur.admin_contact1]|is_unique[administrateur.admin_contact2]'
            ],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();
            if ($json->admin_privileges == '') {
                $json->admin_privileges = 'all';
            }
            
            $data = [
                'admin_matricule'       => generate_matricule(),
                'admin_username'        => $json->admin_username,
                'admin_email'           => $json->admin_email,
                'admin_password'        => $json->admin_password,
                'admin_firstname'       => $json->admin_firstname,
                'admin_lastname'        => $json->admin_lastname,
                'admin_contact1'        => $json->admin_contact1,
                'admin_contact2'        => $json->admin_contact2,
                'admin_privileges'      => $json->admin_privileges,
                'admin_statut'          => 'latent',
                'admin_token'           => generer_token(),
                'admin_code_activation' => generer_code_activation(),
                'admin_create_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin = new AdministrateurModel();
            $administrateur = $model_admin->insert($data);

            if ($administrateur) {
                return $this->respondCreated($administrateur);
            } else {
                return $this->fail("Impossible d'enregistrer l'administrateur", 400);
            }
        }
    }



        
    public function update_administrateur()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_username'     => [
                'label' => 'Username',  
                'rules' => 'trim|required'
            ],
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'trim|required|valid_email'
            ],
            'admin_password'  => [
                'label' => 'Password',  
                'rules' => 'trim|required'
            ],
            'admin_firstname'    => [
                'label' => 'First Name',
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'admin_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'admin_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'trim|required|exact_length[9]'
            ],
            'admin_contact2'         => [
                'label' => 'Contact MTN', 
                'rules' => 'trim|required|exact_length[9]'
            ],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();

            $data = [
                'id_admin'              => $json->id_admin,
                'admin_username'        => $json->admin_username,
                'admin_email'           => $json->admin_email,
                'admin_password'        => $json->admin_password,
                'admin_firstname'       => $json->admin_firstname,
                'admin_lastname'        => $json->admin_lastname,
                'admin_picture'         => $json->admin_picture,
                'admin_contact1'        => $json->admin_contact1,
                'admin_contact2'        => $json->admin_contact2,
                'admin_update_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin = new AdministrateurModel();
            $find = $model_admin->find(['id_admin' => $data['id_admin'] ]);

            if (!$find) {
                $data["error"] = true;
                return $this->respondCreated($data, 400);
            } else {
                $administrateur = $model_admin->update($id_admin, $data);
                $data["error"] = false;
                return $this->respondCreated($data, 200);
            }

            if (!$administrateur) {
                return $this->fail('Echec survenue durant la modification', 400);
            } else {
                return $this->respond($administrateur);
            }
        }
    }



        
    public function desable_administrateur($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'admin_statut'    => 'inactif',
            'admin_delete_as' => date('Y-m-d H:i:s')
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



        
    public function enable_administrateur($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'admin_statut'    => 'actif',
            'admin_delete_as' => date('Y-m-d H:i:s')
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



        
    public function delete_administrateur($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'admin_statut'    => 'latent',
            'admin_delete_as' => date('Y-m-d H:i:s')
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
}
