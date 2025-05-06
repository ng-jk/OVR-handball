<?php

namespace App\Models;

use CodeIgniter\Model;

class MatchPlayerModel extends Model
{
    protected $table            = 'matchplayers';
    protected $primaryKey       = 'matchPlayerID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['matchTeamID', 'eventPlayerID', 'matchGoal', 'matchShot', 'matchSave', 'isStartingLineUp', 'totalPerformanceTime', 'assist', 'passClearChance', 'recieve7m', 'recieve2min', 'commit7m', 'commit2min', 'technicalFault', 'steal', 'block', 'deleted_at'];
    protected bool $allowEmptyInserts = true;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
