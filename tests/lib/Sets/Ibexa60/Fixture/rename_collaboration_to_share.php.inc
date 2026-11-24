<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\Collaboration\IbexaCollaborationBundle;
use Ibexa\Bundle\Collaboration\Migration\InstallSchemaMigration;
use Ibexa\Collaboration\Session\SessionLinkResolverInterface;
use Ibexa\Contracts\Collaboration\Session\Event\CreateSessionEvent;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;

class CollaborationUsage
{
    public function __construct(
        private readonly SessionServiceInterface $sessionService,
        private readonly SessionLinkResolverInterface $sessionLinkResolver
    ) {
    }

    /**
     * @return array<class-string>
     */
    public function getClasses(): array
    {
        return [
            IbexaCollaborationBundle::class,
            InstallSchemaMigration::class,
            CreateSessionEvent::class,
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Share\SessionServiceInterface;
use Ibexa\Share\Session\SessionLinkResolverInterface;
use Ibexa\Bundle\Share\IbexaShareBundle;
use Ibexa\Bundle\Share\Migration\InstallCollaborationSchemaMigration;
use Ibexa\Contracts\Share\Session\Event\CreateSessionEvent;

class CollaborationUsage
{
    public function __construct(
        private readonly SessionServiceInterface $sessionService,
        private readonly SessionLinkResolverInterface $sessionLinkResolver
    ) {
    }

    /**
     * @return array<class-string>
     */
    public function getClasses(): array
    {
        return [
            IbexaShareBundle::class,
            InstallCollaborationSchemaMigration::class,
            CreateSessionEvent::class,
        ];
    }
}

?>
