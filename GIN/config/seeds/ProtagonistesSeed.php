<?php
use Migrations\AbstractSeed;

/**
 * Protagonistes seed.
 */
class ProtagonistesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'valeur' => 'Guerrier',
                'created' => '2017-05-08 00:00:00',
                'modified' => '2017-05-08 00:00:00',
            ],
            [
                'id' => '2',
                'valeur' => 'Femme',
                'created' => '2017-05-08 00:00:00',
                'modified' => '2017-05-01 00:00:00',
            ],
        ];

        $table = $this->table('protagonistes');
        $table->insert($data)->save();
    }
}
