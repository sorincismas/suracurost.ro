<?php

namespace App\Controllers;

use App\Models\AngajatModel;
use App\Models\FirmaModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class AngajatiController extends Controller
{
    protected $model;
    protected $firmaModel;

    public function __construct()
    {
        $this->model = new AngajatModel();
        $this->firmaModel = new FirmaModel();
    }

    public function index()
    {
        $data['angajati'] = $this->model->select('angajati.*, firme.nume_firma')
                                       ->join('firme', 'firme.id = angajati.id_firma')
                                       ->orderBy('angajati.nume_prenume', 'ASC')
                                       ->findAll();

        return view('angajati/index', $data);
    }

    public function new()
    {
        helper('form');
        $data['firme'] = $this->firmaModel->orderBy('nume_firma', 'ASC')->findAll();
        return view('angajati/form', $data);
    }

    public function create()
    {
        helper('form');

        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()
                           ->withInput()
                           ->with('validation', $this->validator);
        }

        try {
            $this->model->save($this->request->getPost());
            return redirect()->to('/angajati')
                           ->with('message', 'Angajatul a fost adăugat cu succes!')
                           ->with('alert-type', 'success');
        } catch (\Exception $e) {
            log_message('error', '[Error] {exception}', ['exception' => $e]);
            return redirect()->back()
                           ->withInput()
                           ->with('message', 'A apărut o eroare la salvarea datelor. Vă rugăm încercați din nou.')
                           ->with('alert-type', 'danger');
        }
    }

    public function edit($id = null)
    {
        helper('form');
        
        try {
            $data['angajat'] = $this->model->find($id);
            if (empty($data['angajat'])) {
                throw new PageNotFoundException('Nu am putut găsi angajatul cu ID: ' . $id);
            }
            
            $data['firme'] = $this->firmaModel->orderBy('nume_firma', 'ASC')->findAll();
            return view('angajati/form', $data);
        } catch (\Exception $e) {
            return redirect()->to('/angajati')
                           ->with('message', 'Angajatul nu a fost găsit.')
                           ->with('alert-type', 'danger');
        }
    }

    public function update($id = null)
    {
        helper('form');

        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()
                           ->withInput()
                           ->with('validation', $this->validator);
        }

        try {
            if (!$this->model->find($id)) {
                throw new PageNotFoundException('Nu am putut găsi angajatul cu ID: ' . $id);
            }

            $this->model->update($id, $this->request->getPost());
            return redirect()->to('/angajati')
                           ->with('message', 'Angajatul a fost actualizat cu succes!')
                           ->with('alert-type', 'success');
        } catch (\Exception $e) {
            log_message('error', '[Error] {exception}', ['exception' => $e]);
            return redirect()->back()
                           ->withInput()
                           ->with('message', 'A apărut o eroare la actualizarea datelor. Vă rugăm încercați din nou.')
                           ->with('alert-type', 'danger');
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$this->model->find($id)) {
                throw new PageNotFoundException('Nu am putut găsi angajatul cu ID: ' . $id);
            }

            $this->model->delete($id);
            return redirect()->to('/angajati')
                           ->with('message', 'Angajatul a fost șters cu succes!')
                           ->with('alert-type', 'success');
        } catch (\Exception $e) {
            log_message('error', '[Error] {exception}', ['exception' => $e]);
            return redirect()->to('/angajati')
                           ->with('message', 'A apărut o eroare la ștergerea angajatului. Vă rugăm încercați din nou.')
                           ->with('alert-type', 'danger');
        }
    }

    private function getValidationRules()
    {
        return [
            'nume_prenume' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Numele și prenumele sunt obligatorii',
                    'min_length' => 'Numele și prenumele trebuie să aibă cel puțin 3 caractere',
                    'max_length' => 'Numele și prenumele nu pot depăși 100 caractere'
                ]
            ],
            'cnp' => [
                'rules' => 'required|exact_length[13]|numeric',
                'errors' => [
                    'required' => 'CNP-ul este obligatoriu',
                    'exact_length' => 'CNP-ul trebuie să aibă exact 13 caractere',
                    'numeric' => 'CNP-ul trebuie să conțină doar cifre'
                ]
            ],
            'id_firma' => [
                'rules' => 'required|is_natural_no_zero|is_not_unique[firme.id]',
                'errors' => [
                    'required' => 'Firma este obligatorie',
                    'is_natural_no_zero' => 'Vă rugăm selectați o firmă validă',
                    'is_not_unique' => 'Firma selectată nu există în baza de date'
                ]
            ],
            'data_angajarii' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Data angajării este obligatorie',
                    'valid_date' => 'Vă rugăm introduceți o dată validă'
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
            ],
            'functie_departament' => [
                'rules' => 'permit_empty|max_length[100]',
                'errors' => [
                    'max_length' => 'Funcția/Departamentul nu poate depăși 100 caractere'
                ]
            ]
        ];
    }
}
}
