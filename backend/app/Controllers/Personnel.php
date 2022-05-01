<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PersonnelModel;
// include 'functions/function.php';

class Personnel extends ResourceController {
    use ResponseTrait;

    /* fonction pour générer un token necessaire à un utilisateur */
    public function generer_token() {
        $length = rand(55, 75);
        $caracteres = 'aLABbC0cEd1[eDfç2FghR(²3ij4kYXQl5Um-OPn6%pVq7rJs8*tuW9I+vGw@xHTy&#)K]Z%§!M_S';
        $maxlength = strlen($caracteres);
        $result = '';
        for ($i = 0; $i < $length; $i++){
            $result .= $caracteres[rand(0, $maxlength - 1)];
        }
        return $result;
    }

    /* fonction pour générer un code d'activation pour finaliser son enregistrement */ 
    public function generer_code_activation(){
        $code = rand(100001, 999999);
        return $code;
    }

    /* selectionner les utilisateur dont l'état est actif */
    public function SeletAllUsers() {
        $model_personnel = new PersonnelModel();
        $data = $model_personnel->select('*')->where('user_etat =','actif')->findAll();
        
        if (!$data) {
            return $this->failNotFound('Aucun Utilisateur dans la base de données');
        } else {
            return $this->respond($data);
        }
    }

    /* selectionner un utilisateur dont l'état est actif */
    public function SelectOneUser($id = null) {
        $model_personnel = new PersonnelModel();
        $data = $model_personnel->where('user_etat =','actif')->find(['id' => $id]);
        if (!$data) {
            return $this->failNotFound('Aucun Utilisateur dans la base de données');
        } else {
            return $this->respond($data[0]);
        }
    }
    // 457256 Mme happy

    /* fonction permettant de creer un compte utilisateur */
    // public function CreateUserAccount() {
    //     helper(['form', 'url']);
    //     $conditions_validations = [
    //         'user_username'             => ['label' => 'Username',  'rules' => 'trim|required|min_length[6]|max_length[25]'],
    //         'user_fullname'             => ['label' => 'Fullname',  'rules' => 'trim|required|min_length[6]|max_length[100]'],
    //         'user_password'             => ['label' => 'Password',  'rules' => 'trim|required|min_length[6]|max_length[12]'],
    //         'user_confirm_password'     => ['label' => 'Confirm Password',  'rules' => 'matches[user_password]'],
    //     ];

    //     if (!$this->validate($conditions_validations)){
    //         $data["error"] = true;
    //         $data["msg"] = $this->validator->getErrors();
    //         return $this->respondCreated($data);
    //     }
    //     else{
    //         $json = $this->request->getJSON();
    //         $data = [
    //             'user_matricule'    => $this->genere_matricule($value="personnel"),
    //             'user_username'     => $json->user_username,
    //             'user_fullname'     => $json->user_fullname,
    //             'user_password'     => $json->user_password,
    //         ];
            
    //         $model_personnel = new PersonnelModel();
    //         $personnel = $model_personnel->insert($data);

    //         if ($personnel) {
    //             return $this->respondCreated($personnel);
    //         } else {
    //             return $this->fail('Erreur survenue lors de la création du compte', 400);
    //         }
    //     }
    // }

    /* fonction permettant de creer un nouvel utilisateur*/
    public function CreateUser() {
        helper(['form', 'url']);
        $conditions_validations = [
            'user_checked_decision'    => [
                'label'  => 'Matricule', 
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Je souhaite réellement en registrer cet individus.',
                ],
            ],
            'user_matricule'    => [
                'label' => 'Matricule', 
                'rules' => 'required'
            ],
            'user_username'     => [
                'label' => 'Username',  
                'rules' => 'trim|required|min_length[5]|max_length[20]|is_unique[Personnel.user_username]'
            ],
            'user_password'     => [
                'label' => 'Password',  
                'rules' => 'trim|required|min_length[5]|max_length[30]'
            ],
            'confirm_password'  => [
                'label' => 'Confirm Password',  
                'rules' => 'trim|required|matches[user_password]'
            ],
            'user_firstname'    => [
                'label' => 'First Name',
                'rules' => 'trim|required|min_length[5]|max_length[35]'
            ],
            'user_lastname'     => [
                'label' => 'Last Name', 
                'rules' => 'trim|required|min_length[5]|max_length[35]'
            ],
            'user_type'         => [
                'label' => 'Type User', 
                'rules' => 'trim|required'
            ],

            'user_niveau'       => [
                'label' => 'Niveau',     
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'le niveau est Obligatoire.',
                ],
            ],
            'user_filiere'      => [
                'label' => 'Filière',   
                'rules' => 'trim|required'
            ],
            'user_speciality'   => [
                'label' => 'Spécilalité'
                ,'rules' => 'trim|required'
            ],
            'user_contact1'     => [
                'label' => 'First Contact',
                'rules' => 'trim|required|exact_length[9]|integer|is_unique[Personnel.user_contact1]|is_unique[Personnel.user_contact2]'
            ],
            'user_contact2'     => [
               'label' => 'Last Contact',   
               'rules' => 'trim|required|exact_length[9]|integer|is_unique[Personnel.user_contact1]|is_unique[Personnel.user_contact2]'
           ],
           'user_email'        => [
                'label' => 'Email',  
                'rules' => 'trim|required|valid_email|is_unique[Personnel.user_email]'
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
                'user_matricule'    => $json->user_matricule,
                'user_username'     => $json->user_username,
                'user_password'     => $json->user_password,
                'user_firstname'    => $json->user_firstname,
                'user_lastname'     => $json->user_lastname,
                'user_type'         => $json->user_type,
                'user_picture'      => $json->user_picture,
                'user_niveau'       => $json->user_niveau,
                'user_filiere'      => $json->user_filiere,
                'user_speciality'   => $json->user_speciality,
                'user_grant'        => 1,
                'user_contact1'     => $json->user_contact1,
                'user_contact2'     => $json->user_contact2,
                'user_email'        => $json->user_email,
                'user_etat'         => 'actif',
                'user_create_as'    => date('Y-m-d H:i:s'),
                'user_token'        => $this->generer_token(),
                'user_code_activation' => $this->generer_code_activation(),
            ];
            
            $model_personnel = new PersonnelModel();
            $personnel = $model_personnel->insert($data);

            if ($personnel) {
                return $this->respondCreated($personnel);
            } else {
                return $this->fail('Erreur survenue', 400);
            }
        }
    }

    public function Authentification() {
        helper(['form', 'url']);
        $conditions_validations = [
            'user_username'     => [
                'label' => 'Username',  
                'rules' => 'trim|required|min_length[5]|max_length[60]',
                'errors' => [
                    'required' => 'L\'Username ou L\'email est requis.',
                ],
            ],
            'user_password'     => [
                'label' => 'Password',  
                'rules' => 'trim|required|min_length[5]|max_length[30]'
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
                'user_username'     => $json->user_username,
                'user_password'     => $json->user_password
            ];

            $user_username = $data['user_username'];
            $user_password = $data['user_password'];

            $session = session();
            $model_personnel = new PersonnelModel();
            $table = $model_personnel->where('user_username', $user_username)->find();
        }
    }


    public function UpdateUserEtat($id = null) {
        $json = $this->request->getJSON();
        $data = [
            'user_etat'      => 'inactif',
            'user_delete_as' => date('Y-m-d H:i:s')
        ];
        $model_personnel = new PersonnelModel();
        $find_user_By_Id = $model_personnel->find(['id' => $id]);

        if(!$find_user_By_Id) return $this->fail('Aucune donnée trouvée', 404);
        $personnel = $model_personnel->update($id, $data);
        if(!$personnel) return $this->fail('Modification éffectueé', 400);
        return $this->respond($personnel);
    }

}
