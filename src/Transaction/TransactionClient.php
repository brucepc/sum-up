<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 30/03/18
 * Time: 11:48
 */

namespace BPCI\SumUp\Transaction;


use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Traits\SumUpClientTrait;
use GuzzleHttp\RequestOptions;

class TransactionClient implements TransactionClientInterface
{
    use SumUpClientTrait;

    public function __construct(ContextInterface $context, ?array $options = [])
    {
        $this->context = $context;
        $this->options = $options;
    }
    public function getHistory(array $filters): TransactionHistoryInterface
    {
        $endpoint = $this->getEndPoint().'/history';
        $this->options['query'] = $filters;
        $history = new TransactionHistory();
        $this->request('get', $history, $endpoint);

        return $history;
    }

    public function getTransactionDetails(array $filter): TransactionInterface
    {
        $this->options['query'] = $filter;
        $transaction = new Transaction();
        $this->request('get', $transaction);

        return $transaction;
    }

    public function refund(TransactionInterface $transaction, string $amount = null)
    {
        $this->options[RequestOptions::JSON] = [
            "amount" => $amount ?? $transaction->getAmount()
        ];
        $endpoint = 'me/refund/'.$transaction->getTransactionCode();
        $this->request('post', null, $endpoint);
        //TODO return reponse.
    }

    static function getScopes(): array
    {
        return ['transactions.history'];
    }

    /**
     * {@inheritdoc}
     */
    static function getBody($object, string $type = null)
    {
        if ($object instanceof TransactionHistory
            || $object instanceof Transaction) {
            return null;
        }

        return [];
    }

    public function getEndPoint(): string
    {
        return 'me/transactions';
    }

}