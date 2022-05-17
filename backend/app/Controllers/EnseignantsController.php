<?php

namespace App\Controllers;
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EnseignantModel;

class Enseignants extends ResourceController {
    use ResponseTrait;



    /* listede tous les enseignants */
    public function select_all_enseignants()
    {
        $model_admin = new EnseignantModel();
        $data['actif'] = $model_admin->where(['enseignant_statut' => 'actif'])->findAll();
        $data['inactif'] = $model_admin->where(['enseignant_statut' => 'inactif'])->findAll();
        $data['latent'] = $model_admin->where(['enseignant_statut' => 'latent'])->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    /* liste d'un seul enseignants */
    public function select_one_enseignant($id_admin = null)
    {
        $model_admin = new EnseignantModel();
        $data = $model_admin->find(['id_admin' => $id_admin]);
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant dans la base de données');
        } else {
            return $this->respond($data[0]);
        }
    }


    /* enregistrement d'un seulenseignant */
    public function create_new_enseignant()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[enseignant.admin_username]|valid_email'
            ],
            'admin_username'     => [
                'label' => 'Nom d\'utilisateur',  
                'rules' => 'required|min_length[8]|is_unique[enseignant.admin_username]'
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
                'rules' => 'required|is_unique[enseignant.admin_contact1]|is_unique[enseignant.admin_contact2]|min_length[15]'
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
                'alert'     => "Echec survenue duant l'enregistrement de l'enseignant ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
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
                'enseignant_statut'          => 'latent',
                'admin_token'           => generer_token(),
                'admin_code_activation' => generer_code_activation(),
                'admin_create_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin = new EnseignantModel();
            $enseignant = $model_admin->insert($data);

            if ($enseignant) {
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations l'enseignant ".$data['admin_lastname']." ".$data['admin_firstname']." a été correctement enregistré.",
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
                    'alert'     => "Impossible d'enregistrer l'enseignant ".$data['admin_lastname']." ".$data['admin_firstname'].".",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* mise à jours des informations d'un enseignant */
    public function update_enseignant()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            
            'admin_email'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[enseignant.admin_username]|valid_email'
            ],
            'admin_username'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[enseignant.admin_username]'
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
                'rules' => 'required|is_unique[enseignant.admin_contact1]|is_unique[enseignant.admin_contact2]|min_length[15]'
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
                'alert'     => "Echec survenue durant la modification des données de l'enseignant ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
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
            
            $model_admin = new EnseignantModel();
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
                $enseignant = $model_admin->update($id_admin, $data);
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations les données de l'enseignant ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname')." ont été modifiées avec succès",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* désactivation du compte d'un enseignant */
    public function desable_enseignant($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'    => 'inactif',
            'admin_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_admin = new EnseignantModel();
        $find = $model_admin->find(['id_admin' => $id_admin]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $enseignant = $model_admin->update($id_admin, $data);
        }
        
        if (!$enseignant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($enseignant);
        }
    }



        
    /* réactivation du compte d'un enseignant */
    public function enable_enseignant($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'    => 'actif',
            'admin_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_admin = new EnseignantModel();
        $find = $model_admin->find(['id_admin' => $id_admin]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $enseignant = $model_admin->update($id_admin, $data);
        }
        
        if (!$enseignant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($enseignant);
        }
    }



        
    /* suppression du compte d'un enseignant */
    public function delete_enseignant($id_admin = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'    => 'latent',
            'admin_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_admin = new EnseignantModel();
        $find = $model_admin->find(['id_admin' => $id_admin]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $enseignant = $model_admin->update($id_admin, $data);
        }
        
        if (!$enseignant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($enseignant);
        }
    }



        
    /* fonction pour compter les enseignants */
    public function select_count_enseignant()
    {
        $model_admin = new EnseignantModel();
        $data['actif']      = count($model_admin->where(['enseignant_statut' => 'actif'])->findAll());
        $data['inactif']    = count($model_admin->where(['enseignant_statut' => 'inactif'])->findAll());
        $data['latent']     = count($model_admin->where(['enseignant_statut' => 'latent'])->findAll());
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



    /* mise à jours des informations relative au profile d'un enseignant */
    public function update_profile_enseignant()
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
                'rules' => 'required|is_unique[enseignant.admin_username]|valid_email'
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
                'rules' => 'required|is_unique[enseignant.admin_contact2]|min_length[15]'
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
                'alert'     => "Echec survenue durant la modification des données de l'enseignant ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname'),
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
                'enseignant_statut'          => $json->enseignant_statut,
                'admin_token'           => $json->admin_token,
                'admin_update_as'       => $json->admin_update_as,
                'admin_privileges'      => $json->admin_privileges,
                'admin_update_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_admin    = new EnseignantModel();
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
                $enseignant = $model_admin->update($id_admin, $data);
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations les données de l'enseignant ".$this->request->getVar('admin_lastname')." ".$this->request->getVar('admin_firstname')." ont été modifiées avec succès",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }
}
