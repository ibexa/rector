<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\DependencyInjection\AutoTranslateServiceTags;

final class SomeCompilerPass
{
    public function tags(): array
    {
        return [
            AutoTranslateServiceTags::PROVIDER_LANGUAGE_NORMALIZER,
            AutoTranslateServiceTags::PROVIDER_AI_TRANSLATION_STRATEGY,
            AutoTranslateServiceTags::REVIEW_STATUS_CONTEXT_RESOLVER,
            AutoTranslateServiceTags::PROVIDER,
        ];
    }
}

?>
-----
<?php

namespace Ibexa\Rector\Tests\Sets\Ibexa60\Fixture;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\LanguageNormalizer\LanguageNormalizerInterface;
use Ibexa\TranslationsManagement\AutoTranslate\Ai\AiTranslationStrategyInterface;
use Ibexa\TranslationsManagement\AutoTranslate\ReviewStatus\ContextResolver\ContextResolverInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\DependencyInjection\AutoTranslateServiceTags;

final class SomeCompilerPass
{
    public function tags(): array
    {
        return [
            LanguageNormalizerInterface::SERVICE_TAG,
            AiTranslationStrategyInterface::SERVICE_TAG,
            ContextResolverInterface::SERVICE_TAG,
            AutoTranslateServiceTags::PROVIDER,
        ];
    }
}

?>
