<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdherentsModel;

class AdherentsController extends BaseController
{

    public function Index()
    {
        return view('Index');
    }

    public function Liste()
    {
        $Model = new AdherentsModel();
        $data['Adherents'] = $Model->GetAllAdherent();
        return view('Adherents/ListeAdherents', $data);
    }

    public function Supprimer() {
        $id = $this->request->getPost('IdAdherents');
        $model = new AdherentsModel();

        if ($id) {
            $model->supprimerAdherent($id);
        }

        return redirect()->to('/Adherents')->with('success', 'Adherent supprimé avec succès');
    }

    public function create() {
        return view('Adherents/AjouterAdherent');
    }
        
    public function Ajouter() {
        $Model = new AdherentsModel();
        $data = [
            'Nom' => $this->request->getPost('Nom'),
            'Prenom' => $this->request->getPost('Prenom'),
            'AdresseMail' => $this->request->getPost('AdresseMail'),
            'NumeroTel' => $this->request->getPost('NumeroTel'),
            'Motdepasse' => $this->request->getPost('Motdepasse'),
            'idAbonnement' => 1,
            'Role' => 0,
        ];
        $Model->save($data);
        return redirect()->to('/Adherents')->with('success', 'Adherent ajouté avec succès');
    }

    public function modifier($id){
        $model = new AdherentsModel();
        $adherent = $model->find($id);
        if(!$adherent){
            return redirect()->to('/Adherents');
        }
        return view('Adherents/ModifierAdherent', ['Adherents' => $adherent]);
    }

    public function update() {
            $model = new AdherentsModel();
            $id = $this->request->getPost('IdAdherents');
            $adherent = $model->find($id);
            if(!$adherent){
                return redirect()->to('/Adherents');
        }

        $data = [
                'Nom' => $this->request->getPost('Nom'),
                'Prenom' => $this->request->getPost('Prenom'),
                'AdresseMail' => $this->request->getPost('AdresseMail'),
                'NumeroTel' => $this->request->getPost('NumeroTel'),
                'Motdepasse' => $this->request->getPost('Motdepasse'),
                'idAbonnement' => $this->request->getPost('idAbonnement'),
            ];

        $model->update($id, $data);
        return redirect()->to('/Adherents');

    }


    public function Profil()
    {
       return view('Adherents/Profil');  
    }

    public function supprimerAdherent($id)
    {
        $db = \Config\Database::connect();

        if (!$id) {
            return false;
        }

        $sql = "EXEC SupprAdherent ?";
        $result = $db->query($sql, [$id]);

        return $result; 
    }


    public function GetAllAdherent()
    {
         $db = \Config\Database::connect();
        $query = $this->$db->query("EXEC GetAllAdherent");
        return $query->getResultArray(); 
    }

}

