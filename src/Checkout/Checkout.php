<?php
namespace BPCI\SumUp\Checkout;

use GuzzleHttp\Client;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCheckoutException;


class Checkout implements CheckoutClientInterface, CheckoutInterface
{
    const PENDING = 'PENDING';
    const COMPLETED = 'COMPLETED';
    const ENDPOINT = 'checkouts';

    private $id;
    private $status;
    private $amount;
    private $feeAmount;
    private $currency;
    private $payTo;
    private $payFromEmail;
    private $reference;
    private $description;
    private $redirectUrl;

    function __construct(
        number $amount, 
        string $pay_to_email, 
        string $checkout_reference,
        string $currency = '',
        string $description = '',
        number $fee_amount = null,
        string $pay_from_mail = '',
        string $redirect_url = '',
        string $id = '',
        string $status = self::PENDING)
    {
        $this->setAmount($amount);
        $this->setPayTo($pay_to_email);
        $this->setReference($checkout_reference);
        $this->setCurrency($currency);
        $this->setDescription($description);
        $this->setFeeAmount($fee_amount);
        $this->setPayFrom($pay_from_mail);
        $this->setId($id);
        $this->setRedirectUrl($redirect_url);
        $this->setStatus($status);
    }

    /**
     * @inheritDoc
     */
    static function getScopes(): Array
    {
        return [
            'payments',
            'boleto'
        ];
    }

    /**
     * @inheritDoc
     * @throws InvalidCheckoutException
     * @throws BadRequestException
     */
    static function create(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {
        if($accessToken === null){
            $accessToken = AuthenticationHelper::getAcessToken($context, self::getScopes());
        }else{
            if(!$accessToken->isValid()){
                $accessToken = AuthenticationHelper::getAcessToken($context, $accessToken->getScope());                
            }
        }
        
        if(!$checkout->isValid()){
            throw new InvalidCheckoutException('Ops! Something is wrong with checkout.');
        }

        $checkoutClient = SumUp::getClient();
        $headers = AuthenticationHelper::getHeader($accessToken);
        $body = self::getCheckoutBody($checkout);
        $response = $checkoutClient->post(self::ENDPOINT, $headers, $body);
        if($response->getCode() === 201){
            
        }
    }

    /**
     * @inheritDoc
     */
    static function get(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {

    }

    /**
     * @inheritDoc
     */
    static function complete(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface
    {

    }

    /**
     * @inheritDoc
     */
    function isValid(): bool
    {
        return $this->getReference() !== null
               && $this->getAmount() !== null
               && $this->getPayToMail() !== null;
    }

    /**
     * @inheritDoc 
     */
    function getId(){
        return $this->id;
    }

    /**
     * @inheritDoc 
     */
    function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getStatus(){
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getAmount(): number {
        return $this->amount;
    }

    /**
     * @inheritDoc
     */
    function setAmount(number $amount): Checkout {
        $this->amount = $amount > 0 ? $amount : null;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getCurrency(): string{
        return $this->currency;
    }

    /**
     * @inheritDoc
     */
    function setCurrency($currency): Checkout{
        $this->currency = $currency;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getPayTo(): string{
        return $this->payTo;
    }

    /**
     * @inheritDoc
     */
    function setPayTo($email): Checkout{
        $this->payTo = trim($email) === '' ? null : $email;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getReference(): string{
        return $this->reference;
    }

    /**
     * @inheritDoc
     */
    function setReference($reference): Checkout{
        $this->reference = trim($reference) === '' ? null : $reference;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getDescription(): string{
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    function setDescription($description): Checkout{
        $this->description = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getFeeAmount(): number
    {
        return $this->fee;
    }

    /**
     * @inheritDoc
     */
    function setFeeAmount(number $fee): CheckoutInterface
    {
        return $this->fee = $fee;
    }

    /**
     * @inheritDoc
     */
    function getPayFrom(): string
    {
        return $this->payFromMail;
    }

    /**
     * @inheritDoc
     */
    function setPayFrom(string $email): CheckoutInterface
    {
        $this->payFromMail = $email;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @inheritDoc
     */
    function setRedirectUrl(string $url): CheckoutInterface
    {
        $this->redirectUrl = $url;
        return $this;
    }

    static function getCheckoutBody(CheckoutInterface $checkout): Array
    {
        return [
            "checkout_reference" => $checkout->getReference(),
            "amount" => $checkout->getAmout(),
            "currency" => $checkout->getCurrency(),
            "pay_to_email" => $checkout->getPayTo(),
            "pay_from_email" => $checkout->getPayFrom(),
            "fee_amount" => $checkout->getFeeAmount(),
            "description" => $checkout->getDescription(),
            "return_url" => $checkout->getRedirectUrl()    
        ];
    }
}
