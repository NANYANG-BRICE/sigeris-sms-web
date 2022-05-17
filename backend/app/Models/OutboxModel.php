<?php
 
namespace App\Models;

 
use CodeIgniter\Model;
 
class OutboxModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'outbox';
    protected $primaryKey           = 'ID';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'ID',
        'UpdatedInDB',
        'InsertIntoDB',
        'SendingDateTime',
        'SendBefore',
        'SendAfter',
        'Text',
        'DestinationNumber',
        'Coding',
        'UDH',
        'Class',
        'TextDecoded',
        'ID',
        'MultiPart',
        'RelativeValidity',
        'SenderID',
        'SendingTimeOut ',
        'DeliveryReport',
        'CreatorID',
        'Retries',
        'Priority',
        'Status',
        'StatusCode'
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