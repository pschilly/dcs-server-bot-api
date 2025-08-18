<?php

namespace Pschilly\DcsServerBotApi;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class DcsServerBotApi
{
    protected static string $baseUrl;

    public function __construct(?string $baseUrl = null)
    {
        if ($baseUrl) {
            self::$baseUrl = $baseUrl;
        } else {
            self::$baseUrl = Config::get('dcs-server-bot-api.base_url');
        }
    }

    /**
     * Get the Base URL
     */
    public static function getBaseUrl(): string
    {
        if (! isset(self::$baseUrl) || empty(self::$baseUrl)) {
            self::$baseUrl = Config::get('dcs-server-bot-api.base_url');
        }

        return self::$baseUrl;
    }

    /*
    |--------------------------------------------------------------------------
    | DCS Bot API Endpoints
    |--------------------------------------------------------------------------
    |
    | See documentation of DCS Server Bot API for more details.
    |   RestAPI: https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md
    |
    */

    /**
     * SERVER STATS
     * Statistics for the entire server cluster. Including:
     * - Active Players
     * - Average Playtime (minutes)
     * - Total Deaths
     * - Total Kills
     * - Total Players
     * - Total Playtime (seconds)
     * - Total Sorties
     *
     * @api_endpoint /serverstats
     *
     * @method GET
     *
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getServerStats(?string $server_name = null): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/serverstats', [
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * SERVER LISTING
     * List of all active servers including information about the active mission (if any) and any active extensions. Including:
     * - Address
     * - Extensions (array)
     * - Mission (array)
     *      - Blue Slots
     *      - Blue Slots Used
     *      - Date Time
     *      - Name
     *      - Red Slots
     *      - Red Slots Used
     *      - Restart Time
     *      - Theatre
     *      - Uptime
     * - Name
     * - Password
     * - Status
     *
     * @api_endpoint /servers
     *
     * @method GET
     *
     * @return json
     */
    public static function getServerList(): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/servers');

        return $response->json();
    }

    /**
     * SQUADRONS
     * List of all squadrons and their roles.
     *
     * @api_endpoint /squadrons
     *
     * @method GET
     *
     * @return json
     */
    public static function getSquadronList(): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/squadrons');

        return $response->json();
    }

    /**
     * SQUADRON MEMBERS
     * List of all members in a specific squadron.
     *
     * @api_endpoint /squadron_members
     *
     * @method POST
     *
     * @param  string  $squadronName  [required]
     * @return json
     */
    public static function getSquadronMembers(string $squadronName): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl(), ['name' => $squadronName])->post('/squadron_members');

        return $response->json();
    }

    /**
     * GET USER
     * Retrieve information about a specific user.
     *
     * @api_endpoint /getuser
     *
     * @method POST
     *
     * @param  string  $nick  [required|wild]
     * @return json
     */
    public static function getUser(string $nick): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl(), ['nick' => $nick])->post('/getuser');

        return $response->json();
    }

    /**
     * LINK ME
     * Link a players Discord and DCS IDs in the Discord Bot
     *
     * @api_endpoint /linkme
     *
     * @method POST
     *
     * @param  string  $discord_id  [required] - Discord ID of the player.
     * @param  bool|null  $force  - Force the operation.
     * @return json
     *              {
     *              "rc": 2,
     *              "timestamp": "2025-08-09T12:00:00+00:00",
     *              "token": "1234"
     *              }
     */
    public static function linkMe(string $discord_id, ?bool $force = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/linkme', [
            'discord_id' => $discord_id,
            'force' => $force,
        ]);

        return $response->json();
    }

    /**
     * PLAYER SQUADRONS
     * Retrieve the list of squadrons for a specific player.
     *
     * @api_endpoint /player_squadrons
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual name of the player. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @return json
     */
    public static function getPlayerSquadrons(string $name, ?string $date = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/player_squadrons', [
            'name' => $name,
            'date' => $date,
        ]);

        return $response->json();
    }

    /**
     * TOP KILLS
     * Retrieve the top kills for a specific server or user.
     *
     * @api_endpoint /topkills
     *
     * @method GET
     *
     * @param  int|null  $limit  - Limit the returned results to a specific number.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getTopKills(?int $limit = null, ?string $server_name = null): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/topkills', [
            'limit' => $limit,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * TOP KDR
     * Retrieve the top KDR (Kill/Death Ratio) for a specific server or user.
     *
     * @api_endpoint /topkdr
     *
     * @method GET
     *
     * @param  int|null  $limit  - Limit the returned results to a specific number.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getTopKDR(?int $limit = null, ?string $server_name = null): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/topkdr', [
            'limit' => $limit,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * TRUESKILL™ STATISTICS
     * Retrieve the TrueSkill™ statistics for a specific user.
     *
     * REQUIRES: "Competitive" plugin enabled on the Server Bot.
     *
     * @api_endpoint /trueskill
     *
     * @method GET
     *
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getTrueSkillStats(?int $limit = null, ?string $server_name = null): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/trueskill', [
            'limit' => $limit,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * WEAPON PK
     * Retrieve the weapon PK (Probability of Kill) statistics for all weapons for a specific user.
     *
     * @api_endpoint /weaponpk
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getWeaponPK(string $nick, ?string $date = null, ?string $server_name = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/weaponpk', [
            'nick' => $nick,
            'date' => $date,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * PLAYER STATS
     * Retrieve the player statistics for a specific user.
     *
     * @api_endpoint /stats
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getStats(string $nick, ?string $date = null, ?string $server_name = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/stats', [
            'nick' => $nick,
            'date' => $date,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * PLAYER INFO
     * Retrieve the player information for a specific user.
     *
     * @api_endpoint /player_info
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getPlayerInfo(string $nick, ?string $date = null, ?string $server_name = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/player_info', [
            'nick' => $nick,
            'date' => $date,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * HIGHSCORE BOARD
     * Retrieve the highscore board for a specific game mode.
     *
     * @api_endpoint /highscore
     *
     * @method GET
     *
     * @param  string|null  $server_name  - Limit the response to a specific server in your cluster.
     * @param  string|null  $period  - Limit the response to a specific time period.
     * @param  int|null  $limit  - Limit the number of results returned.
     * @return json
     */
    public static function getHighscore(?string $server_name = null, ?string $period = null, ?int $limit = null): array
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/highscore', [
            'server_name' => $server_name,
            'period' => $period,
            'limit' => $limit,
        ]);

        return $response->json();
    }

    /**
     * TRAPS
     * Retrieve the traps statistics for a specific user.
     *
     * @api_endpoint /traps
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  int|null  $limit  - Limit the number of results returned.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return json
     */
    public static function getTraps(string $nick, ?string $date = null, ?int $limit = null, ?string $server_name = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/traps', [
            'nick' => $nick,
            'date' => $date,
            'limit' => $limit,
            'server_name' => $server_name,
        ]);

        return $response->json();
    }

    /**
     * CREDITS
     * Retrieve the credits information for a specific user including the campaign
     *
     * @api_endpoint /credits
     *
     * @method POST
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $campaign  - limit the response to a specific campaign.
     * @return json
     */
    public static function getCredits(string $nick, ?string $date = null, ?string $campaign = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/credits', [
            'nick' => $nick,
            'date' => $date,
            'campaign' => $campaign,
        ]);

        return $response->json();
    }

    /**
     * SQUADRON CREDITS
     * Retrieve the squadron credits information for a specific user including the campaign
     *
     * @api_endpoint /squadron_credits
     *
     * @method POST
     *
     * @param  string  $name  [required] - Actual name of the squadron.
     * @param  string|null  $campaign  - limit the response to a specific campaign.
     * @return json
     */
    public static function getSquadronCredits(string $name, ?string $campaign = null): array
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/squadron_credits', [
            'name' => $name,
            'campaign' => $campaign,
        ]);

        return $response->json();
    }
}
