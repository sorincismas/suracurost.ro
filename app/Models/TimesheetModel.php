<?php

namespace App\Models;

use CodeIgniter\Model;

class TimesheetModel extends Model
{
    protected $table            = 'timesheets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'project_id',
        'start_time',
        'end_time',
        'ore_lucrate',
        'tip_inregistrare',
        'data'
    ];

    // Dates
    // Nu folosim timestamps aici pentru că avem câmpuri specifice
    protected $useTimestamps = false;
}
