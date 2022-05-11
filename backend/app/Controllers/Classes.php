<?php

namespace App\Controllers;
require('FPDF/fpdf.php');
include 'functions/functions.php';
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ClasseModel;

class Classes extends ResourceController {
    use ResponseTrait;



        
    public function select_all_classes()
    {
        $model_classe = new ClasseModel();
        $data['actif'] = $model_classe->where(['classe_statut' => 'actif'])->findAll();
        $data['inactif'] = $model_classe->where(['classe_statut' => 'inactif'])->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucune classe dans la base de données');
        } else {
            return $this->respond($data);
        }
    }



        
    public function select_one_classe($id_classe = null)
    {
        $model_classe = new ClasseModel();
        $data = $model_classe->find(['id_classe' => $id_classe]);
        
        if (!$data) {
            return $this->failNotFound('Aucune classe dans la base de données est representé par cet identifiant');
        } else {
            return $this->respond($data[0]);
        }
    }



    public function create_new_classe()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'matiere_classe'     => [
                'label' => 'Matières classe',  
                'rules' => 'trim|required'
            ],
            'delegue_classe'  => [
                'label' => 'Délégue de Classe',  
                'rules' => 'trim|required'
            ],
            'classe_sigle'    => [
                'label' => 'Sigle de la Classe',
                'rules' => 'trim|required|min_length[3]|max_length[12]'
            ],
            'classe_fullname'     => [
                'label' => 'Nom Classe', 
                'rules' => 'trim|required|min_length[5]|max_length[100]'
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
                'classe_matricule'          => generate_matricule(),
                'classe_reference'          => $json->classe_reference,
                'matiere_classe'            => $json->matiere_classe,
                'delegue_classe'            => $json->delegue_classe,
                'delegue_adjouint_classe'   => $json->delegue_adjouint_classe,
                'classe_sigle'              => $json->classe_sigle,
                'classe_fullname'           => $json->classe_fullname,
                'classe_statut'             => $json->classe_statut,
                'classe_create_as'          => date('Y-m-d H:i:s'),
                'classe_description'        => $json->classe_description
            ];
            
            $model_classe = new ClasseModel();
            $classe = $model_classe->insert($data);

            if ($classe) {
                return $this->respondCreated($classe);
            } else {
                return $this->fail("Impossible d'enregistrer cette classe", 400);
            }
        }
    }



        
    public function update_classe()
    {
        helper(['form', 'url']);
        $conditions_validations = [
            'matiere_classe'     => [
                'label' => 'Matières classe',  
                'rules' => 'trim|required'
            ],
            'classe_filiere'  => [
                'label' => 'Matières classe',  
                'rules' => 'trim|required'
            ],
            'delegue_classe'  => [
                'label' => 'Délégue de Classe',  
                'rules' => 'trim|required'
            ],
            'classe_sigle'    => [
                'label' => 'Sigle de la Classe',
                'rules' => 'trim|required|min_length[3]|max_length[12]|is_unique[classe.classe_sigle]'
            ],
            'classe_fullname' => [
                'label' => 'Nom Classe', 
                'rules' => 'trim|required|min_length[5]|max_length[100]|is_unique[classe.classe_fullname]'
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
                'classe_matricule'          => generate_matricule(),
                'id_classe'                 => $json->id_classe,
                'classe_reference'          => $json->classe_reference,
                'classe_filiere'            => $json->classe_filiere,
                'classe_level'              => $json->classe_level,
                'matiere_classe'            => $json->matiere_classe,
                'delegue_classe'            => $json->delegue_classe,
                'delegue_adjouint_classe'   => $json->delegue_adjouint_classe,
                'classe_sigle'              => $json->classe_sigle,
                'classe_fullname'           => $json->classe_fullname,
                'classe_statut'             => 'actif',
                'classe_update_as'          => date('Y-m-d H:i:s'),
                'classe_description'        => $json->classe_description
            ];
            
            $model_classe = new ClasseModel();
            $find = $model_classe->find(['id_classe' => $data['id_classe'] ]);

            if (!$find) {
                $data["error"] = true;
                return $this->respondCreated($data, 400);
            } else {
                $classe = $id_classe->update($id_classe, $data);
                $data["error"] = false;
                return $this->respondCreated($data, 200);
            }

            if (!$classe) {
                return $this->fail('Echec survenue durant la modification de la classe', 400);
            } else {
                return $this->respond($etudiant);
            }
        }
    }



        
    public function desable_classe($id_classe = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'classe_statut'    => 'inactif',
            'classe_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_classe = new ClasseModel();
        $find = $model_classe->find(['id_classe' => $id_classe]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $classe = $model_classe->update($id_classe, $data);
        }
        
        if (!$classe) {
            return $this->fail('Echec survenue durant la suppresion de la classe', 400);
        } else {
            return $this->respond($classe);
        }
    }



        
    public function enable_classe($id_etudiant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'classe_statut'    => 'actif',
            'classe_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_classe = new ClasseModel();
        $find = $model_classe->find(['id_classe' => $id_classe]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $classe = $model_classe->update($id_etudiant, $data);
        }
        
        if (!$classe) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($classe);
        }
    }



        
    public function delete_student($id_etudiant = null) 
    {
        $json = $this->request->getJSON();
        $data = [
            'classe_statut'    => 'latent',
            'classe_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_classe = new ClasseModel();
        $find = $model_classe->find(['id_classe' => $id_classe]);

        if (!$find) {
            return $this->fail('Aucune donnée trouvée', 404);
        } else {
            $classe = $model_classe->update($id_classe, $data);
        }
        
        if (!$classe) {
            return $this->fail('Echec survenue durant la modification', 400);
        } else {
            return $this->respond($classe);
        }
    }



        
    public function custom_count_all_about_classe()
    {
        $model_classe = new ClasseModel();
        $data['actif'] = count(
            $model_classe->where(['classe_statut' => 'actif'])->findAll()
        );

        $data['inactif'] = count(
            $model_classe->where(['classe_statut' => 'inactif'])->findAll()
        );

        $data['latent'] = count(
            $model_classe->where(['classe_statut' => 'latent'])->findAll()
        );
        
        if (!$data) {
            return $this->failNotFound('Aucun étudiant dans la base de données');
        } else {
            return $this->respondNoContent($data);
        }
    }
}
