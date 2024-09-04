<?php /** @noinspection ALL */

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class SomeClassWithTwigFunctions extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'old_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                    'deprecated' => '4.0',
                    'alternative' => 'new_function_name',
                ]
            ),
            new TwigFunction(
                'new_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'old_filter',
                [$this, 'someCallback'],
                ['deprecated' => '4.0']
            ),
            new TwigFilter(
                'new_filter',
                [$this, 'someCallback'],
            ),
        ];
    }
}

?>
-----
<?php /** @noinspection ALL */

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class SomeClassWithTwigFunctions extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'new_function_name',
                null,
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'new_filter',
                [$this, 'someCallback'],
            ),
        ];
    }
}

?>
