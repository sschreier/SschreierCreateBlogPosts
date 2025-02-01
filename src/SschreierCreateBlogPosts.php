<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@sebastianschreier.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\CreateBlogPosts;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class SschreierCreateBlogPosts extends Plugin
{
    const PLUGIN_CONFIG_VARS = [
        'opacityNoTeaserImage',
        'paddingNoTeaserImage',
        'headlineNoTeaserImageFontSize',
        'headlineNoTeaserImageLineHeight',
        'textNoTeaserImageFontSize',
        'textNoTeaserImageLineHeight',
        'textNoTeaserImageLineClamp',
    ];
    const CUSTOM_FIELD_SET_PRODUCT_TECHNICAL_NAME = 'sschreier_productblogpostsettings';
    const CUSTOM_FIELD_SET_CATEGORY_TECHNICAL_NAME = 'sschreier_categoryblogpostsettings';

    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
    }

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

    private function removeCustomField($customFieldSetName, $uninstallContext): void
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', $customFieldSetName));

        $result = $customFieldSetRepository->searchIds($criteria, $uninstallContext);

        if ($result->getTotal() > 0) {
            $data = $result->getDataOfId($result->firstId());
            $customFieldSetRepository->delete([$data], $uninstallContext);
        }
    }
}
