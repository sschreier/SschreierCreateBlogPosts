<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@web-solutions-dresden.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\CreateBlogPosts;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class SschreierCreateBlogPosts extends Plugin
{
    public const PLUGIN_CONFIG_VARS = [
        'opacityNoTeaserImage',
        'paddingNoTeaserImage',
        'headlineNoTeaserImageFontSize',
        'headlineNoTeaserImageLineHeight',
        'textNoTeaserImageFontSize',
        'textNoTeaserImageLineHeight',
        'textNoTeaserImageLineClamp',
    ];
    public const CUSTOM_FIELD_SET_PRODUCT_TECHNICAL_NAME = 'sschreier_productblogpostsettings';
    public const CUSTOM_FIELD_SET_CATEGORY_TECHNICAL_NAME = 'sschreier_categoryblogpostsettings';

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData()) {
            parent::uninstall($uninstallContext);

            return;
        }

        $this->removeCustomField(self::CUSTOM_FIELD_SET_PRODUCT_TECHNICAL_NAME, $uninstallContext->getContext());
        $this->removeCustomField(self::CUSTOM_FIELD_SET_CATEGORY_TECHNICAL_NAME, $uninstallContext->getContext());

        parent::uninstall($uninstallContext);
    }

    private function removeCustomField(string $customFieldSetName, Context $context): void
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', $customFieldSetName));

        $result = $customFieldSetRepository->searchIds($criteria, $context);
        $customFieldSetId = $result->firstId();

        if ($customFieldSetId !== null) {
            $customFieldSetRepository->delete([['id' => $customFieldSetId]], $context);
        }
    }
}
