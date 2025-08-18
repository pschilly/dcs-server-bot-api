<?php

// config for Pschilly/DcsServerBotApi
return [

    /*
    |--------------------------------------------------------------------------
    | DCS Bot API URL
    |--------------------------------------------------------------------------
    |
    | This value is the base URL for the DCS Bot API, which will be used when
    | making requests to the API endpoints.
    |
    | See documentation of DCS Server Bot API for more details & configuration on your actual DCS Server Bot.
    |   WebService: https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/services/webservice/README.md
    |   RestAPI: https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md
    |
    */

    'base_url' => env('DCS_BOT_API_URL', 'http://localhost:9876'),

];
