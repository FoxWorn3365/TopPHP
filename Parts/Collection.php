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

namespace TopPHP\Parts;

class Collection {
    protected object $collector;

    function __construct(object $existingCollector = null) {
        if ($existingCollector != null) {
            $this->collector = $existingCollector;
        } else {
            $this->collector = new \stdClass;
        }
    }
    
    public function set(string $key, mixed $value) : void {
        $this->collector->{$key} = $value;
    }

    public function add(string $key, mixed $value) : void {
        self::set($key, $value);
    }

    public function get(string $key) : mixed {
        return $this->collector->{$key};
    }

    public function remove(string $key) : void {
        $this->collector->{$key} = null;
    }

    public function count() : int {
        return count($this->collector);
    }

    public function index() : array {
        $data = [];
        foreach ($this->collector as $key => $value) {
            array_push($data, $key);
        }
        return $data;
    }

    public function foreach(callable $callback) : void {
        foreach ($this->collector as $key => $value) {
            $callback($key, $value);
        }
    }

    public function all() : object {
        return $this->collector;
    }
}