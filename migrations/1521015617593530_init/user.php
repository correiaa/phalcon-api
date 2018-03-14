<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UserMigration_1521015617593530
 */
class UserMigration_1521015617593530 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('user', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'email',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 64,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 32,
                            'after' => 'email'
                        ]
                    ),
                    new Column(
                        'nickname',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'size' => 32,
                            'after' => 'username'
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'nickname'
                        ]
                    ),
                    new Column(
                        'role',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'size' => 256,
                            'after' => 'password'
                        ]
                    ),
                    new Column(
                        'locked_deadline',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "0000-00-00 00:00:00",
                            'size' => 1,
                            'after' => 'role'
                        ]
                    ),
                    new Column(
                        'is_verified_email',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'size' => 4,
                            'after' => 'locked_deadline'
                        ]
                    ),
                    new Column(
                        'is_usable',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'unsigned' => true,
                            'size' => 1,
                            'after' => 'is_verified_email'
                        ]
                    ),
                    new Column(
                        'is_delete',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'unsigned' => true,
                            'size' => 1,
                            'after' => 'is_usable'
                        ]
                    ),
                    new Column(
                        'created_ip',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'size' => 16,
                            'after' => 'is_delete'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "0000-00-00 00:00:00",
                            'size' => 1,
                            'after' => 'created_ip'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "0000-00-00 00:00:00",
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '8',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
