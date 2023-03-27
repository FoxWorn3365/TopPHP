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

namespace TopPHP;
use TopPHP\Components\Bots;
use TopPHP\Parts\Cache;
use TopPHP\Parts\Http;
use TopPHP\Components\Users;
use TopPHP\Parts\Webhooks\Webhook;

class TopPHP {
  public string $token;
  public bool $loadAllData;
  public string $endpoint = 'https://top.gg/api';
  public object $exceptions;
  public array $exceptionsList = [
    'dataMissingException',
    'connectionException',
    'authenticationException',
    'rateLimitException',
    'libraryMissingException',
    'notFoundException',
    'commonException'
  ];
  public Bots $bots;
  public Http $http;
  public Cache $cache;
  public Webhook $webhook;
  public Users $users;

  // Creating the API Interface panel
  function __construct(array $configuration) {
    // Init cache
    // Cache::init();
    $this->token = $configuration['token'];
    $this->loadAllData = $configuration['loadAllData'] ?? false;
    $this->exceptions = new \stdClass;
    $this->http = new Http();
    $this->cache = new Cache();
    $this->refreshChildAccessRate();
  }

  protected function refreshChildAccessRate() : void {
    $this->bots = new Bots($this);
    $this->users = new Users($this);
    $this->webhook = new Webhook($this);
  }

  public function exceptionHandler(string $exception, callable $callback) : bool {
    if (!in_array($exception, $this->exceptionsList)) {
      return false;
    }
    $this->exceptions->{$exception} = $callback;
    $this->refreshChildAccessRate();
    return true;
  }

  public function callableException(string $exception, array $details) : bool {
    if (!in_array($exception, $this->exceptionsList) || empty($this->exceptions->{$exception})) {
      var_dump($this->exceptions);
      return false;
    }
    $function = $this->exceptions->{$exception};
    $function($details);
    return true;
  }
}