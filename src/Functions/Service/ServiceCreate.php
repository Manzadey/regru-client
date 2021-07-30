<?php

namespace Manzadey\RegRu\Functions\Service;

use Manzadey\RegRu\Client;
use Manzadey\RegRu\Response;

class ServiceCreate
{
    /**
     * @var \Manzadey\RegRu\Client
     */
    private $client;

    private $data = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function setDomainName(string $value) : self
    {
        return $this->setQueryData('domain_name', $value);
    }

    public function setServType(string $value) : self
    {
        return $this->setQueryData('servtype', $value);
    }

    public function setPeriod(int $value) : self
    {
        return $this->setQueryData('period', $value);
    }

    public function setUserServId(int $value) : self
    {
        return $this->setQueryData('user_servid', $value);
    }

    public function setSubType(string $value) : self
    {
        return $this->setQueryData('subtype', $value);
    }

    /**
     * @param int|string$value
     *
     * @return $this
     * @throws \Exception
     */
    public function setFolder($value) : self
    {
        if(is_int($value)) {
            return $this->setQueryData('folder_id', $value);
        }

        if(is_string($value)) {
            return $this->setQueryData('folder_name', $value);
        }

        throw new \Exception('Use string or integer');
    }

    public function noFolderNew(bool $value) : self
    {
        return $this->setQueryData('no_new_folder', (int) $value);
    }

    public function setComment(string $value) : self
    {
        return $this->setQueryData('comment', $value);
    }

    public function setAdminComment(string $value) : self
    {
        return $this->setQueryData('admin_comment', $value);
    }

    public function setPlan(string $value) : self
    {
        return $this->setSubType($value);
    }

    public function setContactType(string $value) : self
    {
        return $this->setQueryData('contype', $value);
    }

    public function individualContactType() : self
    {
        return $this->setContactType('hosting_pp');
    }

    public function setOrganizationContactType() : self
    {
        return $this->setContactType('hosting_org');
    }

    public function setEmail(string $email) : self
    {
        return $this->setQueryData('email', $email);
    }

    public function setPhone(string $phone) : self
    {
        return $this->setQueryData('phone', $phone);
    }

    public function setCountry(string $value) : self
    {
        return $this->setQueryData('country', $value);
    }

    public function setPerson(string $value) : self
    {
        return $this->setQueryData('person_r', $value);
    }

    public function setPassport(string $value) : self
    {
        return $this->setQueryData('passport', $value);
    }

    public function setPPCode(string $value) : self
    {
        return $this->setQueryData('pp_code', $value);
    }

    public function setORG(string $value) : self
    {
        return $this->setQueryData('org_r', $value);
    }

    public function setCode(int $value) : self
    {
        return $this->setQueryData('code', $value);
    }

    public function setPayType(string $value) : self
    {
        return $this->setQueryData('pay_type', $value);
    }

    public function createIfNotMoney(string $payType) : self
    {
        return $this
            ->setPayType($payType)
            ->setQueryData('ok_if_no_money', 1);
    }

    public function setPointOfSale(string $value) : self
    {
        return $this->setQueryData('point_of_sale', $value);
    }

    public function setTitle(string $value) : self
    {
        return $this->setQueryData('title', $value);
    }

    public function setContent(string $value) : self
    {
        return $this->setQueryData('content', $value);
    }

    public function setCounterHtmlCode(string $value) : self
    {
        return $this->setQueryData('counter_html_code', $value);
    }

    public function setTemplateName(string $value) : self
    {
        return $this->setQueryData('template_name', $value);
    }

    public function setHtmlTitle(string $value) : self
    {
        return $this->setQueryData('html_title', $value);
    }

    public function setHtmlDescription(string $value) : self
    {
        return $this->setQueryData('html_description', $value);
    }

    public function setHtmlKeywords(string $value) : self
    {
        return $this->setQueryData('html_keywords', $value);
    }

    public function setOptUserContacts(bool $value) : self
    {
        return $this->setQueryData('opt_user_contacts', $value, true);
    }

    public function setOptDomainShopLink(bool $value) : self
    {
        return $this->setQueryData('opt_domain_shop_link', $value, true);
    }

    public function setOptWhoisLink(bool $value) : self
    {
        return $this->setQueryData('opt_whois_link', $value, true);
    }

    public function setOptSELink(bool $value) : self
    {
        return $this->setQueryData('opt_se_link', $value, true);
    }

    public function setOptIndexedLink(bool $value) : self
    {
        return $this->setQueryData('opt_indexed_link', $value, true);
    }

    public function setOptBlogsLink(bool $value) : self
    {
        return $this->setQueryData('opt_blogs_link', $value, true);
    }

    public function setOptFeedbackLink(bool $value) : self
    {

    }

    public function get() : Response
    {
        return $this->client->function('create', $this->data);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param bool  $bool
     *
     * @return $this
     */
    public function setQueryData($key, $value, bool $bool = false) : self
    {
        if($bool) {
            $value = (int) $value;
        }

        $this->data[$key] = $value;

        return $this;
    }
}