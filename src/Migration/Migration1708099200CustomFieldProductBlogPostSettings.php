<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@sebastianschreier.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\CreateBlogPosts\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;

final class Migration1708099200CustomFieldProductBlogPostSettings extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_productblogpostsettings';

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
        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . '_isblogpost',
                'fieldType' => CustomFieldTypes::BOOL,
                'config' => '{"label": {"de-DE": "Ist ein Blogbeitrag", "en-GB": "is a blog post"}, "componentName": "sw-field", "customFieldType": "checkbox", "customFieldPosition": 1, "type": "checkbox"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    protected function createCustomFieldRelation(Connection $connection, $customFieldSetId): void
    {
        $customFieldRelationId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldRelationSql(),
            [
                'id' => $customFieldRelationId,
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
                'entity_name' => 'product'
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
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 1);
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
        return (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
