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

final class Migration1708099200CustomFieldCategoryBlogPostSettings extends MigrationStep
{
    public const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_categoryblogpostsettings';

    public function getCreationTimestamp(): int
    {
        return 1708099200;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function update(Connection $connection): void
    {
        $customFieldSetId = $this->createCustomFieldSet($connection);

        $this->createCustomField($connection, $customFieldSetId);

        $this->createCustomFieldRelation($connection, $customFieldSetId);
    }

    public function updateDestructive(Connection $connection): void
    {
    }

    protected function createCustomFieldSet(Connection $connection): string
    {
        $existingId = $connection->fetchOne(
            'SELECT `id` FROM `custom_field_set` WHERE `name` = :name',
            ['name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME]
        );

        if (is_string($existingId)) {
            return $existingId;
        }

        $customFieldSetId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSetSql(),
            [
                'id' => $customFieldSetId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME,
                'config' => '{"label": {"de-DE": "Blogbeitragseinstellungen", "en-GB": "blog post settings"}, "translated": true}',
                'position' => 1,
                'created_at' => self::getDateTimeValue(),
            ]
        );

        return $customFieldSetId;
    }

    protected function createCustomField(Connection $connection, string $customFieldSetId): void
    {
        $name = self::CUSTOM_FIELD_SET_TECHNICAL_NAME . '_isblogpostcategory';
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
                'config' => '{"label": {"de-DE": "Ist eine Blogbeitragskategorie", "en-GB": "is a blog post category"}, "componentName": "sw-field", "customFieldType": "checkbox", "customFieldPosition": 1, "type": "checkbox"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    protected function createCustomFieldRelation(Connection $connection, string $customFieldSetId): void
    {
        $entityName = 'category';
        $existingRelationId = $connection->fetchOne(
            'SELECT `id` FROM `custom_field_set_relation` WHERE `set_id` = :set_id AND `entity_name` = :entity_name',
            ['set_id' => $customFieldSetId, 'entity_name' => $entityName]
        );

        if (is_string($existingRelationId)) {
            return;
        }

        $customFieldRelationId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldRelationSql(),
            [
                'id' => $customFieldRelationId,
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
                'entity_name' => $entityName
            ],
        );
    }

    protected static function getCustomFieldSetSql(): string
    {
        return <<<SQL
            INSERT INTO `custom_field_set` (`id`, `name`, `config`, `active`, `app_id`, `position`, `global`, `created_at`, `updated_at`) VALUES
            (:id, :name, :config, 1, NULL, :position, 0, :created_at, NULL);
            SQL;
    }

    public static function getCustomFieldSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field` (`id`, `name`, `type`, `config`, `active`, `set_id`, `created_at`, `updated_at`, `allow_customer_write`) VALUES
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 0);
            SQL;
    }

    public static function getCustomFieldRelationSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field_set_relation` (`id`, `set_id`, `entity_name`, `created_at`, `updated_at`) VALUES
                (:id, :set_id, :entity_name, :created_at, NULL);
            SQL;
    }

    protected static function getDateTimeValue(): string
    {
        return (new \DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
