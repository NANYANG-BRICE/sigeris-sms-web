<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class AdministrateurModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'administrateur';
    protected $primaryKey           = 'id_admin ';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'admin_matricule',
        'admin_username',
        'admin_email',
        'admin_password',
        'admin_firstname',
        'admin_lastname',
        'admin_picture',
        'admin_contact1',
        'admin_contact2',
        'admin_privileges',
        'admin_statut',
        'admin_token',
        'admin_activate_at',
        'admin_code_activation',
        'admin_create_as',
        'admin_update_as',
        'admin_delete_as',
        'admin_delete_by'
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