<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Helpers\IdentificationService;
use Manzadey\RegRu\Response;

class Domain extends BaseFunction
{
    protected $prefix = 'domain';

    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#domain_nop
     */
    public function getNop() : Response
    {
        return $this->getClient()->function('nop');
    }

    /**
     * @param bool|null   $showReNewData
     * @param bool|null   $shopUpdateData
     * @param string|null $currency
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#domain_get_prices
     */
    public function getPrices(?bool $showReNewData = null, ?bool $shopUpdateData = null, ?string $currency = null) : Response
    {
        return $this->getClient()->function('get_prices', [
            'show_renew_data'  => (int) $showReNewData,
            'show_update_data' => (int) $shopUpdateData,
            'currency'         => $currency,
        ]);
    }

    /**
     * @param string            $word
     * @param string|null       $additionalWord
     * @param string|null       $category
     * @param string|array|null $tlds
     * @param bool|null         $useHyphen
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#domain_get_suggest
     */
    public function getSuggest(string $word, ?string $additionalWord = null, ?string $category = null, $tlds = null, ?bool $useHyphen = null) : Response
    {
        return $this->getClient()->function('get_suggest', [
            'word'            => $word,
            'additional_word' => $additionalWord,
            'tlds'            => $tlds,
        ]);
    }

    /**
     * @param array  $domains
     * @param string $currency
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#domain_get_premium_prices
     */
    public function getPremiumPrices(array $domains, string $currency) : Response
    {
        return $this->getClient()->function('get_premium_prices', [
            'input_data' => [
                'currency' => $currency,
                'domains'  => $domains,
            ],
        ]);
    }

    public function getDeleted(
        $tlds = null,
        ?string $deletedFrom = null,
        ?string $deletedTo = null,
        ?string $createdFrom = null,
        ?string $createdTo = null,
        ?bool $hideReg = null,
        ?int $minPR = null,
        ?int $minCY = null,
    ) : Response
    {
        return $this->getClient()->function('get_deleted', [
            'tlds'         => $tlds,
            'deleted_from' => $deletedFrom,
            'deleted_to'   => $deletedTo,
            'created_from' => $createdFrom,
            'created_to'   => $createdTo,
            'hidereg'      => $hideReg,
            'min_pr'       => $minPR,
            'min_cy'       => $minCY,
        ]);
    }
}