<?php

namespace app\models;
use PDO;
use Yii;
use yii\base\ErrorException;

/**
 * Модель для работы с балансом пользователей
 *
 * Class BalanceModel
 * @package app\models
 */
class BalanceModel {

    /**
     * Перечисление денежных средств с баланса одного пользователя
     * на баланс другого
     *
     * @param int $idFrom От кого
     * @param int $idTo Кому
     * @param float $sum Сумма
     * @throws \Throwable
     */
    public static function transfer(int $idFrom, int $idTo, float $sum) : void {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {

            $userBalance = $db->createCommand('
                SELECT id, balance FROM users WHERE id IN(:idFrom, :idTo) FOR UPDATE
            ', [
                'idFrom' => $idFrom, 'idTo' => $idTo
            ])->queryAll(PDO::FETCH_KEY_PAIR);

            if(\count($userBalance) !== 2) {
                throw new ErrorException('Не найден один из пользователей');
            }

            if($userBalance[$idFrom] < $sum) {
                throw new ErrorException('Недостаточно денег на балансе');
            }


            $db->createCommand('
                UPDATE users SET balance =
                    CASE id
                        WHEN :idTo THEN :balanceTo
                        WHEN :idFrom THEN :balanceFrom      
                    END
                WHERE id IN (:idTo, :idFrom)
            ', [
                'idFrom' => $idFrom,
                'balanceFrom' => $userBalance[$idFrom] - $sum,
                'idTo' => $idTo,
                'balanceTo' => $userBalance[$idTo] + $sum
            ])->execute();

            $transaction->commit();

        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

}