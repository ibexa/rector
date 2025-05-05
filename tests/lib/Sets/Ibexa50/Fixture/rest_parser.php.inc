<?php

namespace Ibexa\Contracts\Rest\Input;

abstract class Parser
{
    abstract public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed;
}

?>
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Rest\Input\Parser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

class SomeParserWithDoc extends Parser
{
    /**
     * @return \stdClass
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
    }
}

class SomeParserWithoutDoc extends Parser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
    }
}

?>
-----
<?php

namespace Ibexa\Contracts\Rest\Input;

abstract class Parser
{
    abstract public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed;
}

?>
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

use Ibexa\Contracts\Rest\Input\Parser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

class SomeParserWithDoc extends Parser
{
    /**
     * @return \stdClass
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): \stdClass
    {
    }
}

class SomeParserWithoutDoc extends Parser
{
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): mixed
    {
    }
}

?>
