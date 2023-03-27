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
use TopPHP\Parts\Cache;

class Http {
    protected static function request(string $protocol, string $url, string $token, mixed $body = NULL) : mixed {
        $body = $body ?? [];
        $options = stream_context_create(array( 
          'http' => array(
              'header' => "Accept: application/json\r\n" .
                          "Authorization: {$token}\r\n" . 
                          "User-Agent: request\r\n",
              'method' => $protocol,
              'content' => http_build_query($body),
              // 'ignore_errors' => true
          )
        )); 
        $response = @json_decode(file_get_contents($url, false, $options));
        return $response;
    }
  
    public static function get(string $url, string $token, mixed $body = NULL) : mixed {
        if (Cache::is($url)) {
          return Cache::get($url);
        }
        $response = self::request('GET', $url, $token, $body);
        Cache::set($url, $response);
        return $response;
    }
  
    public static function fetch(string $url, string $token, mixed $body = NULL) : mixed {
        $response = self::request('GET', $url, $token, $body);
        return $response;
    }

    public static function post(string $url, string $token, mixed $body = NULL) : mixed {
        return self::request('POST', $url, $token, $body);
    } 
}