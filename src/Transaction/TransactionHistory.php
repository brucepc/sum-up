<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 31/03/18
 * Time: 00:47
 */

namespace BPCI\SumUp\Transaction;


class TransactionHistory implements TransactionHistoryInterface
{
    /**
     * @var array
     */
    protected $items;
    /**
     * @var array
     */
    protected $links;

    public function __construct($data = [])
    {
        $this
            ->setItems($data['items'] ?? [])
            ->setLinks($data['links'] ?? []);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return TransactionHistory
     */
    public function setItems(array $items = []): TransactionHistoryInterface
    {
        $this->items = [];

        foreach ($items as $item) {
            array_push($this->items, new Transaction($item));
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return TransactionHistory
     */
    public function setLinks(array $links = []): TransactionHistoryInterface
    {
        $this->links = $links;

        return $this;
    }
}