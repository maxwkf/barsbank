<?php

namespace Maxwkf\Barsbank;
use GuzzleHttp\Client;

/**
 * @method string getApiKey()
 * @method ApiClient setApiKey()
 */
class ApiClient
{

    // https://dynamic.barsbank.com/api-docs
    const ENDPOINT = 'https://dynamic.barsbank.com/api/';

    public function __construct(
        public $apiKey,
        public $parkId,
        public $dateFrom = null,
        public $dateTo = null,
        public $holidayType = 1,
        public $numberAdults = 0,
        public $numberChildren = 0,
        public $numberInfants = 0,
        public $numberPets = 0,
        public $daysEitherSide = 0
    )
    {
        $this->client = new Client(['headers' => [
            'key' => $this->apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]]);
    }

    public function __call($method, $args)
    {
        if (str_starts_with($method, 'get')) {
            return lcfirst(substr($method, 3));
        } else if (str_starts_with($method, 'set')) {
            $this->{lcfirst(substr($method, 3))} = $args[0];
            return $this;
        }
    }
    

    public function getAvailabilities() {
        
        $response = $this->client->request('POST', self::ENDPOINT . 'getAvailability', [
            'form_params' => [
                'park_id' => $this->parkId,
                'date_from' => $this->dateFrom,
                'date_to' => $this->dateTo,
                'holiday_type' => $this->holidayType,
                'number_adults' => $this->numberAdults,
                'number_children' => $this->numberChildren,
                'number_infants' => $this->numberInfants,
                'number_pets' => $this->numberPets,
                'days_either_side' => $this->daysEitherSide,
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getValidStays() {
        $response = $this->client->request('POST', self::ENDPOINT . 'getValidStays', [
            'form_params' => [
                'park_id' => $this->parkId
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    

}