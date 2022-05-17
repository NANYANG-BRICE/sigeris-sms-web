<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class MatiereModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'matiere';
    protected $primaryKey           = 'id_matiere ';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_matiere',
        'matiere_matricule',
        'matiere_reference',
        'matiere_sigle ',
        'matiere_fullname',
        'matiere_statut',
        'matiere_create_as',
        'matiere_update_as',
        'matiere_delete_as',
        'matiere_delete_by',
        'matiere_description'
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