<?php

namespace App\Controllers;
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EnseignantModel;

class Enseignants extends ResourceController {
    use ResponseTrait;



    /* listede tous les enseignants */
    public function select_all_teachers()
    {
        $model_enseignant   = new EnseignantModel();
        $data['actif']      = $model_enseignant->where(['enseignant_statut' => 'actif'])->findAll();
        $data['latent']     = $model_enseignant->where(['enseignant_statut' => 'latent'])->findAll();
        $data['inactif']    = $model_enseignant->where(['enseignant_statut' => 'inactif'])->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    /* liste d'un seul enseignants */
    public function select_one_teacher($id_enseignant = null)
    {
        $model_enseignant   = new EnseignantModel();
        $data               = $model_enseignant->find(['id_enseignant' => $id_enseignant]);
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant avec cet identifiant dans la base de données');
        } else {
            return $this->respond($data[0]);
        }
    }


    /* enregistrement d'un seulenseignant */
    public function create_one_new_teacher()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'enseignant_email_adress'     => [
                'label' => 'Email',  
                'rules' => 'required|is_unique[enseignant.enseignant_email_adress]|valid_email'
            ],

            'enseignant_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[enseignant.admin_contact1]|is_unique[enseignant.admin_contact2]|min_length[15]'
            ],

            'enseignant_privileges'         => [
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
                'alert'     => "Echec survenue durant l'enregistrement de cet enseignant ",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();
            $data = [
                'enseignant_matricule'          => generate_matricule(),
                'enseignant_firstname'          => $json->enseignant_firstname,
                'enseignant_lastname'           => $json->enseignant_lastname,
                'enseignant_contact1'           => $json->enseignant_contact1,
                'enseignant_contact2'           => $json->enseignant_contact2,
                'enseignant_email_adress'       => $json->enseignant_email_adress,
                'enseignant_privileges'         => $json->enseignant_privileges,
                'enseignant_statut'             => 'latent',
                'enseignant_token'              => generer_token(),
                'enseignant_code_activation'    => generer_code_activation(),
                'enseignant_create_as'          => date('Y-m-d H:i:s')
            ];
            
            $model_enseignant   = new EnseignantModel();
            $enseignant         = $model_enseignant->insert($data);
            $enseignant_name    = $data['enseignant_lastname']." ".$data['enseignant_firstname'];
            if ($enseignant) {
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations l'enseignant ".$enseignant_name." a été correctement enregistré.",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } else {
                $data = [
                    'status'    => 400,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Impossible d'enregistrer l'enseignant ".$enseignant_name.".",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* mise à jours des informations d'un enseignant */
    public function update_specify_teacher()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'enseignant_email_adress'     => [
                'label' => 'Email',  
                'rules' => 'required|valid_email'
            ],

            'enseignant_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[enseignant.admin_contact2]|min_length[15]'
            ],

            'enseignant_privileges'         => [
                'label' => 'Privilèges', 
                'rules' => 'required'
            ]
        ];

        $enseignant_name    = $this->request->getVar('enseignant_lastname')." ".$this->request->getVar('enseignant_firstname');

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Echec survenue durant la modification des données de l'enseignant ".$enseignant_name,
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();

            $data = [
                'id_enseignant'                 => $json->id_enseignant,
                'enseignant_firstname'          => $json->enseignant_firstname,
                'enseignant_lastname'           => $json->enseignant_lastname,
                'enseignant_contact1'           => $json->enseignant_contact1,
                'enseignant_contact2'           => $json->enseignant_contact2,
                'enseignant_email_adress'       => $json->enseignant_email_adress,
                'enseignant_privileges'         => $json->enseignant_privileges,
                'enseignant_update_as'          => date('Y-m-d H:i:s')
            ];
            
            $enseignant_name    = $data['enseignant_lastname']." ".$data['enseignant_firstname'];
            $model_enseignant   = new EnseignantModel();
            $find               = $model_enseignant->find(['id_enseignant' => $data['id_enseignant'] ]);

            if (!$find) 
            {
                $data = [
                    'status'    => 400,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Désolé mais, ils semblerait que les informations de l'enseignant ".$enseignant_name." sont incorrectes",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } 
            else 
            {
                $enseignant = $model_enseignant->update($data['id_enseignant'], $data);
                $data = [
                    'status'    => 200,
                    'error'     => false,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations les données de l'enseignant ".$enseignant_name." ont été modifiées avec succès",
                    'msg'       => $this->validator->getErrors(),
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



    /* désactivation du compte d'un enseignant */
    public function desable_teacher($id_enseignant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'     => 'inactif',
            'enseignant_delete_as'  => date('Y-m-d H:i:s')
        ];

        $model_enseignant   = new EnseignantModel();
        $find               = $model_enseignant->find(['id_enseignant' => $id_enseignant]);

        if (!$find) {
            $data = [
                'status'    => 400,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Impossible de désactiver cet enseignant .",
                'msg'       => "",
                'data'      => []
            ];
            return $this->respondCreated($data);
        } 
        else {
            $enseignant = $model_enseignant->update($id_enseignant, $data);
            if (!$enseignant) {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Echec survenue durant la modification des données de l'enseignant .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } else {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations le compte de l'enseignant a bien été désactiver .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }      
    }



        
    /* réactivation du compte d'un enseignant */
    public function enable_enseignant($id_enseignant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'     => 'actif',
            'enseignant_update_as'  => date('Y-m-d H:i:s')
        ];

        $model_enseignant   = new EnseignantModel();
        $find               = $model_enseignant->find(['id_enseignant' => $id_enseignant]);

        if (!$find) {
            $data = [
                'status'    => 400,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Impossible de réactiver cet enseignant .",
                'msg'       => "",
                'data'      => []
            ];
            return $this->respondCreated($data);
        } 
        else {
            $enseignant = $model_enseignant->update($id_enseignant, $data);
            if (!$enseignant) {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Echec survenue durant la réactivation du compte de l'enseignant .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } else {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations le compte de l'enseignant a bien été réactivé .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



        
    /* suppression du compte d'un enseignant */
    public function delete_enseignant($id_enseignant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'enseignant_statut'     => 'latent',
            'enseignant_update_as'  => date('Y-m-d H:i:s')
        ];

        $model_enseignant   = new EnseignantModel();
        $find               = $model_enseignant->find(['id_enseignant' => $id_enseignant]);

        if (!$find) {
            $data = [
                'status'    => 400,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Impossible de supprimer cet enseignant .",
                'msg'       => "",
                'data'      => []
            ];
            return $this->respondCreated($data);
        } 
        else {
            $enseignant = $model_enseignant->update($id_enseignant, $data);
            if (!$enseignant) {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "error",
                    'title'     => "Erreur !",
                    'timer'     =>  30000,
                    'alert'     => "Echec survenue durant la suppresion du compte de l'enseignant .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            } else {
                $data = [
                    'status'    => 500,
                    'error'     => true,
                    'icon'      => "success",
                    'title'     => "Félicitations !",
                    'timer'     =>  30000,
                    'alert'     => "Félicitations le compte de l'enseignant a bien été supprimé .",
                    'msg'       => "",
                    'data'      => []
                ];
                return $this->respondCreated($data);
            }
        }
    }



        
    /* fonction pour compter les enseignants */
    public function select_count_teacher()
    {
        $model_enseignant   = new EnseignantModel();
        $data['actif']      = count($model_admin->where(['enseignant_statut' => 'actif'])->findAll());
        $data['latent']     = count($model_admin->where(['enseignant_statut' => 'latent'])->findAll());
        $data['inactif']    = count($model_admin->where(['enseignant_statut' => 'inactif'])->findAll());
        
        if (!$data) {
            return $this->failNotFound('Aucun enseignant dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



    /* mise à jours des informations relative au profile d'un enseignant */
    public function update_profile_teacher()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'enseignant_email_adress'     => [
                'label' => 'Email',  
                'rules' => 'required|valid_email'
            ],

            'enseignant_firstname'    => [
                'label' => 'First Name',
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'required|min_length[5]|max_length[100]'
            ],

            'enseignant_contact1'         => [
                'label' => 'Contact Orange', 
                'rules' => 'required|is_unique[enseignant.admin_contact2]|min_length[15]'
            ],

            'enseignant_privileges'         => [
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
                'alert'     => "Echec survenue durant la mise à jours de vos données. ",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();

            $data = [
                'id_enseignant'             => $json->id_enseignant,
                'enseignant_username'       => $json->enseignant_username,
                'enseignant_password'       => $json->enseignant_password,
                'enseignant_firstname'      => $json->enseignant_firstname,
                'enseignant_lastname'       => $json->enseignant_lastname,
                'enseignant_contact1'       => $json->enseignant_contact1,
                'enseignant_contact2'       => $json->enseignant_contact2,
                'enseignant_email_adress'   => $json->enseignant_email_adress,
                'enseignant_description'    => $json->enseignant_description,
                'enseignant_update_as'      => date('Y-m-d H:i:s')
            ];
            
            $model_admin    = new EnseignantModel();
            $id_enseignant  = $data['id_enseignant'];
            $find           = $model_admin->find(['id_enseignant' => $data['id_enseignant'] ]);

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
                $enseignant = $model_admin->update($id_enseignant, $data);
                if (!$enseignant) {
                    $data = [
                        'status'    => 500,
                        'error'     => true,
                        'icon'      => "error",
                        'title'     => "Erreur !",
                        'timer'     =>  30000,
                        'alert'     => "Echec survenue durant la mise à jours de votre profil.",
                        'msg'       => "",
                        'data'      => []
                    ];
                    return $this->respondCreated($data);
                } else {
                    $data = [
                        'status'    => 500,
                        'error'     => true,
                        'icon'      => "success",
                        'title'     => "Félicitations !",
                        'timer'     =>  30000,
                        'alert'     => "Félicitations la mise à jours de votre profil est un succès.",
                        'msg'       => "",
                        'data'      => []
                    ];
                    return $this->respondCreated($data);
                }
            }
        }
    }



    public function upload_enseignant_image()
    {   
        helper(['form', 'url']);
        $conditions_validations = [
            'enseignant_picture' => [
                'uploaded[file]',
                'mime_in[enseignant_picture, image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[enseignant_picture, 6144]',
            ]
        ];

        if (!$this->validate($conditions_validations)){
            $data = [
                'status'    => 500,
                'error'     => true,
                'icon'      => "error",
                'title'     => "Erreur !",
                'timer'     =>  30000,
                'alert'     => "Veillez selectionner une image valide. ",
                'msg'       => $this->validator->getErrors(),
                'data'      => []
            ];
            return $this->respondCreated($data);
        }
        else{
            $enseignant_picture = $this->request->getFile('enseignant_picture');
            $enseignant_picture->move(WRITEPATH . 'uploads');
        }



        $msg = 'Please select a valid file';



        if ($validated) {

            $avatar = $this->request->getFile('file');

            $avatar->move(WRITEPATH . 'uploads');



            $data = [



                'name' =>  $avatar->getClientName(),

                'type'  => $avatar->getClientMimeType()

            ];



            $save = $builder->insert($data);

            $msg = 'File has been uploaded';

        }



        return redirect()->to( base_url('public/index.php/form') )->with('msg', $msg);

    }
}
