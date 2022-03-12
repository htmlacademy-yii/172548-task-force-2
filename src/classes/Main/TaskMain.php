<?php

namespace TaskForce\Main;

/**
 * Класс для работы с сущностью «Задание»
 *
 * Проект «TaskForce»
 *
 * Автор юрий Шаховский
 */
class TaskMain
{

    /** @var string STATUS_NEW Задание опубликовано, исполнитель ещё не найден */
    /** @var string STATUS_CANCELED Заказчик отменил задание */
    /** @var string STATUS_APROVED Заказчик выбрал исполнителя для задания */
    /** @var string STATUS_DONE Заказчик отметил задание как выполненное */
    /** @var string STATUS_FAIL Исполнитель отказался от выполнения задания */

    /** @var string ACTION_CANCEL Заказчик Отменить */
    /** @var string ACTION_COMPLETE Заказчик Выполнено */
    /** @var string ACTION_RESPOND Исполнитель Откликнуться */
    /** @var string ACTION_REFUSE Исполнитель Отказаться */

    /** @var array TASK_STATUSES возможные статусы задания */
    /** @var array TASK_ACTIONS возможные действия по заданию */

    /** @var string currentTaskStatus текущий статус задания */
    /** @var int customerID ID заказчика */
    /** @var int employeeID ID исполнителя */

    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_APROVED = 'aproved';
    const STATUS_DONE = 'done';
    const STATUS_FAIL = 'fail';

    const ACTION_CANCEL = 'cancel';
    const ACTION_COMPLETE = 'complete';
    const ACTION_RESPOND = 'respond';
    const ACTION_REFUSE = 'refuse';

    const TASK_STATUSES = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Отменено',
        self::STATUS_APROVED => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAIL => 'Провалено'
    ];

    const TASK_ACTIONS = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_COMPLETE => 'Завершить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_REFUSE => 'Отказаться'
    ];

    private $currentTaskStatus;
    private $customerID;
    private $employeeID;

    function __construct($customerID, $employeeID, $currentTaskStatus)
    {
        $this->customerID = $customerID;
        $this->employeeID = $employeeID;
        $this->currentTaskStatus = $currentTaskStatus;
    }

    /**
     * Получение «карты» статусов
     *
     * @return array
     */

    public function getStatusesMap()
    {
        return self::TASK_STATUSES;
    }

    /**
     * Получение «карты» действий
     *
     * @return array
     */

    public function getActionsMap()
    {
        return self::TASK_ACTIONS;
    }

    /**
     * Получение следующего статуса по "Заданию"
     *
     * @return string статус сущности
     * @var string текущее действие в "Задании"
     *
     */

    public function getNextStatusByAction($currentTaskAction)
    {
        switch ($currentTaskAction) {
            case (self::ACTION_RESPOND):
                return self::STATUS_APROVED;
                break;
            case (self::ACTION_CANCEL):
                return self::STATUS_CANCELED;
                break;
            case (self::ACTION_REFUSE):
                return self::STATUS_FAIL;
                break;
            default:
                return self::STATUS_DONE;
                break;
        }
    }

    /**
     * Получение доступных действий для статуса по "Заданию"
     *
     * @return array/bool список доступных действий
     * @var string текущий статус в "Заданию"
     *
     */

    public function getActionsListByStatus($currentTaskStatus)
    {
        switch ($currentTaskStatus) {
            case (self::STATUS_NEW):
                return [
                    $this->customerID => self::ACTION_CANCEL,
                    $this->employeeID => self::ACTION_RESPOND
                ];
                break;
            case (self::STATUS_APROVED):
                return [
                    $this->customerID => self::ACTION_COMPLETE,
                    $this->employeeID => self::ACTION_REFUSE
                ];
                break;
            default:
                return false;
                break;
        }
    }

}

;
?>