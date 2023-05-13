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

class Cache {
    // Using session cache because they're fast and beautiful
    // But not for token :D
    // Check
    public static function isInit() : bool {
        if (!empty($_SESSION['topggSessionStorage'])) {
            return true;
        }
        return false;
    }

    public static function init() : void {
        $_SESSION['topggSessionStorage'] = new \stdClass;
    }

    // Add an element to cache
    public static function set(string $name, mixed $value) : void {
        if (!self::isInit()) { self::init(); }
        $_SESSION['topggSessionStorage']->{$name} = $value;
    }

    // Is this thing in cache? Idk, just ask to the code
    public static function is(string $name) : bool {
        if (!self::isInit()) { self::init(); }
        if (!empty($_SESSION['topggSessionStorage']->{$name})) {
            return true;
        }
        return false;
    }

    // Get an element from cache
    public static function get(string $name) : mixed {
        if (!self::isInit()) { self::init(); }
        if (self::is($name)) {
            return $_SESSION['topggSessionStorage']->{$name};
        }
        return false;
    }
}