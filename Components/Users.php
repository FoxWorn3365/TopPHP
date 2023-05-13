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
use TopPHP\Parts\Http;
use TopPHP\Components\User;

class Users {
    // Global user collection, almost useless
    protected TopPHP $parent;

    // Class handling
    function __construct(TopPHP $parent) {
        $this->parent = $parent;
    }

    public function get(string $id) : User {
        return new User(Http::get("{$this->parent->endpoint}/users/{$id}", $this->parent->token), $this->parent);
    }
}