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

class CustomerDataHelper extends AbstractExtension
{
    /** @var Environment */
    private $twigEnvironment;

    public function __construct(
        Environment $twigEnvironment,
        protected EntityRepository $customerRepository
    ) {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'sschreier_get_customer_data_by_product_id',
                [$this, 'getCustomerDataByProductId']
            ),
        ];
    }

    public function getCustomerDataByProductId($customerId, SalesChannelContext $context): array
    {
        $customer = $this->customerRepository->search(
            (new Criteria())
                ->addFilter(new EqualsFilter('id', $customerId)),
            $context->getContext()
        )->getEntities()->first();

        $array = [];
        $array['customer'] = $customer;

        return $array;
    }
}
