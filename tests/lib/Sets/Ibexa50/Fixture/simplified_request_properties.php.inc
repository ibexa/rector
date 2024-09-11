<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

$request = new \Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest();
$pathInfo = $request->pathinfo;

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa50\Fixture;

$request = new \Ibexa\Core\MVC\Symfony\Routing\SimplifiedRequest();
$pathInfo = $request->getPathInfo();

?>
