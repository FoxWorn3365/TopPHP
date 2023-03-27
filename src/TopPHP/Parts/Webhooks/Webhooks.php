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
 *
 * This library use ReactPHP (react\http) libraries for non stopping http webserver for websockets. https://reactphp.org
 * ReactPHP is under the MIT license
 */

namespace TopPHP\Parts\Webhooks;
use TopPHP\Parts\Webhooks\EventLoop;
use TopPHP\TopPHP;

class Webhook {
    protected object $responses;
    protected object $errors;
    public string|null $auth;
    protected TopPHP $parent;

    function __construct(TopPHP $topphp, string $token = NULL) {
        $this->auth = $token;
        $this->parent = $topphp;
        $this->responses = new \stdClass;
        $this->errors = new \stdClass;
    }

    public function addEventListener(string $event, callable $function) : void {
        $this->responses->{$event} = new \stdClass;
        $this->responses->{$event}->mainless = $function;
    }

    public function addErrorHandler(string $connectionError, callable $function) : void {
        $this->errors->{$connectionError} = $function;
    }

    public function client() : EventLoop|NULL {
        if (\Composer\InstalledVersions::isInstalled('react/http')) {
            $this->parent->callableException('libraryMissingException', [
                "name" => "Missing library",
                "description" => "The library react/http is not installed but required for Webhook management!",
                "lib" => "react/http"
            ]);
            return NULL;
        }
        return new EventLoop($this->responses, $this->errors, $this->auth);
    }

    public function make() : EventLoop {
        return $this->client();
    }
}