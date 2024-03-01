<?php
declare(strict_types=1);

namespace Sschreier\CreateBlogPosts\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Theme\Event\ThemeCompilerEnrichScssVariablesEvent;
use Sschreier\CreateBlogPosts\SschreierCreateBlogPosts;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class ThemeVariablesSubscriber implements EventSubscriberInterface
{
    private SystemConfigService $systemConfig;

    public function __construct(SystemConfigService $systemConfig)
    {
        $this->systemConfig = $systemConfig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ThemeCompilerEnrichScssVariablesEvent::class => 'onAddVariables',
        ];
    }

    public function onAddVariables(ThemeCompilerEnrichScssVariablesEvent $event): void
    {
        $configFields = $this->systemConfig->get('SschreierCreateBlogPosts.config', $event->getSalesChannelId());

        foreach($configFields as $configKey => $value) {
            // convert `customVariableName` to `custom-variable-name`
            $kebabCasedScssVariable = str_replace('_', '-', (new CamelCaseToSnakeCaseNameConverter())->normalize($configKey));

            if($value && in_array($configKey, SschreierCreateBlogPosts::PLUGIN_CONFIG_VARS)) {
                $event->addVariable(
                    'sschreier-' . $kebabCasedScssVariable,
                    (string) $value
                );
            }
        }
    }
}
