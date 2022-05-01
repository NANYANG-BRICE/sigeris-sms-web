<?php  
	
    function genere_user_matricule($value) {
        if ($value == "personnel") {
            $matricule = rand(1111, 9999)."-USERS-".rand(1111, 9999)."-".rand(1, 9).date('Y');
        }
        else if($value == "produit"){
            $matricule = rand(1111, 9999)."-PRODS-".rand(1111, 9999)."-".rand(1, 9).date('Y');
        }
        return $matricule
    }

    /* fonction pour générer un code d'activation pour finaliser son enregistrement */ 
    public function generer_code_activation(){
        $code = rand(100001, 999999);
        return $code;
    }

   /* public function LoginUser() {
        helper(['form', 'url']);
        $conditions_validations = [
            'user_username'     => ['label' => 'Username',  'rules' => 'trim|required|min_length[5]|max_length[12]'],
            'user_password'     => ['label' => 'Password',  'rules' => 'trim|required|min_length[5]|max_length[20]'],
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
            $data = $model_personnel->where('user_username', $user_username)->find();

            if ($data) {
                $password = $data['user_password'];
                $verify_password = $model_personnel->where('user_password', $password)->countAll();
                if($verify_password == 1){
                    $session_data = [
                        'user_type'         => $data['user_type'],
                        'user_grant'        => $data['user_grant'],
                        'user_picture'      => $data['user_picture'],
                        'user_filiere'      => $data['user_filiere'],
                        'user_username'     => $data['user_username'],
                        'user_password'     => $data['user_password'],
                        'user_fullname'     => $data['user_fullname'],
                        'user_contact1'     => $data['user_contact1'],
                        'user_contact2'     => $data['user_contact2'],
                        'user_matricule'    => $data['user_matricule'],
                        'user_speciality'   => $data['user_speciality'],
                        'user_email'        => $data['user_email']
                        'isLoggedIn'        => TRUE
                    ];
                    return $this->respond($session->set($session_data));
                }
                else{data
                    return $this->failNotFound('Données abscentes ou incorrectes');
                }
            }
            else{
                return $this->failNotFound('Données abscentes ou incorrectes');
            }
        }
    }

    public function CreateUserAccount() {
        helper(['form', 'url']);
        $conditions_validations = [
            'user_username'             => ['label' => 'Username',  'rules' => 'trim|required|min_length[6]|max_length[25]'],
            'user_fullname'             => ['label' => 'Fullname',  'rules' => 'trim|required|min_length[6]|max_length[100]'],
            'user_password'             => ['label' => 'Password',  'rules' => 'trim|required|min_length[6]|max_length[12]'],
            'user_confirm_password'     => ['label' => 'Confirm Password',  'rules' => 'matches[user_password]'],
        ];

        if (!$this->validate($conditions_validations)){
            $data["error"] = true;
            $data["msg"] = $this->validator->getErrors();
            return $this->respondCreated($data);
        }
        else{
            $json = $this->request->getJSON();
            $data = [
                'user_matricule'    => $this->genere_matricule($value="personnel"),
                'user_username'     => $json->user_username,
                'user_fullname'     => $json->user_fullname,
                'user_password'     => $json->user_password,
            ];
            
            $model_personnel = new PersonnelModel();
            $personnel = $model_personnel->insert($data);

            if ($personnel) {
                return $this->respondCreated($personnel);
            } else {
                return $this->fail('Erreur survenue lors de la création du compte', 400);
            }
        }
    }

    

    public function CreateUser() {
        helper(['form', 'url']);
        $conditions_validations = [
            'user_matricule'    => ['label' => 'Matricule', 'rules' => 'required'],
            'user_username'     => ['label' => 'Username',  'rules' => 'trim|required|min_length[5]|max_length[12]'],
            'user_password'     => ['label' => 'Password',  'rules' => 'trim|required|min_length[5]|max_length[20]'],
            'user_fullname'     => ['label' => 'Fullname',  'rules' => 'trim|required|min_length[5]|max_length[100]'],
            'user_contact1'     => ['label' => 'Contact',   'rules' => 'trim|required|exact_length[9]|integer'],
            'user_email'        => ['label' => 'Username',  'rules' => 'trim|required|valid_email'],
            'user_type'         => ['label' => 'Type User', 'rules' => 'trim|required'],
            'user_grant'        => ['label' => 'Autorisations', 'rules' => 'trim|required'],
            'confirm_password'  => ['label' => 'Password',  'rules' => 'matches[user_password]'],
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
                'user_fullname'     => $json->user_fullname,
                'user_type'         => $json->user_type,
                'user_picture'      => $json->user_picture,
                'user_filiere'      => $json->user_filiere,
                'user_speciality'   => $json->user_speciality,
                'user_grant'        => $json->user_grant,
                'user_contact1'     => $json->user_contact1,
                'user_contact2'     => $json->user_contact2,
                'user_email'        => $json->user_email,
                'user_etat'         => 'actif',
                'user_create_as'    => date('Y-m-d H:i:s')
            ];
            
            $model_personnel = new PersonnelModel();
            $personnel = $model_personnel->insert($data);

            if ($personnel) {
                return $this->respondCreated($personnel);
            } else {
                return $this->fail('Erreur survenue', 400);
            }
        }
    }*/

?>