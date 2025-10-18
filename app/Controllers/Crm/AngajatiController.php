<?php

namespace App\Controllers\Crm;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AngajatiController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data = [
            'page_title' => 'Lista Angajați',
            'angajati'   => $userModel->findAll()
        ];
        return view('Crm/angajati/index', $data);
    }

    public function form($id = null)
    {
        $userModel = new UserModel();
        $angajat = null;
        if ($id) {
            $angajat = $userModel->find($id);
        }

        $data = [
            'page_title' => $id ? 'Editare Angajat' : 'Adăugare Angajat Nou',
            'angajat'    => $angajat
        ];

        return view('Crm/angajati/form', $data);
    }

    public function save()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id');

        // Regulile de validare
        $rules = [
            'nume'    => 'required|min_length[3]',
            'prenume' => 'required|min_length[3]',
            'email'   => 'required|valid_email|is_unique[users.email,id,' . ($id ?? 0) . ']',
            'rol'     => 'required|in_list[admin,operator]',
            'status'  => 'required|in_list[activ,arhivat]'
        ];

        if (!$this->validate($rules)) {
            // Dacă validarea eșuează, ne întoarcem la formular cu erorile
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nume'    => $this->request->getPost('nume'),
            'prenume' => $this->request->getPost('prenume'),
            'email'   => $this->request->getPost('email'),
            'rol'     => $this->request->getPost('rol'),
            'functie' => $this->request->getPost('functie'),
            'zile_concediu_an' => $this->request->getPost('zile_concediu_an'),
            'status'  => $this->request->getPost('status'),
        ];
        
        $message = $id ? 'Angajat actualizat cu succes.' : 'Angajat adăugat cu succes.';

        if ($userModel->save($data, $id)) {
             return redirect()->to(site_url('angajati'))->with('success', $message);
        } else {
             return redirect()->back()->withInput()->with('error', 'A apărut o eroare la salvare.');
        }
    }
}
