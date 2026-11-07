<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@web-solutions-dresden.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\CreateBlogPosts\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;

final class Migration1737882000AdditionalCustomFieldProductBlogPostSettings extends MigrationStep
{
    public const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_productblogpostsettings';

    public function getCreationTimestamp(): int
    {
        return 1737882000;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function update(Connection $connection): void
    {
        $customFieldSetId = $this->getCustomFieldSetId($connection, self::CUSTOM_FIELD_SET_TECHNICAL_NAME);

        $this->createCustomFieldHeadlineNoTeaserImage($connection, $customFieldSetId);
    }

    public function updateDestructive(Connection $connection): void
    {
    }

    protected function getCustomFieldSetId(Connection $connection, string $customFieldSetTechnicalName): string
    {
        $sql = 'SELECT `id` FROM `custom_field_set` WHERE `name` = :name';
        $customFieldSetId = $connection->fetchOne($sql, ['name' => $customFieldSetTechnicalName]);

        if (!is_string($customFieldSetId)) {
            throw new \RuntimeException(sprintf(
                'The custom field set "%s" must exist before its fields can be migrated.',
                $customFieldSetTechnicalName
            ));
        }

        return $customFieldSetId;
    }

    protected function createCustomFieldHeadlineNoTeaserImage(Connection $connection, string $customFieldSetId): void
    {
        $name = self::CUSTOM_FIELD_SET_TECHNICAL_NAME . '_showinrssfeed';
        $existingSetId = $connection->fetchOne(
            'SELECT `set_id` FROM `custom_field` WHERE `name` = :name',
            ['name' => $name]
        );

        if ($existingSetId !== false) {
            if (!is_string($existingSetId) || $existingSetId !== $customFieldSetId) {
                throw new \RuntimeException(sprintf('Custom field "%s" belongs to an unexpected set.', $name));
            }

            return;
        }

        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => $name,
                'fieldType' => CustomFieldTypes::BOOL,
                'config' => '{"label": {"de-DE": "im RSS Feed anzeigen", "en-GB": "show in rss feed"}, "componentName": "sw-field", "customFieldType": "checkbox", "customFieldPosition": 4, "type": "checkbox"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    public static function getCustomFieldSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field` (`id`, `name`, `type`, `config`, `active`, `set_id`, `created_at`, `updated_at`, `allow_customer_write`) VALUES
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 0);
            SQL;
    }

    protected static function getDateTimeValue(): string
    {
        return (new \DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
