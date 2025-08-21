<?php

namespace Pschilly\DcsServerBotApi;

use Illuminate\Support\Facades\Http;

class DcsServerBotApi
{
    protected static string $baseUrl;

    public function __construct(?string $baseUrl = null)
    {
        if ($baseUrl) {
            self::$baseUrl = $baseUrl;
        } else {
            self::$baseUrl = config('dcs-server-bot-api.base_url');
        }
    }

    /**
     * Get the Base URL
     */
    public static function getBaseUrl(): string
    {
        if (! isset(self::$baseUrl) || empty(self::$baseUrl)) {
            self::$baseUrl = config('dcs-server-bot-api.base_url');
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
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getServerStats(?string $server_name = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/serverstats', [
            'server_name' => $server_name,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

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
     * @return mixed json|collection
     */
    public static function getServerList(string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/servers');

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * SQUADRONS
     * List of all squadrons and their roles.
     *
     * @api_endpoint /squadrons
     *
     * @return mixed json|collection
     */
    public static function getSquadronList(?int $limit = null, ?int $offset = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/squadrons', [
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * SQUADRON MEMBERS
     * List of all members in a specific squadron.
     *
     * @api_endpoint /squadron_members
     *
     * @param  string  $squadronName  [required]
     * @return mixed json|collection
     */
    public static function getSquadronMembers(string $squadronName, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/squadron_members', ['name' => $squadronName]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * GET USER
     * Retrieve information about a specific user.
     *
     * @api_endpoint /getuser
     *
     * @param  string  $nick  [required|wild]
     * @return mixed json|collection
     */
    public static function getUser(string $nick, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/getuser', ['nick' => $nick]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * LINK ME
     * Link a players Discord and DCS IDs in the Discord Bot
     *
     * @api_endpoint /linkme
     *
     * @param  string  $discord_id  [required] - Discord ID of the player.
     * @param  bool|null  $force  - Force the operation.
     * @return mixed json|collection
     *               {
     *               "rc": 2,
     *               "timestamp": "2025-08-09T12:00:00+00:00",
     *               "token": "1234"
     *               }
     */
    public static function linkMe(string $discord_id, ?bool $force = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/linkme', [
            'discord_id' => $discord_id,
            'force' => $force,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * PLAYER SQUADRONS
     * Retrieve the list of squadrons for a specific player.
     *
     * @api_endpoint /player_squadrons
     *
     * @param  string  $nick  [required] - Actual name of the player. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @return mixed json|collection
     */
    public static function getPlayerSquadrons(string $nick, ?string $date = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/player_squadrons', [
            'nick' => $nick,
            'date' => $date,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * LEADERBOARD
     * Retrieve the top kills for a specific server or user.
     *
     * @api_endpoint /leaderboard
     *
     * @param string $what - Sort Order [kills, deaths, kdr, kills_pvp, deaths_pvp, kdr_pvp]
     * @param  int|null  $limit  - Limit the returned results to a specific number.
     * @param int|null $offset - Offset for the limit, used for pagination
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    /**
     * Get top kills for a server.
     *
     * @param  string  $returnType  'json' (default) or 'collection'
     * @return array|\Illuminate\Support\Collection
     */
    public static function getLeaderboard(?string $what = 'kills', ?string $order = 'desc', ?string $query = null, ?string $server_name = null, ?int $limit = 10, ?int $offset = 0, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/leaderboard', [
            'what' => $what,
            'order' => $order,
            'query' => $query,
            'limit' => $limit,
            'offset' => $offset,
            'server_name' => $server_name,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * TOP KILLS
     * Retrieve the top kills for a specific server or user.
     *
     * @api_endpoint /topkills
     *
     * @param  int|null  $limit  - Limit the returned results to a specific number.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    /**
     * Get top kills for a server.
     *
     * @param  string  $returnType  'json' (default) or 'collection'
     * @return array|\Illuminate\Support\Collection
     */
    public static function getTopKills(?string $server_name = null, ?int $limit = null, ?int $offset = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/topkills', [
            'server_name' => $server_name,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * TOP KDR
     * Retrieve the top KDR (Kill/Death Ratio) for a specific server or user.
     *
     * @api_endpoint /topkdr
     *
     * @param  int|null  $limit  - Limit the returned results to a specific number.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getTopKDR(?string $server_name = null, ?int $limit = null, ?int $offset = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/topkdr', [
            'server_name' => $server_name,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

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
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getTrueSkillStats(?string $server_name = null, ?int $limit = null, ?int $offset = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/trueskill', [
            'server_name' => $server_name,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * WEAPON PK
     * Retrieve the weapon PK (Probability of Kill) statistics for all weapons for a specific user.
     *
     * @api_endpoint /weaponpk
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getWeaponPK(?string $server_name, string $nick, ?string $date = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/weaponpk', [
            'nick' => $nick,
            'server_name' => $server_name,
            'date' => $date,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * PLAYER STATS
     * Retrieve the player statistics for a specific user.
     *
     * @api_endpoint /stats
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getStats(?string $server_name, string $nick, ?string $date = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/stats', [
            'nick' => $nick,
            'date' => $date,
            'server_name' => $server_name,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * PLAYER INFO
     * Retrieve the player information for a specific user.
     *
     * @api_endpoint /player_info
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getPlayerInfo(?string $server_name, string $nick, ?string $date = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/player_info', [
            'nick' => $nick,
            'server_name' => $server_name,
            'date' => $date,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * HIGHSCORE BOARD
     * Retrieve the highscore board for a specific game mode.
     *
     * @api_endpoint /highscore
     *
     * @param  string|null  $server_name  - Limit the response to a specific server in your cluster.
     * @param  string|null  $period  - Limit the response to a specific time period.
     * @param  int|null  $limit  - Limit the number of results returned.
     * @return mixed json|collection
     */
    public static function getHighscore(?string $server_name = null, ?int $limit = null, ?string $period = null, string $returnType = 'json'): mixed
    {
        $response = Http::baseUrl(self::getBaseUrl())->get('/highscore', [
            'server_name' => $server_name,
            'limit' => $limit,
            'period' => $period,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * TRAPS
     * Retrieve the traps statistics for a specific user.
     *
     * @api_endpoint /traps
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  int|null  $limit  - Limit the number of results returned.
     * @param  string|null  $server_name  - limit the response to a specific server in your cluster.
     * @return mixed json|collection
     */
    public static function getTraps(string $nick, ?string $server_name = null, ?int $limit = null, ?int $offset = null, ?string $date = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/traps', [
            'nick' => $nick,
            'date' => $date,
            'limit' => $limit,
            'offset' => $offset,
            'server_name' => $server_name,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * CREDITS
     * Retrieve the credits information for a specific user including the campaign
     *
     * @api_endpoint /credits
     *
     * @param  string  $nick  [required] - Actual nickname of the user. Get with $this->getUser($nick)
     * @param  string|null  $date  - Limit the response to a specific date.
     * @param  string|null  $campaign  - limit the response to a specific campaign.
     * @return mixed json|collection
     */
    public static function getCredits(string $nick, ?string $date = null, ?string $campaign = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/credits', [
            'nick' => $nick,
            'date' => $date,
            'campaign' => $campaign,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }

    /**
     * SQUADRON CREDITS
     * Retrieve the squadron credits information for a specific user including the campaign
     *
     * @api_endpoint /squadron_credits
     *
     * @param  string  $name  [required] - Actual name of the squadron.
     * @param  string|null  $campaign  - limit the response to a specific campaign.
     * @return mixed json|collection
     */
    public static function getSquadronCredits(string $name, ?string $campaign = null, string $returnType = 'json'): mixed
    {
        $response = Http::asForm()->baseUrl(self::getBaseUrl())->post('/squadron_credits', [
            'name' => $name,
            'campaign' => $campaign,
        ]);

        if ($returnType === 'collection') {
            return $response->collect();
        }

        return $response->json();
    }
}
