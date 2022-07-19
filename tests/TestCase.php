<?php
namespace Maxwkf\Barsbank\Tests;
use Maxwkf\Barsbank\BarsbankServiceProvider;


class TestCase extends \Orchestra\Testbench\TestCase
{
  protected $client;
  public function setUp(): void
  {
    parent::setUp();
    // additional setup

    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $this->client = new \Maxwkf\Barsbank\ApiClient($_ENV['KEY'], $_ENV['PARK_ID']);

  }

  protected function getPackageProviders($app)
  {
    return [
      BarsbankServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}