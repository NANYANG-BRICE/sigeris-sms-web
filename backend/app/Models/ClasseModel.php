<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class ClasseModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'classe';
    protected $primaryKey           = 'id_classe ';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_classe',
        'classe_matricule',
        'classe_reference',
        'classe_filiere ',
        'classe_level',
        'matiere_classe',
        'delegue_classe',
        'delegue_adjouint_classe',
        'classe_sigle',
        'classe_fullname',
        'classe_statut',
        'classe_create_as',
        'classe_update_as',
        'classe_delete_as',
        'classe_delete_by',
        'classe_description'
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