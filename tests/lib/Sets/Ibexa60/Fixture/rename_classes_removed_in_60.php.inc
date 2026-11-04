<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

final class RemovedClasses
{
    public function classes(): array
    {
        return [
            \Ibexa\AdminUi\Component\Registry::class,
            \Ibexa\AdminUi\Component\TwigComponent::class,
            \Ibexa\AdminUi\Component\LinkComponent::class,
            \Ibexa\AdminUi\Component\ScriptComponent::class,
            \Ibexa\Contracts\AdminUi\Component\Renderable::class,
            \Ibexa\Contracts\AdminUi\Component\Renderer\RendererInterface::class,
            \Ibexa\AdminUi\Component\Renderer\DefaultRenderer::class,
            \Ibexa\AdminUi\Component\Event\RenderGroupEvent::class,
            \Ibexa\AdminUi\Component\Event\RenderSingleEvent::class,
            \Ibexa\Bundle\AdminUi\DependencyInjection\Compiler\ComponentPass::class,
            \Ibexa\AdminUi\Form\Type\Preview\SiteAccessChoiceType::class,
            \Ibexa\AdminUi\Form\Type\ChoiceList\Loader\SiteAccessPreviewChoiceLoader::class,
            \Ibexa\ContentForms\Content\Form\Provider\GroupedContentFormFieldsProvider::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\AbstractCriterionQuery::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\AbstractSortClause::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\SortDirection::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\CriterionMapperInterface::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\Criterion\AbstractCompositeCriterion::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\Criterion\CriterionInterface::class,
            \Ibexa\Contracts\ProductCatalog\Values\Common\Query\SortClause\FieldValueSortClause::class,
            \Ibexa\ProductCatalog\Common\Pool::class,
            \Ibexa\Bundle\ProductCatalog\Form\Type\LanguageSwitchType::class,
            \Ibexa\Bundle\ProductCatalog\Form\Type\ReferenceCollectionType::class,
            \Ibexa\Bundle\ProductCatalog\Form\Data\AbstractLanguageSwitchData::class,
            \Ibexa\Bundle\Payment\Form\Data\DateRangeData::class,
            \Ibexa\Bundle\Payment\Form\Type\DateRangeType::class,
            \Ibexa\Bundle\Shipping\Form\Data\DateRangeData::class,
            \Ibexa\Bundle\Shipping\Form\Type\DateRangeType::class,
            \Ibexa\Bundle\Messenger\Lock\Store\DoctrineDbalStore::class,
            \Ibexa\Segmentation\Value\Segment::class,
            \Ibexa\Segmentation\Value\SegmentGroup::class,
            \Ibexa\Segmentation\Value\SegmentCreateStruct::class,
            \Ibexa\Segmentation\Value\SegmentUpdateStruct::class,
            \Ibexa\Segmentation\Value\SegmentGroupCreateStruct::class,
            \Ibexa\Segmentation\Value\SegmentGroupUpdateStruct::class,
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\TwigComponents\Component\Registry;
use Ibexa\TwigComponents\Component\TemplateComponent;
use Ibexa\TwigComponents\Component\LinkComponent;
use Ibexa\TwigComponents\Component\ScriptComponent;
use Ibexa\Contracts\TwigComponents\ComponentInterface;
use Ibexa\Contracts\TwigComponents\Renderer\RendererInterface;
use Ibexa\TwigComponents\Component\Renderer\DefaultRenderer;
use Ibexa\Contracts\TwigComponents\Event\RenderGroupEvent;
use Ibexa\Contracts\TwigComponents\Event\RenderSingleEvent;
use Ibexa\Bundle\TwigComponents\DependencyInjection\Compiler\ComponentPass;
use Ibexa\AdminUi\Form\Type\Preview\VersionPreviewUrlChoiceType;
use Ibexa\AdminUi\Form\Type\ChoiceList\Loader\VersionPreviewUrlChoiceLoader;
use Ibexa\ContentForms\Content\Form\Provider\IdentifiedGroupedContentFormFieldsProvider;
use Ibexa\Contracts\CoreSearch\Values\Query\AbstractCriterionQuery;
use Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause;
use Ibexa\Contracts\CoreSearch\Values\Query\SortDirection;
use Ibexa\Contracts\CoreSearch\Values\Query\CriterionMapperInterface;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\AbstractCompositeCriterion;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\CriterionInterface;
use Ibexa\Contracts\CoreSearch\Values\Query\SortClause\FieldValueSortClause;
use Ibexa\Contracts\Core\Pool\Pool;
use Ibexa\AdminUi\Form\Type\LanguageSwitchType;
use Ibexa\AdminUi\Form\Type\ReferenceCollectionType;
use Ibexa\AdminUi\Form\Data\AbstractLanguageSwitchData;
use Ibexa\AdminUi\Form\Data\DateRangeData;
use Ibexa\AdminUi\Form\Type\DateRangeType;
use Symfony\Component\Lock\Store\DoctrineDbalStore;
use Ibexa\Contracts\Segmentation\Value\Segment;
use Ibexa\Contracts\Segmentation\Value\SegmentGroup;
use Ibexa\Contracts\Segmentation\Value\SegmentCreateStruct;
use Ibexa\Contracts\Segmentation\Value\SegmentUpdateStruct;
use Ibexa\Contracts\Segmentation\Value\SegmentGroupCreateStruct;
use Ibexa\Contracts\Segmentation\Value\SegmentGroupUpdateStruct;

final class RemovedClasses
{
    public function classes(): array
    {
        return [
            Registry::class,
            TemplateComponent::class,
            LinkComponent::class,
            ScriptComponent::class,
            ComponentInterface::class,
            RendererInterface::class,
            DefaultRenderer::class,
            RenderGroupEvent::class,
            RenderSingleEvent::class,
            ComponentPass::class,
            VersionPreviewUrlChoiceType::class,
            VersionPreviewUrlChoiceLoader::class,
            IdentifiedGroupedContentFormFieldsProvider::class,
            AbstractCriterionQuery::class,
            AbstractSortClause::class,
            SortDirection::class,
            CriterionMapperInterface::class,
            AbstractCompositeCriterion::class,
            CriterionInterface::class,
            FieldValueSortClause::class,
            Pool::class,
            LanguageSwitchType::class,
            ReferenceCollectionType::class,
            AbstractLanguageSwitchData::class,
            DateRangeData::class,
            DateRangeType::class,
            DateRangeData::class,
            DateRangeType::class,
            DoctrineDbalStore::class,
            Segment::class,
            SegmentGroup::class,
            SegmentCreateStruct::class,
            SegmentUpdateStruct::class,
            SegmentGroupCreateStruct::class,
            SegmentGroupUpdateStruct::class,
        ];
    }
}

?>
