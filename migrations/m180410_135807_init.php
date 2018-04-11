<?php

use yii\db\Migration;

/**
 * Создание необходимых таблиц и добавление данных
 */
class m180410_135807_init extends Migration
{
    public function safeUp()
    {
        $this->execute('
            CREATE TABLE `users` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `balance` decimal(10,2) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
            CREATE TABLE `comments` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(10) unsigned NOT NULL,
              `text` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ');

        $this->batchInsert('users', ['name', 'balance'], [
            ['Petya', 0],
            ['Vasya', 10.2]
        ]);

        $this->batchInsert('comments', ['user_id', 'text'], [
            [1, 'msg1'],
            [2, 'msg2'],
            [2, 'msg3'],
            [1, 'msg4'],
            [1, 'msg5']
        ]);

        $this->addForeignKey('comments_user_id_fx', 'comments', 'user_id', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE `comments`, `users`');
    }

}
