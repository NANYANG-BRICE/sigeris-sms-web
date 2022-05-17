<?php

namespace App\Controllers;
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AdministrateurModel;

class Administrateur extends ResourceController {
    use ResponseTrait;



    /* listede tous les administrateurs */
    public function select_all_administrateur()
    {
        $model_admin = new AdministrateurModel();
        $data['actif'] = $model_admin->where(['admin_statut' => 'actif'])->findAll();
        $data['inactif'] = $model_admin->where(['admin_statut' => 'inactif'])->findAll();
        $data['latent'] = $model_admin->where(['admin_statut' => 'latent'])->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun administrateur dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    /* liste d'un seul administrateurs */
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


    /* enregistrement d'un seuladministrateur */
    public function create_new_administrateur()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[administrateur.admin_username]|valid_email'
            ],
            'admin_username'     => [
                'label' => 'Nom d\'utilisateur',  
                'rules' => 'required|min_length[8]|is_unique[administrateur.admin_username]'
            ],
            'admin_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[administrateur.admin_contact1]|is_unique[administrateur.admin_contact2]|min_length[15]'
            ],
            'admin_privileges'         => [
                'label' => 'Privilèges', 
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Echec survenue duant l'enregistrement de l'administrateur ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();
            $data = [
                'admin_matricule'       => generate_matricule(),
                'admin_firstname'       => $json->admin_firstname,
                'admin_lastname'        => $json->admin_lastname,
                'admin_contact1'        => $json->admin_contact1,
                'admin_contact2'        => $json->admin_contact2,
                'admin_username'        => $json->admin_username,
                'admin_email'           => $json->admin_email,
                'admin_privileges'      => $json->admin_privileges,
                'admin_statut'          => 'latent',
                'admin_token'           => generer_token(),
                'admin_code_activation' => generer_code_activation(),
                'admin_create_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin = new AdministrateurModel();
            $administrateur = $model_admin->insert($data);

            if ($administrateur) {
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations l'administrateur ".$data['admin_lastname']." ".$data['admin_firstname']." a été correctement enregistré.",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } else {
                $data = [
                    'status'    => 400,
                    'error'     => true,
                    'icon'      => "success",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Impossible d'enregistrer l'administrateur ".$data['admin_lastname']." ".$data['admin_firstname'].".",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* mise à jours des informations d'un administrateur */
    public function update_administrateur()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[administrateur.admin_username]|valid_email'
            ],
            'admin_username'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[administrateur.admin_username]'
            ],
            'admin_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[administrateur.admin_contact1]|is_unique[administrateur.admin_contact2]|min_length[15]'
            ],
            'admin_privileges'         => [
                'label' => 'Privilèges', 
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Echec survenue durant la modification des données de l'administrateur ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();

            $data = [
                'id_admin'              => $json->id_admin,
                'admin_firstname'       => $json->admin_firstname,
                'admin_lastname'        => $json->admin_lastname,
                'admin_contact1'        => $json->admin_contact1,
                'admin_contact2'        => $json->admin_contact2,
                'admin_username'        => $json->admin_username,
                'admin_email'           => $json->admin_email,
                'admin_privileges'      => $json->admin_privileges,
                'admin_update_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin = new AdministrateurModel();
            $find = $model_admin->find(['id_admin' => $data['id_admin'] ]);

            if (!$find) 
            {
                $data = [
                    'status'    => 400,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Désolé Msr/Mme mais, ils semblerait que vos informations sont incorrectes",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } 
            else 
            {
                $administrateur = $model_admin->update($id_admin, $data);
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations les données de l'administrateur ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname')." ont été modifiées avec succès",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* désactivation du compte d'un administrateur */
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



        
    /* réactivation du compte d'un administrateur */
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



        
    /* suppression du compte d'un administrateur */
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



        
    /* fonction pour compter les administrateurs */
    public function select_count_administrateur()
    {
        $model_admin = new AdministrateurModel();
        $data['actif']      = count($model_admin->where(['admin_statut' => 'actif'])->findAll());
        $data['inactif']    = count($model_admin->where(['admin_statut' => 'inactif'])->findAll());
        $data['latent']     = count($model_admin->where(['admin_statut' => 'latent'])->findAll());
        
        if (!$data) {
            return $this->failNotFound('Aucun administrateur dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



    /* mise à jours des informations relative au profile d'un administrateur */
    public function update_profile_administrateur()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_matricule'     => [
                'label' => 'Matricule',  
                'rules' => 'required|min_length[16] '
            ],
            'admin_username'     => [
                'label' => 'Nom d\'utilisation',  
                'rules' => 'required|min_length[8]'
            ],
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'required|valid_email|min_length[8]'
            ],
            'admin_password'     => [
                'label' => 'Password',  
                'rules' => 'required|is_unique[administrateur.admin_username]|valid_email'
            ],
            'admin_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],
            'admin_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[administrateur.admin_contact2]|min_length[15]'
            ],
            'admin_privileges'         => [
                'label' => 'Privilèges', 
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Echec survenue durant la modification des données de l'administrateur ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();

            $data = [
                'id_admin'              => $json->id_admin,
                'admin_matricule'       => $json->admin_matricule,
                'admin_username'        => $json->admin_username,
                'admin_email'           => $json->admin_email,
                'admin_password'        => $json->admin_password,
                'admin_firstname'       => $json->admin_firstname,
                'admin_lastname'        => $json->admin_lastname,
                'admin_contact1'        => $json->admin_contact1,
                'admin_contact2'        => $json->admin_contact2,
                'admin_privileges'      => $json->admin_privileges,
                'admin_statut'          => $json->admin_statut,
                'admin_token'           => $json->admin_token,
                'admin_update_as'       => $json->admin_update_as,
                'admin_privileges'      => $json->admin_privileges,
                'admin_update_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin    = new AdministrateurModel();
            $id_admin       = $data['id_admin'];
            $find           = $model_admin->find(['id_admin' => $data['id_admin'] ]);

            if (!$find) 
            {
                $data = [
                    'status'    => 400,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Désolé Msr/Mme mais, ils semblerait que vos informations sont incorrectes",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } 
            else 
            {
                $administrateur = $model_admin->update($id_admin, $data);
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations les données de l'administrateur ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname')." ont été modifiées avec succès",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }
}
