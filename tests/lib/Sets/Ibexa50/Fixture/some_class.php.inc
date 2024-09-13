<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider;

class FooBar {
    public function foo(): RepositoryConfigurationProvider
    {
        return $this->bar(RepositoryConfigurationProvider::class);
    }

    public function bar(string $class): RepositoryConfigurationProvider
    {
        return new $class();
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Core\Container\ApiLoader\RepositoryConfigurationProviderInterface;

class FooBar {
    public function foo(): RepositoryConfigurationProviderInterface
    {
        return $this->bar(RepositoryConfigurationProviderInterface::class);
    }

    public function bar(string $class): RepositoryConfigurationProviderInterface
    {
        return new $class();
    }
}

?>
