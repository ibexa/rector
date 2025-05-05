<?php

namespace Ibexa\Contracts\Rest\Input;

abstract class BaseParser extends Parser
{
}

abstract class Parser
{
    abstract public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed;
}

?>
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Rest\Input\BaseParser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

class SomeParserWithDoc extends BaseParser
{
    /**
     * @return \stdClass
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
    }
}

class SomeParserWithoutDoc extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
    }
}

?>
-----
<?php

namespace Ibexa\Contracts\Rest\Input;

abstract class BaseParser extends Parser
{
}

abstract class Parser
{
    abstract public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed;
}

?>
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Rest\Input\BaseParser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

class SomeParserWithDoc extends BaseParser
{
    /**
     * @return \stdClass
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): \stdClass
    {
    }
}

class SomeParserWithoutDoc extends BaseParser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed
    {
    }
}

?>
