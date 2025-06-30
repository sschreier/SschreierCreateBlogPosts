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

final class Migration1708974000AdditionalCustomFieldProductBlogPostSettings extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_productblogpostsettings';

    public function getCreationTimestamp(): int
    {
        return 1708974000;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function update(Connection $connection): void
    {
        $customFieldSetId = $this->getCustomFieldSetId($connection, self::CUSTOM_FIELD_SET_TECHNICAL_NAME);

        $this->createCustomFieldHeadlineNoTeaserImage($connection, $customFieldSetId);
        $this->createCustomFieldTextNoTeaserImage($connection, $customFieldSetId);
    }

    public function updateDestructive(Connection $connection): void
    {
    }

    protected function getCustomFieldSetId(Connection $connection, string $customFieldSetTechnicalName): string
    {
        $sql = 'SELECT `id` FROM `custom_field_set` WHERE `name` = :name';

        return $connection->executeQuery($sql, ['name' => $customFieldSetTechnicalName])->fetchOne();
    }

    protected function createCustomFieldHeadlineNoTeaserImage(Connection $connection, string $customFieldSetId): void
    {
        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . '_headlinenoteaserimage',
                'fieldType' => CustomFieldTypes::TEXT,
                'config' => '{"label": {"de-DE": "Überschrift in dem Bereich, der angezeigt wird, wenn kein Teaserbild zugewiesen wurde", "en-GB": "headline in the area that will be displayed if no teaser image has been assigned"}, "componentName": "sw-field", "customFieldType": "text", "customFieldPosition": 2, "type": "text"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    protected function createCustomFieldTextNoTeaserImage(Connection $connection, string $customFieldSetId): void
    {
        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . '_textnoteaserimage',
                'fieldType' => CustomFieldTypes::TEXT,
                'config' => '{"label": {"de-DE": "Text in dem Bereich, der angezeigt wird, wenn kein Teaserbild zugewiesen wurde", "en-GB": "text in the area that will be displayed if no teaser image has been assigned"}, "componentName": "sw-field", "customFieldType": "text", "customFieldPosition": 3, "type": "text"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    public static function getCustomFieldSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field` (`id`, `name`, `type`, `config`, `active`, `set_id`, `created_at`, `updated_at`, `allow_customer_write`) VALUES
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 1);
            SQL;
    }

    protected static function getDateTimeValue(): string
    {
        return (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
