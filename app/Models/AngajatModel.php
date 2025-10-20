<?php

namespace App\Models;

use CodeIgniter\Model;

class AngajatModel extends Model
{
    protected $table = 'angajati';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'id_firma',
        'nume_prenume',
        'cnp',
        'functie_departament',
        'data_angajarii',
        'email',
        'telefon'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $validationRules = [
        'nume_prenume'   => 'required|min_length[3]|max_length[100]',
        'cnp'            => 'required|exact_length[13]',
        'id_firma'       => 'required|is_natural_no_zero',
        'data_angajarii' => 'required|valid_date'
    ];
    
    protected $validationMessages = [
        'nume_prenume' => [
            'required'    => 'Numele și prenumele sunt obligatorii',
            'min_length'  => 'Numele și prenumele trebuie să aibă cel puțin 3 caractere',
            'max_length'  => 'Numele și prenumele nu pot depăși 100 caractere'
        ],
        'cnp' => [
            'required'      => 'CNP-ul este obligatoriu',
            'exact_length' => 'CNP-ul trebuie să aibă exact 13 caractere'
        ],
        'id_firma' => [
            'required'           => 'Firma este obligatorie',
            'is_natural_no_zero' => 'Vă rugăm selectați o firmă validă'
        ],
        'data_angajarii' => [
            'required'    => 'Data angajării este obligatorie',
            'valid_date' => 'Vă rugăm introduceți o dată validă'
        ]
    ];
}
