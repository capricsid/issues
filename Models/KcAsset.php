<?php

namespace Cx\Admin\Extension\Models;

use Cx\Framework\Models\CxResourceBaseModel;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\ResultInterface;
use Phalcon\Mvc\Model\Resultset;

/**
 * Class KcAsset
 * @package Cx\Admin\Extension
 *
 */
class KcAsset extends CxResourceBaseModel
{

    //region Properties

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $file_path;

    /**
     * @var string
     */
    protected $mime_type;

    /**
     * @var int
     */
    protected $date_created;

    /**
     * @var int
     */
    protected $date_audited;

    /**
     * @var int
     */
    protected $date_deleted;

    /**
     * @var int
     */
    protected $audited_by;

    /**
     * @var int
     */
    protected $deleted_by;

    //endregion

    //region Properties getters/setters

    /**
     * Returns value of field id
     *
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Method to set value of field id
     *
     * @param int $id
     * @return self
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return self
     */
    public function setName($name) : self {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the value of field file_path
     *
     * @return string
     */
    public function getFilePath() {
        return $this->file_path;
    }

    /**
     * Method to set the value of field file_path
     *
     * @param string $file_path
     * @return self
     */
    public function setFilePath($file_path) : self {
        $this->file_path = $file_path;
        return $this;
    }

    /**
     * Returns the value of field mime_type
     *
     * @return string
     */
    public function getMimeType() {
        return $this->mime_type;
    }

    /**
     * Method to set the value of field mime_type
     *
     * @param string $mime_type
     * @return self
     */
    public function setMimeType($mime_type) : self {
        $this->mime_type = $mime_type;
        return $this;
    }

    /**
     * Returns the value of field date_created
     *
     * @return int
     */
    public function getDateCreated(): int {
        return $this->date_created;
    }

    /**
     * Method to set the value of field date_created
     *
     * @param int $date_created
     * @return self
     */
    public function setDateCreated($date_created): self {
        $this->date_created = $date_created;
        return $this;
    }

    /**
     * Returns the value of field date_audited
     *
     * @return int|null
     */
    public function getDateAudited(): ?int {
        return $this->date_audited;
    }

    /**
     * Method to set the value of field date_audited
     *
     * @param int|null $date_audited
     * @return self
     */
    public function setDateAudited(?int $date_audited): self {
        $this->date_audited = $date_audited;
        return $this;
    }

    /**
     * Returns the value of field date_deleted
     *
     * @return int|null
     */
    public function getDateDeleted(): ?int {
        return $this->date_deleted;
    }

    /**
     * Method to set the value of field date_deleted
     *
     * @param int|null $date_deleted
     * @return self
     */
    public function setDateDeleted(?int $date_deleted): self {
        $this->date_deleted = $date_deleted;
        return $this;
    }

    /**
     * Returns the value of field audited_by
     *
     * @return int|null
     */
    public function getAuditedBy(): ?int {
        return $this->audited_by;
    }

    /**
     * Method to set the value of field audited_by
     *
     * @param int|null $audited_by
     * @return self
     */
    public function setAuditedBy(?int $audited_by) {
        $this->audited_by = $audited_by;
        return $this;
    }

    /**
     * Returns the value of field deleted_by
     *
     * @return int|null
     */
    public function getDeletedBy(): ?int {
        return $this->deleted_by;
    }

    /**
     * Method to set the value of field deleted_by
     *
     * @param int|null $deleted_by
     * @return self
     */
    public function setDeletedBy(?int $deleted_by) {
        $this->deleted_by = $deleted_by;
        return $this;
    }

    //endregion

    //region Init and validation

    /**
     * Initialize method for model.
     */
    public function initialize() {
        // Run base initialize code
        parent::initialize();
        // Configure related Models
        $this->hasManyToMany(
            'id', KcAssetCat::class, 'asset_id',
            'category_id', KcCategory::class, "id",
            array(
                'alias' => 'KcCategories',
                'foreignKey' => true,
                'cxAction' => static::ACTION_CASCADE_DELETE
            )
        );

        $this->hasManyToMany(
            'id', KcAssetTag::class, 'asset_id',
            'tag_id', KcTag::class, "id",
            array(
                'alias' => 'KcTags',
                'foreignKey' => true,
                'cxAction' => static::ACTION_CASCADE_DELETE
            )
        );

        $this->hasManyToMany(
            'id', KcAssetCollection::class, 'asset_id',
            'collection_id', KcCollection::class, "id",
            array(
                'alias' => 'KcCollections',
                'foreignKey' => true,
                'cxAction' => static::ACTION_CASCADE_DELETE
            )
        );

    }

    //region Static methods

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return static::getTableName();
    }

    /**
     * Return the model source table name in static way
     *
     * @return string
     */
    public static function getTableName() {
        return 'kc_asset';
    }

    /**
     * Return the collection id related to the asset
     *
     * @param $assetId
     * @return array |ResultInterface
     */
    public static function getAssetCollectionId($assetId): array
    {
        $queryBuilder = new Builder();
        return $queryBuilder
        ->from(['col'=>KcCollection::class])
        ->innerJoin(KcAssetCollection::class, 'col.id = ac.collection_id', 'ac')
        ->innerJoin(KcAsset::class, 'asset.id = ac.asset_id', 'asset')
        ->columns('col.id')
        ->where('asset.id = :ASSET_ID:')
        ->limit(1)
        ->getQuery()
        ->execute([
            'ASSET_ID' => $assetId,
        ])->toArray() ;
    }

    /**
     * Return the category id related to the asset
     *
     * @param $assetId
     * @return array |ResultInterface
     */
    public static function getAssetCategoryId($assetId): array
    {
        $queryBuilder = new Builder();
        return $queryBuilder
            ->from(['cat'=>KcCategory::class])
            ->innerJoin(KcAssetCat::class, 'cat.id = ac.category_id', 'ac')
            ->innerJoin(KcAsset::class, 'asset.id = ac.asset_id', 'asset')
            ->columns('cat.id')
            ->where('asset.id = :ASSET_ID:')
            ->limit(1)
            ->getQuery()
            ->execute([
                'ASSET_ID' => $assetId,
            ])->toArray() ;
    }

    /**
     * Return the tag id related to the asset
     *
     * @param $assetId
     * @return array |ResultInterface
     */
    public static function getAssetTagId($assetId): array
    {
        $queryBuilder = new Builder();
        return $queryBuilder
            ->from(['tag'=>KcTag::class])
            ->innerJoin(KcAssetTag::class, 'tag.id = at.tag_id', 'at')
            ->innerJoin(KcAsset::class, 'asset.id = at.asset_id', 'asset')
            ->columns('tag.id')
            ->where('asset.id = :ASSET_ID:')
            ->limit(1)
            ->getQuery()
            ->execute([
                'ASSET_ID' => $assetId,
            ])->toArray() ;
    }

    //endregion

    //region Resource interface implementation

    /**
     * Return all the available actions that can be profiled in ACL
     *
     * @return array
     */
    public static function getClassResourceActions() {
        return [
            'CREATE' => 'Create new Kc Asset',
            'VIEW' => 'View Kc Asset',
            'EDIT' => 'Edit Kc Asset'
        ];
    }
    public static function getAssetsWithTagAndCategory($id,$currentPage,$perPage)
    {

        $pageOffset = ($currentPage - 1) * $perPage;
        $queryBuilder = new Builder();
        $assets = $queryBuilder
            ->columns([
                'Assets.id',
                'Assets.name',
                'Assets.file_path',
                'GROUP_CONCAT(DISTINCT KcCategory.name) as categories',
                'GROUP_CONCAT(DISTINCT KcTag.name) as tags',
                'KcCollection.name as collection_title'
            ])
            ->from(['Assets' => static::class])
            ->leftJoin(KcAssetCat::class, 'Categories.asset_id = Assets.id', 'Categories')
            ->leftJoin(KcCategory::class, 'KcCategory.id = Categories.category_id','KcCategory')
            ->leftJoin(KcAssetTag::class, 'Tags.asset_id = Assets.id', 'Tags')
            ->leftJoin(KcTag::class, 'KcTag.id = Tags.tag_id','KcTag')
            ->leftJoin(KcAssetCollection::class, 'Collections.asset_id = Assets.id', 'Collections')
            ->leftJoin(KcCollection::class, 'KcCollection.id = Collections.collection_id','KcCollection')
            ->where('KcCategory.id = :category_id:',[
                'category_id' => $id
            ])
            ->groupBy('Assets.id')->limit($perPage)
            ->offset($pageOffset);

        return $assets;
    }
}