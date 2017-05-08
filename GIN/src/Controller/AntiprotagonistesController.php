<?php
/**
 * G.I.N. Générateur d'idée pour vos nouvelles
 *
 * @author Stéphane ATLANI
 * @copyright Stéphane ATLANI - www.stephaneatlani.com
 * @link      http://www.stephaneatlani.com 
 * @since     0.0.1
 * @license   https://opensource.org/licenses/GPL-3.0 GNU Licence 3
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AntiprotagonistesController extends AppController
{

    /**
     *
     * Liste des antiAntiprotagonistes
     * 
     */
    public function index()
    {
        /* Pour test
        $req = $this->push('znti');
        debug($req);
        $del = $this->delete($req['id']);
        debug($del);
        */    
        $allAntiAntiprotagonistes = $this->get(0);
        $this->set(compact('allAntiAntiprotagonistes', 'allAntiAntiprotagonistes'));
    }

    /**
     * Insert/update un nouveau Antiprotagoniste
     *
     * @param string $value (Nom du Antiprotagoniste)
     * @param int $id (identifiant de l'enregistrement à mettre à jour)
     *
     * @return array requette/id/(true/false) retoune la requette, l'indetifiant d'enregistrement et un boleen
     * 
     */
    public function push($valeur,$id='')
    {
        
        // On supprimer supprimer les eventuelles tags html et on vérifie l'id
        if (h(strip_tags($valeur)) AND (is_int($id) OR empty($id)) ){
            
            // On charge le model dans la variable $AntiprotagonistesTable
            $AntiprotagonistesTable = TableRegistry::get('Antiprotagonistes');

            // L'update
            if($id){ 
                // recupère l'enregistrement via l'id
                $Antiprotagoniste = $AntiprotagonistesTable->get($id);

                //on assigne les valeurs à l'objet
                $Antiprotagoniste->id = $id;
                $Antiprotagoniste->valeur = $valeur;

                // On update l'enregistrement si ok => on revoie l'id et le resultat de la requestte
                // Sinon on renvoie l'erreur
                if ($results['requette'] = $AntiprotagonistesTable->save($Antiprotagoniste)) {
                    $results['etat'] = true;
                    $results['id'] = $Antiprotagoniste->id;
                }else{
                    $results['etat'] = false;
                    $results['requette']['log'] = $Antiprotagoniste->errors();
                }
            }
            else{// insertion de la valeur dans la table
                
                // Ont déclare que c'est un nouveau enregistrement
                $Antiprotagoniste = $AntiprotagonistesTable->newEntity();

                //On assigne les valeurs à l'objet
                $Antiprotagoniste->valeur = $valeur;

                // Si l'insertion est Ok 
                if ($results['requette'] = $AntiprotagonistesTable->save($Antiprotagoniste)) {
                    $results['etat'] = true;
                    $results['id'] = $Antiprotagoniste->id;
                }else{
                    $results['etat'] = false;
                    $results['requette']['log'] = $Antiprotagoniste->errors();
                }

                
            }
            return($results);
        }
        
    }

    /**
     * recupère le nom d'un Antiprotagoniste
     *
     * @param int $id 
     *           -1 : Aucun
     *           0 : All
     *           >0 : Id de l'enregistrement   
     *
     * @return objet
     * 
     */
    public function get($id=-1)
    {
        // On regarde si $id est bien un INT et qu'il est >=0
        if(is_int($id) AND $id>=0){
           if($id==0){
                $req = $this->Antiprotagonistes->find('all');
            }else{
                $req = $this->Antiprotagonistes->findById($id);
            }
            // on execute la requette et on renvoie le résultat
            $results = $req->all();
            return($results);
        }
        return false;   
    }


    /**
     * Supprime un Antiprotagoniste
     *
     * @param int $id (identifiant de l'enregistrement à supprimer)
     *
     * @return boleen
     * 
     */
    public function delete($id)
     {
        debug($id);
        // On vÃ©rifie que Id soit un entier
        if(is_int($id)){
            // On recherche si le rÃ©sultat existe dans la base
            $entity = $this->get($id);
            if(!empty($entity)){
                // On supprime l'entrÃ©e
                $req = $this->Antiprotagonistes->delete($entity->first());
                $results['etat'] = $req;
            }else{
                $results['etat'] = false;
            }
        }  
        else{
            $results['etat'] = false;
        }        return $results;
        
     }

    /**
     * renvoi un Antiprotagoniste aléatoire
     *
     *
     * @return objet protgoniste 
     * 
     */
    public function rand()
    {
        // On compte le nombre d'objets dans la table
        $totalAntiprotagonistes = $this->get(0);
        $countAntiprotagonistes = count($totalAntiprotagonistes);
        $tabAntiprotagonistes = $totalAntiprotagonistes->toArray();
        
        // On execute un rand avec un -1 pour la selection du 0 dans tabAntiprotagonistes
        return($tabAntiprotagonistes[rand(1,$countAntiprotagonistes)-1]);
    }
}
