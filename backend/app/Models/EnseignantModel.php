<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class EnseignantModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'enseignant';
    protected $primaryKey           = 'id_enseignant ';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_enseignant',
        'enseignant_matricule',
        'planing_enseignant',
        'matiere_enseignant ',
        'classe_enseignant',
        'enseignant_username',
        'enseignant_password',
        'enseignant_firstname',
        'enseignant_lastname',
        'enseignant_contact1',
        'enseignant_contact2',
        'enseignant_email_adress',
        'enseignant_privileges',
        'enseignant_statut',
        'enseignant_token',
        'enseignant_code_activation',
        'enseignant_create_as',
        'enseignant_update_as',
        'enseignant_delete_as',
        'enseignant_delete_by',
        'enseignant_description'
    ];
 
    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';
 
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
 
    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
}