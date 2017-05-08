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
class ProtagonistesController extends AppController
{

    /**
     *
     * Liste des protagonistes
     * 
     */
    public function index()
    {
        $allProtagonistes = $this->get(0);
        $this->set(compact('allProtagonistes', 'allProtagonistes'));
    }


    /**
     * Insert/update un nouveau protagoniste
     *
     * @param string $value (Nom du protagoniste)
     * @param int $id (identifiant de l'enregistrement à mettre à jour)
     *
     * @return array requette/id/(true/false) retoune la requette, l'indetifiant d'enregistrement et un boleen
     * 
     */
    public function push($valeur,$id='')
    {
        
        // On supprimer supprimer les eventuelles tags html et on vérifie l'id
        if (h(strip_tags($valeur)) AND (is_int($id) OR empty($id)) ){
            
            // On charge le model dans la variable $ProtagonistesTable
            $ProtagonistesTable = TableRegistry::get('Protagonistes');

            // L'update
            if($id){ 
                // recupère l'enregistrement via l'id
                $Protagoniste = $ProtagonistesTable->get($id);

                //on assigne les valeurs à l'objet
                $Protagoniste->id = $id;
                $Protagoniste->valeur = $valeur;

                // On update l'enregistrement si ok => on revoie l'id et le resultat de la requestte
                // Sinon on renvoie l'erreur
                if ($results['requette'] = $ProtagonistesTable->save($Protagoniste)) {
                    $results['etat'] = true;
                    $results['id'] = $Protagoniste->id;
                }else{
                    $results['etat'] = false;
                    $results['requette']['log'] = $Protagoniste->errors();
                }
            }
            else{// insertion de la valeur dans la table
                
                // Ont déclare que c'est un nouveau enregistrement
                $Protagoniste = $ProtagonistesTable->newEntity();

                //On assigne les valeurs à l'objet
                $Protagoniste->valeur = $valeur;

                // Si l'insertion est Ok 
                if ($results['requette'] = $ProtagonistesTable->save($Protagoniste)) {
                    $results['etat'] = true;
                    $results['id'] = $Protagoniste->id;
                }else{
                    $results['etat'] = false;
                    $results['requette']['log'] = $Protagoniste->errors();
                }

                
            }
            return($results);
        }
        
    }


    /**
     * recupère le nom d'un protagoniste
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
                $req = $this->Protagonistes->find('all');
            }else{
                $req = $this->Protagonistes->findById($id);
            }
            // on execute la requette et on renvoie le résultat
            $results = $req->all();
            return($results);
        }
        return false;   
    }


    /**
     * Supprime un protagoniste
     *
     * @param int $id (identifiant de l'enregistrement à supprimer)
     *
     * @return boleen
     * 
     */
    public function delete($id='')
    {
        
    }

    /**
     * renvoi un protagoniste aléatoire
     *
     *
     * @return objet protgoniste 
     * 
     */
    public function rand()
    {
        // On compte le nombre d'objets dans la table
        $totalProtagonistes = $this->get(0);
        $countProtagonistes = count($totalProtagonistes);
        $tabProtagonistes = $totalProtagonistes->toArray();
        
        // On execute un rand avec un -1 pour la selection du 0 dans tabProtagonistes
        return($tabProtagonistes[rand(1,$countProtagonistes)-1]);
    }
}
