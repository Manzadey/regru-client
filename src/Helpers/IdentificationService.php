<?php

namespace Manzadey\RegRu\Helpers;

class IdentificationService
{
    protected $data = [];

    protected $options = [];

    /**
     * @var bool
     */
    protected $inputData = false;

    /**
     * @param string           $parameter
     * @param string|int|array $value
     * @param array            $options
     *
     * @return $this
     */
    public function add(string $parameter, $value, array $options = []) : self
    {
        if(is_array($value)) {
            foreach ($value as $item) {
                $this->data[][$parameter] = $item;

                if($options) {
                    $this->addOption("$parameter.$item", $options);
                }
            }

            return $this;
        }

        $this->data[][$parameter] = $value;

        if($options) {
            $this->addOption("$parameter.$value", $options);
        }

        return $this;
    }

    protected function addOption(string $key, array $options) : void
    {
        $this->options[$key] = $options;
    }

    /**
     * @param int|array $ids
     *
     * @return $this
     */
    public function addServiceIds($ids, array $options = []) : self
    {
        return $this->add('service_id', $ids, $options);
    }

    /**
     * @param int|array $domains
     *
     * @return $this
     */
    public function addDomains($domains) : self
    {
        return $this->add('dname', $domains);
    }

    public function addServiceType(string $serviceType) : self
    {
        return $this->add('servtype', $serviceType);
    }

    public function addUserServiceId(int $id) : self
    {
        return $this->add('servtype', $id);
    }

    public function addUpLinkServiceId(int $id) : self
    {
        return $this->add('uplink_service_id', $id);
    }

    public function addSubType(string $subType) : self
    {
        return $this->add('subtype', $subType);
    }

    public function isInputData() : self
    {
        $this->inputData = true;

        return $this;
    }

    public function toArray() : array
    {
        if($this->options) {
            foreach ($this->options as $service => $option) {
                [$parameter, $value] = explode('.', $service);

                $arrayKey = array_search($value, array_column($this->data, $parameter), false);

                $this->data[$arrayKey] = array_merge($this->data[$arrayKey], $option);
            }
        }

        if($this->inputData) {
            return [
                'input_data' => [
                    'services' => $this->data,
                ],
            ];
        }

        return array_merge([], ...$this->data);
    }

    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }
}