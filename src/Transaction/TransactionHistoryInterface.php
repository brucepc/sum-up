<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 28/03/18
 * Time: 19:32
 */

namespace BPCI\SumUp\Transaction;


/**
 * Interface TransactionHistoryInterface
 * @package BPCI\SumUp\Transaction
 */
interface TransactionHistoryInterface
{
    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @return array
     */
    public function getLinks(): array;

    /**
     * @param array $items
     * @return TransactionHistoryInterface
     */
    public function setItems(array $items = []): TransactionHistoryInterface;

    /**
     * @param array $links
     * @return TransactionHistoryInterface
     */
    public function setLinks(array $links = []): TransactionHistoryInterface;
}