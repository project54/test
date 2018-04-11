<?php
namespace app\commands;
use app\models\BalanceModel;
use yii\base\InvalidArgumentException;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Команды для работы с балансом пользователей
 *
 * Class BalanceController
 * @package app\commands
 */
class BalanceController extends Controller
{
    /**
     * Перечисление денежных средств с баланса одного пользователя
     * на баланс другого
     *
     * @param int $idFrom От кого
     * @param int $idTo Кому
     * @param float $sum Сумма
     * @return int
     * @throws \Throwable
     */
    public function actionTransfer(int $idFrom, int $idTo, float $sum) : int {
        if($sum <= 0) {
            throw new InvalidArgumentException('Некорректная сумма');
        }
        BalanceModel::transfer($idFrom, $idTo, $sum);
        return ExitCode::OK;
    }
}