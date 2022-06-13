<?php

namespace Maxwkf\Barsbank;
use GuzzleHttp\Client;


class ApiClient
{

    // 'park_id'           => $parkId,
    //         'date_from'         => $startdate,
    //         'date_to'           => $enddate,
    //         'holiday_type'      => 1,
    //         'number_adults'     => $adults,
    //         'number_children'   => $children,
    //         'number_infants'    => $infants,
    //         'number_pets'       => $pets,
    //         'days_either_side'  => 0,

    const ENDPOINT = 'https://dynamic.barsbank.com/api/';
    const KEY = 'nde6geh38dhejwkfd838jwnnw3u8nwke9j34'; //coast_view_key
    const PARKID = '2';

    public function __construct(
        
        public $parkId = null,
        public $dateFrom= null,
        public $dateTo= null,
        public $holidayType = 1,
        public $numberAdults = 0,
        public $numberChildren = 0,
        public $numberInfants = 0,
        public $numberPets = 0,
        public $daysEitherSide = 0
    )
    {
        
    }

    public function connect() {
        $client = new Client(['headers' => [
            'key' => self::KEY,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]]);
        
        $res = $client->request('POST', self::ENDPOINT . 'getAvailability', [
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
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        echo $res->getBody();
        // {"type":"User"...'
    }

    

}