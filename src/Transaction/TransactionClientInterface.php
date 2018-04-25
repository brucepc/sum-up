<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 28/03/18
 * Time: 19:30
 */

namespace BPCI\SumUp\Transaction;


use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\SumUpClientInterface;

interface TransactionClientInterface extends SumUpClientInterface
{

    /**
     * @param array $filters
     * @return TransactionHistoryInterface
     */
    public function getHistory(array $filters): TransactionHistoryInterface;

    /**
     * @param array $filter
     * @return TransactionInterface
     */
    public function getTransactionDetails(array $filter): TransactionInterface;

    /**
     * @param TransactionInterface $transaction
     * @throws BadRequestException
     */
    public function refund(TransactionInterface $transaction);

}