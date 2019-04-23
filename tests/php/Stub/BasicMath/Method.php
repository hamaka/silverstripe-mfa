<?php
namespace SilverStripe\MFA\Tests\Stub\BasicMath;

use SilverStripe\Control\Director;
use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\Dev\TestOnly;
use SilverStripe\MFA\Method\Handler\LoginHandlerInterface;
use SilverStripe\MFA\Method\Handler\RegisterHandlerInterface;
use SilverStripe\MFA\Method\MethodInterface;
use SilverStripe\MFA\State\AvailableMethodDetails;
use SilverStripe\MFA\State\AvailableMethodDetailsInterface;

class Method implements MethodInterface, TestOnly
{
    /**
     * Get a URL segment for this method. This will be used in URL paths for performing authentication by this method
     *
     * @return string
     */
    public function getURLSegment(): string
    {
        return 'basic-math';
    }

    /**
     * Return the LoginHandler that is used to start and verify login attempts with this method
     *
     * @return LoginHandlerInterface
     */
    public function getLoginHandler(): LoginHandlerInterface
    {
        return new MethodLoginHandler();
    }

    /**
     * Return the RegisterHandler that is used to perform registrations with this method
     *
     * @return RegisterHandlerInterface
     */
    public function getRegisterHandler(): RegisterHandlerInterface
    {
        return new MethodRegisterHandler();
    }

    public function getThumbnail(): string
    {
        return (string) ModuleLoader::getModule('silverstripe/mfa')
            ->getResource('client/dist/images/totp.svg')
            ->getURL();
    }

    public function applyRequirements(): void
    {
        // noop
    }

    public function isAvailable(): bool
    {
        return Director::isDev();
    }

    public function getUnavailableMessage(): string
    {
        return 'This is a test authenticator, only available in dev mode for tests.';
    }
}