<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class PlaningModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'planing';
    protected $primaryKey           = 'id_planing';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_planing',
        'planing_matricule',
        'planing_reference',
        'enseignant_conserner ',
        'classe_conserner',
        'admin_responsable',
        'planing_start_at',
        'planing_lundi',
        'planing_mardi',
        'planing_mercredi',
        'planing_jeudi',
        'planing_vendredi',
        'planing_samedi',
        'planing_end_at',
        'planing_create_as',
        'planing_update_as',
        'planing_delete_as',
        'planing_delete_by'
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