<?php
namespace App\Model\Table;

use App\Model\Entity\Tweet;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Tweets Model
 *
 */
class TweetsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tweets');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('text', 'create')
            ->notEmpty('text');

        $validator
            ->dateTime('tweeted')
            ->requirePresence('tweeted', 'create')
            ->notEmpty('tweeted');

        return $validator;
    }

    public function afterSaveCommit($event, $entity, $option) {
	$text = $entity->text;
        if (preg_match('/http:\/\/lottegum.jp\/shr\/([kh])([1-6])(00|([ab][a-z])+)/', $text, $m)) {
		$team = $m[1];
                $theme = $m[2];
                $codes = str_split($m[3], 2);
                foreach ($codes as $code) {
var_dump($team.$theme.$code);
                	$analytic = TableRegistry::get('Analytics')->find()->where(['team' => $team, 'theme' => $theme, 'code' => $code])->first();
                        if (!$analytic) {
                        	$analytic = TableRegistry::get('Analytics')->newEntity();
                                $analytic->team = $team;
                                $analytic->theme = $theme;
                                $analytic->code = $code;
                        }
                        $analytic->count += 1;
                        TableRegistry::get('Analytics')->save($analytic);
                 }
	}
    }

}
