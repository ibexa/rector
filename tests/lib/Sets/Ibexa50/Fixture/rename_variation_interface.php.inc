<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\Core\Imagine\VariationPathGenerator; // kept as-is by Rector

class SomeFormatVariationGenerator implements VariationPathGenerator
{
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Bundle\Core\Imagine\VariationPathGenerator; // kept as-is by Rector

class SomeFormatVariationGenerator implements \Ibexa\Contracts\Core\Variation\VariationPathGenerator
{
}

?>
