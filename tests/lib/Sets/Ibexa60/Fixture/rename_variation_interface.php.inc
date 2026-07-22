<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\Core\Imagine\VariationPathGenerator;

class SomeFormatVariationGenerator implements VariationPathGenerator
{
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\Core\Variation\VariationPathGenerator;

class SomeFormatVariationGenerator implements VariationPathGenerator
{
}

?>
