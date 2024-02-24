<?php
declare(strict_types=1);

namespace Sschreier\CreateBlogPosts\Core\Twig;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProductDataHelper extends AbstractExtension
{
    /** @var Environment */
    private $twigEnvironment;

    public function __construct(
        Environment $twigEnvironment,
        protected EntityRepository $productRepository
    ) {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'sschreier_get_product_data_by_product_id',
                [$this, 'getProductDataByProductId']
            ),
        ];
    }

    public function getProductDataByProductId($productId, SalesChannelContext $context): array
    {
        $product = $this->productRepository->search(
            (new Criteria())
                ->addFilter(new EqualsFilter('id', $productId)),
            $context->getContext()
        )->getEntities()->first();

        $array = [];
        $array['product'] = $product;

        return $array;
    }
}
