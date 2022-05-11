<?php

namespace App\Controllers;
require('FPDF/fpdf.php');
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EtudiantModel;
use App\Models\ClasseModel;

class Etudiants extends ResourceController {
    use ResponseTrait;



        
    public function select_all_students()
    {
        $model_etudiant = new EtudiantModel();
        $data['actif'] = $model_etudiant->where(['etudiant_statut' => 'actif'])->findAll();
        $data['inactif'] = $model_etudiant->where(['etudiant_statut' => 'inactif'])->findAll();
        $data['latent'] = $model_etudiant->where(['etudiant_statut' => 'latent'])->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun étudiant dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    public function select_one_student($id_etudiant = null)
    {
        $model_etudiant = new EtudiantModel();
        $data = $model_etudiant->find(['id_etudiant' => $id_etudiant]);
        
        if (!$data) {
            return $this->failNotFound('Aucun étudiant dans la base de données');
        } else {
            return $this->respond($data[0]);
        }
    }



    public function create_new_student()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'etudiant_email_adress'     => [
                'label' => 'Email étudiant',  
                'rules' => 'trim|required|is_unique[etudiant.etudiant_email_adress]|valid_email'
            ],
            'classe_etudiant'  => [
                'label' => 'Classe de l\'étudiant',  
                'rules' => 'trim|required'
            ],
            'etudiant_firstname'    => [
                'label' => 'Prénom étudiant',
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'etudiant_lastname'     => [
                'label' => 'Nom étudiant', 
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'etudiant_contact1'         => [
                'label' => 'Contact Orange de l\'étudiant', 
                'rules' => 'trim|required|is_unique[etudiant.etudiant_contact1]|is_unique[etudiant.etudiant_contact2]|exact_length[9]'
            ],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data, 400);
        }
        else{
            $json = $this->request->getJSON();
            $data = [
                'admin_matricule'       => generate_matricule(),
                'etudiant_email_adress' => $json->etudiant_email_adress,
                'classe_etudiant'       => $json->classe_etudiant,
                'etudiant_firstname'    => $json->etudiant_firstname,
                'etudiant_lastname'     => $json->etudiant_lastname,
                'etudiant_contact1'     => $json->etudiant_contact1,
                'etudiant_contact2'     => $json->etudiant_contact2,
                'etudiant_statut'       => 'latent',
                'etudiant_token'           => generer_token(),
                'etudiant_code_activation' => generer_code_activation(),
                'etudiant_create_as'       => date('Y-m-d H:i:s')
            ];
            
            $model_etudiant = new EtudiantModel();
            $etudiant = $model_etudiant->insert($data);

            if ($etudiant) {
                return $this->respondCreated($etudiant);
            } else {
                return $this->fail("Impossible d'enregistrer l'étudiant", 400);
            }
        }
    }



        
    public function update_student()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'etudiant_email_adress'     => [
                'label' => 'Email étudiant',  
                'rules' => 'trim|required|valid_email'
            ],
            'classe_etudiant'  => [
                'label' => 'Classe de l\'étudiant',  
                'rules' => 'trim|required'
            ],
            'etudiant_firstname'    => [
                'label' => 'Prénom étudiant',
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'etudiant_lastname'     => [
                'label' => 'Nom étudiant', 
                'rules' => 'trim|required|min_length[5]|max_length[100]'
            ],
            'etudiant_contact1'         => [
                'label' => 'Contact Orange de l\'étudiant', 
                'rules' => 'trim|required|is_unique[etudiant.etudiant_contact2]|exact_length[9]'
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
                'id_etudiant'               => $json->id_etudiant,
                'classe_etudiant'           => $json->classe_etudiant,
                'etudiant_username'         => $json->etudiant_username,
                'etudiant_password'         => $json->etudiant_password,
                'etudiant_firstname'        => $json->etudiant_firstname,
                'etudiant_lastname'         => $json->etudiant_lastname,
                'etudiant_contact1'         => $json->etudiant_contact1,
                'etudiant_contact2'         => $json->etudiant_contact2,
                'etudiant_email_adress'     => $json->etudiant_email_adress,
                'etudiant_privileges'       => $json->etudiant_privileges,
                'etudiant_update_as'        => date('Y-m-d H:i:s'),
            ];
            
            $model_etudiant = new EtudiantModel();
            $find = $model_etudiant->find(['id_etudiant' => $data['id_etudiant'] ]);

            if (!$find) {
                $data["error"] = true;
                return $this->respondCreated($data, 400);
            } else {
                $etudiant = $id_etudiant->update($id_etudiant, $data);
                $data["error"] = false;
                return $this->respondCreated($data, 200);
            }

            if (!$etudiant) {
                return $this->fail('Echec survenue durant la modification', 400);
            } else {
                return $this->respond($etudiant);
            }
        }
    }



        
    public function desable_student($id_etudiant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'etudiant_statut'    => 'inactif',
            'etudiant_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_etudiant = new EtudiantModel();
        $find = $model_etudiant->find(['id_etudiant' => $id_etudiant]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $etudiant = $model_etudiant->update($id_etudiant, $data);
        }
        
        if (!$etudiant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($etudiant);
        }
    }



        
    public function enable_student($id_etudiant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'etudiant_statut'    => 'actif',
            'admin_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_etudiant = new EtudiantModel();
        $find = $model_etudiant->find(['id_etudiant' => $id_etudiant]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $etudiant = $model_etudiant->update($id_etudiant, $data);
        }
        
        if (!$etudiant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($etudiant);
        }
    }



        
    public function delete_student($id_etudiant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'etudiant_statut'    => 'latent',
            'admin_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_etudiant = new EtudiantModel();
        $find = $model_etudiant->find(['id_etudiant' => $id_etudiant]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $etudiant = $model_etudiant->update($id_etudiant, $data);
        }
        
        if (!$etudiant) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($etudiant);
        }
    }



        
    public function custom_count_all_about_students()
    {
        $model_etudiant = new EtudiantModel();
        $data['actif'] = count(
            $model_etudiant->where(['etudiant_statut' => 'actif'])->findAll()
        );

        $data['inactif'] = count(
            $model_etudiant->where(['etudiant_statut' => 'inactif'])->findAll()
        );

        $data['latent'] = count(
            $model_etudiant->where(['etudiant_statut' => 'latent'])->findAll()
        );
        
        if (!$data) {
            return $this->failNotFound('Aucun étudiant dans la base de données');
        } else {
            return $this->respondNoContent($data);
        }
    }



    public function print_pdf_student_list()
    {
        $model_etudiant = new EtudiantModel();
        $data = $model_etudiant->findAll();
    }



    public function print_pdf_student_report()
    {
        
        $model_etudiant = new EtudiantModel();
        $data['actif'] = $model_etudiant->where(['etudiant_statut' => 'actif'])->findAll();
        $data['inactif'] = $model_etudiant->where(['etudiant_statut' => 'inactif'])->findAll();
        $data['latent'] = $model_etudiant->where(['etudiant_statut' => 'latent'])->findAll();
    }
}
