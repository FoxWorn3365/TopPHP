<?php
/**
 * This file is respectively apart of the TopPHP2 project.
 * TopPHP2 is not an official library for top.gg but is the best :D
 *
 * Copyright (c) 2023-present Federico Cosma
 * Some rights are reserved.
 *
 * This copyright is subject to the MIT license which
 * fully entails the details in the LICENSE file.
 * 
 * GitHub: https://github/FoxWorn3365/TopPHP
 * Contact me: foxworn3365@gmail.com
 * My profile: https://github.com/FoxWorn3365
 * 
 * If you understand anything about PHP you are free to contribute :)
 */

namespace TopPHP\Components;
use TopPHP\TopPHP;
use TopPHP\Parts\Collection;
use TopPHP\Parts\Http;
use TopPHP\Components\Bot;

class Bots {
    // Define basic values
    protected string $token;
    protected string $endpoint;
    protected TopPHP $parent;

    // Let's create the magic!
    function __construct(TopPHP $parent) {
        $this->parent = $parent;
    }

    function list(int $limit = 50, int $offset = 0, string $search = NULL, string $sort = NULL) : Collection|NULL  {
        $data = Http::get("{$this->parent->endpoint}/bots?limit={$limit}&offset={$offset}&search={$search}&sort={$sort}", $this->parent->token);
        if (!$data) {
            if (stripos($http_response_header[0], '401') !== false) {
                $this->parent->callableException('authenticationException', [
                    "title" => "Unhautorized",
                    "description" => "Unhautorized! Actual token ({$this->parent->token}) is not valid!",
                    "token" => $this->parent->token,
                    "headers" => $http_response_header
                ]);
            } else {
                $this->parent->callableException('commonException', [
                    "title" => "Undefined",
                    "description" => "Top.gg didn't say anything :(",
                    "headers" => $http_response_header
                ]); 
            }
            return null;
        }
        // Ok, no error. Now let's get all the results!
        $collection = new Collection();
        foreach ($data->results as $bot) {
            $collection->add($bot->id, new Bot($bot, $this->parent));
        }
        return $collection;
    }

    function get(string $id) : Bot|NULL {
        $data = Http::get("{$this->parent->endpoint}/bots/{$id}", $this->parent->token);
        if (!$data) {
            if (stripos($http_response_header[0], '401') !== false) {
                $this->parent->callableException('authenticationException', [
                    "title" => "Unhautorized",
                    "description" => "Unhautorized! Actual token ({$this->parent->token}) is not valid!",
                    "token" => $this->parent->token,
                    "headers" => $http_response_header
                ]);
            } elseif (stripos($http_response_header[0], '404') !== false) {
                $this->parent->callableException('notFoundException', [
                    "title" => "Not found!",
                    "description" => "The requested bot probably doesn't exists (yet)",
                    "bot_id" => $id,
                    "headers" => $http_response_header
                ]);
            } else {
                $this->parent->callableException('commonException', [
                    "title" => "Undefined",
                    "description" => "Top.gg didn't say anything :(",
                    "bot_id" => $id,
                    "headers" => $http_response_header
                ]); 
            }
            return null;
        }
        return new Bot($data, $this->parent);
    }
}