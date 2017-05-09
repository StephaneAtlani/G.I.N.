<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;


class ParadoxesTable extends Table
{
    
    public function initialize(array $config)
    {
        //Permet de gérer les created et les modified
        $this->addBehavior('Timestamp');
    }

	public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('valeur')
            ->notEmpty('valeur','Vous devez remplir ce champs');

        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
	  $rules->add($rules->isUnique(['valeur'], 'La valeur est déjà inséré'));
	  return $rules;
	}
}

