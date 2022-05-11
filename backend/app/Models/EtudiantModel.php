<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class EtudiantModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'etudiant';
    protected $primaryKey           = 'id_etudiant ';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_etudiant',
        'etudiant_matricule',
        'classe_etudiant',
        'etudiant_username',
        'etudiant_password',
        'etudiant_firstname',
        'etudiant_lastname',
        'etudiant_contact1',
        'etudiant_contact2',
        'etudiant_email_adress',
        'etudiant_privileges',
        'etudiant_statut',
        'etudiant_token',
        'etudiant_code_activation',
        'etudiant_create_as',
        'etudiant_update_as',
        'etudiant_delete_as',
        'etudiant_delete_by',
        'etudiant_description'
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