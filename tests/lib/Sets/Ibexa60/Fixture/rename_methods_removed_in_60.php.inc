<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\ProductCatalog\UI\ProductSelector\BaseProduct;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface;
use Ibexa\Core\MVC\Symfony\Controller\Controller;
use Ibexa\Dashboard\Migration\AssignDashboardToUser;
use Ibexa\Migration\ValueObject\Step\Action\Content\AssignParentLocation;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\AssignContentTypeGroup;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\RemoveFieldByIdentifier;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\UnassignContentTypeGroup;

final class SomeController extends Controller
{
    public function render(): string
    {
        return $this->getTemplateEngine()->render('template.html.twig');
    }
}

final class SomeActionReader
{
    public function read(
        AssignDashboardToUser $assignDashboard,
        AssignParentLocation $assignParentLocation,
        AssignContentTypeGroup $assignGroup,
        UnassignContentTypeGroup $unassignGroup,
        RemoveFieldByIdentifier $removeField,
    ): array {
        return [
            $assignDashboard->getValue(),
            $assignParentLocation->getValue(),
            $assignGroup->getValue(),
            $unassignGroup->getValue(),
            $removeField->getValue(),
        ];
    }
}

final class SomeProductReader
{
    public function read(AvailabilityInterface $availability, BaseProduct $product): bool
    {
        $product->setBasePrice($product->getBasePrice());

        return $availability->isAvailable();
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Bundle\ProductCatalog\UI\ProductSelector\BaseProduct;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface;
use Ibexa\Core\MVC\Symfony\Controller\Controller;
use Ibexa\Dashboard\Migration\AssignDashboardToUser;
use Ibexa\Migration\ValueObject\Step\Action\Content\AssignParentLocation;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\AssignContentTypeGroup;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\RemoveFieldByIdentifier;
use Ibexa\Migration\ValueObject\Step\Action\ContentType\UnassignContentTypeGroup;

final class SomeController extends Controller
{
    public function render(): string
    {
        return $this->getTwig()->render('template.html.twig');
    }
}

final class SomeActionReader
{
    public function read(
        AssignDashboardToUser $assignDashboard,
        AssignParentLocation $assignParentLocation,
        AssignContentTypeGroup $assignGroup,
        UnassignContentTypeGroup $unassignGroup,
        RemoveFieldByIdentifier $removeField,
    ): array {
        return [
            $assignDashboard->getUserLogin(),
            $assignParentLocation->getLocationId(),
            $assignGroup->getGroupName(),
            $unassignGroup->getGroupName(),
            $removeField->getIdentifier(),
        ];
    }
}

final class SomeProductReader
{
    public function read(AvailabilityInterface $availability, BaseProduct $product): bool
    {
        $product->setPrice($product->getPrice());

        return $availability->getComputedAvailability();
    }
}

?>
