<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa46\Fixture;

use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

$request = new SimplifiedRequest();
$pathInfo = $request->pathinfo;

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa46\Fixture;

use Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest;

$request = new SimplifiedRequest();
$pathInfo = $request->getPathInfo();

?>
