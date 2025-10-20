<?php

namespace App\Models;

use CodeIgniter\Model;

class FirmaModel extends Model
{
    protected $table = 'firme';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'nume_firma',
        'cui',
        'adresa',
        'telefon',
        'email'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $validationRules = [
        'nume_firma' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => 'Numele firmei este obligatoriu',
                'min_length' => 'Numele firmei trebuie să aibă cel puțin 3 caractere',
                'max_length' => 'Numele firmei nu poate depăși 100 caractere'
            ]
        ],
        'cui' => [
            'rules' => 'required|min_length[2]|max_length[50]',
            'errors' => [
                'required' => 'CUI-ul este obligatoriu',
                'min_length' => 'CUI-ul trebuie să aibă cel puțin 2 caractere',
                'max_length' => 'CUI-ul nu poate depăși 50 caractere'
            ]
        ],
        'email' => [
            'rules' => 'permit_empty|valid_email|max_length[100]',
            'errors' => [
                'valid_email' => 'Vă rugăm introduceți o adresă de email validă',
                'max_length' => 'Adresa de email nu poate depăși 100 caractere'
            ]
        ],
        'telefon' => [
            'rules' => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'Numărul de telefon nu poate depăși 20 caractere'
            ]
        ]
    ];
}