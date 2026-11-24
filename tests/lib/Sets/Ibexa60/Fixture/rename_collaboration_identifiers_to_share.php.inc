<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AutoconfigureTag('ibexa.collaboration.notification.recipient.factory')]
class CollaborationIdentifiersUsage
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function getJoinUrl(string $token): string
    {
        return $this->urlGenerator->generate('ibexa.collaboration.session.join', ['sessionToken' => $token]);
    }

    public function getMessage(): string
    {
        return $this->translator->trans('ibexa.collaboration.invalid.status', [], 'validators');
    }

    public function getInterval(): string
    {
        return '%ibexa.collaboration.active_session_check.interval%';
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'Ibexa\Contracts\Collaboration\Session\Event\DeleteSessionEvent' => 'onDelete',
            '\Ibexa\Contracts\Collaboration\Session\Event\CreateSessionEvent' => 'onCreate',
        ];
    }

    public function getPaths(): array
    {
        return [
            '@ibexadesign/collaboration/participant/default_avatar.svg.twig',
            '@IbexaCollaborationBundle/Resources/config/routing.yaml',
        ];
    }

    public function getUnchanged(): array
    {
        return [
            'ibexa.collaboration.custom.route',
            'see ibexa.collaboration.session.join for details',
            'Ibexa\Contracts\Collaboration\Session\Event\CustomEvent',
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AutoconfigureTag('ibexa.share.notification.recipient.factory')]
class CollaborationIdentifiersUsage
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function getJoinUrl(string $token): string
    {
        return $this->urlGenerator->generate('ibexa.share.session.join', ['sessionToken' => $token]);
    }

    public function getMessage(): string
    {
        return $this->translator->trans('ibexa.share.invalid.status', [], 'validators');
    }

    public function getInterval(): string
    {
        return '%ibexa.share.active_session_check.interval%';
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'Ibexa\Contracts\Share\Session\Event\DeleteSessionEvent' => 'onDelete',
            '\Ibexa\Contracts\Share\Session\Event\CreateSessionEvent' => 'onCreate',
        ];
    }

    public function getPaths(): array
    {
        return [
            '@ibexadesign/share/participant/default_avatar.svg.twig',
            '@IbexaShareBundle/Resources/config/routing.yaml',
        ];
    }

    public function getUnchanged(): array
    {
        return [
            'ibexa.collaboration.custom.route',
            'see ibexa.collaboration.session.join for details',
            'Ibexa\Contracts\Collaboration\Session\Event\CustomEvent',
        ];
    }
}

?>
