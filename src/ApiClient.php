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
        public $parkId
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
                'holiday_type' => $this->holidayType ?? 1,
                'number_adults' => $this->numberAdults,
                'number_children' => $this->numberChildren ?? 0,
                'number_infants' => $this->numberInfants ?? 0,
                'number_pets' => $this->numberPets ?? 0,
                'days_either_side' => $this->daysEitherSide ?? 0,
            ]
        ]);

        // dd([
        //     $response->getStatusCode(),
        //     $response->getReasonPhrase(),
        //     $response->getProtocolVersion(),
        //     $response->getBody(),
        //     $response->getBody()->getContents(),
        // ]);

        $content = json_decode($response->getBody()->getContents());

        if (!is_array( $content ) && $content->error == 'No availability has been found') {
            $content = [];
        }

        return $content;
    }

    public function getValidStays() {
        $response = $this->client->request('POST', self::ENDPOINT . 'getValidStays', [
            'form_params' => [
                'park_id' => $this->parkId
            ]
        ]);

        if (!is_array( $content ) && $content->error == 'No valid stays has been found') {
            $content = [];
        }

        return $content;
    }

    public function getParkAccommodation() {
        $response = $this->client->request('POST', self::ENDPOINT . 'getValidStays', [
            'form_params' => [
                'park_id' => $this->parkId
            ]
        ]);
        
        if (!is_array( $content ) && $content->error == 'No park accommodation has been found') {
            $content = [];
        }

        return $content;
    }

    public function getTourValidStays() {
        $response = $this->client->request('POST', self::ENDPOINT . 'getTourValidStays', [
            'form_params' => [
                'park_id' => $this->parkId
            ]
        ]);
        
        $content = json_decode($response->getBody()->getContents());

        if (!is_array( $content ) && $content->error == 'No tour valid stays has been found') {
            $content = [];
        }

        return $content;
    }


    public function getExtras() {
        
        $response = $this->client->request('POST', self::ENDPOINT . 'getExtras', [
            'form_params' => [
                'park_id' => $this->parkId,
                'product_id' => $this->productId,
                'date_from' => $this->dateFrom,
                'date_to' => $this->dateTo,
                'holiday_type' => $this->holidayType ?? 1,
                'availability_token' => $this->availabilityToken,
            ]
        ]);

        $content = json_decode($response->getBody()->getContents());

        if (!is_array( $content ) && $content->error == 'No extras has been found') {
            $content = [];
        }

        return $content;
    }

    public function createProvisionalBooking() {
        $response = $this->client->request('POST', self::ENDPOINT . 'createProvisionalBooking', [
            'form_params' => [
                'availability_token' => $this->availabilityToken
            ]
        ]);

        $content = json_decode($response->getBody()->getContents());

        return $content;
    }

}