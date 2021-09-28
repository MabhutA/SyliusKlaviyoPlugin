<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusKlaviyoPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\SyliusKlaviyoPlugin\DependencyInjection\Configuration;
use Setono\SyliusKlaviyoPlugin\Model\MemberList;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyConfigTest
 */
final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function values_are_invalid_if_required_value_is_not_provided(): void
    {
        $this->assertConfigurationIsInvalid(
            [
                [], // no values at all
            ],
            'The child config "credentials" under "setono_sylius_klaviyo" must be configured.'
        );
    }

    /**
     * @test
     */
    public function processed_value_contains_required_value(): void
    {
        $this->assertProcessedConfigurationEquals([
            [
                'credentials' => [
                    'public_token' => 'first value',
                    'private_token' => 'first value',
                ],
            ],
            [
                'credentials' => [
                    'public_token' => 'last value',
                    'private_token' => 'last value',
                ],
            ],
        ], [
            'credentials' => [
                'public_token' => 'last value',
                'private_token' => 'last value',
            ],
            'driver' => SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            'resources' => [
                'member_list' => [
                    'classes' => [
                        'model' => MemberList::class,
                    ],
                ],
            ],
        ]);
    }
}
