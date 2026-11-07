<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@web-solutions-dresden.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\CreateBlogPosts\Storefront\Controller;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\RangeFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
#[Package('storefront')]
class RssController extends StorefrontController
{
    private const FEED_LIMIT = 50;

    public function __construct(
        protected GenericPageLoaderInterface $genericPageLoader,
        protected EntityRepository $productRepository
    ) {
    }

    #[Route(path: '/rss', name: 'frontend.createblogposts.rss', methods: ['GET'])]
    public function rss(Request $request, SalesChannelContext $context): Response
    {
        $criteria = new Criteria();

        $criteria->addFilter(
            new EqualsFilter('active', true),
            new EqualsFilter('visibilities.salesChannelId', $context->getSalesChannelId()),
            new RangeFilter('visibilities.visibility', [
                RangeFilter::GTE => ProductVisibilityDefinition::VISIBILITY_ALL,
            ]),
            new EqualsFilter('customFields.sschreier_productblogpostsettings_isblogpost', true),
            new EqualsFilter('customFields.sschreier_productblogpostsettings_showinrssfeed', true)
        );

        $criteria->setLimit(self::FEED_LIMIT);
        $criteria->addSorting(new FieldSorting('releaseDate', 'DESC'));
        $criteria->addSorting(new FieldSorting('createdAt', 'DESC'));

        $results = $this->productRepository->search($criteria, $context->getContext())->getEntities();

        $page = $this->genericPageLoader->load($request, $context);

        $response = $this->renderStorefront('storefront/custom/rss.html.twig', [
            'results' => $results,
            'page' => $page
        ]);

        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        return $response;
    }
}
