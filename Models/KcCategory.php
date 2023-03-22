<?php

namespace Cx\Admin\Extension\Models;

use Cx\Framework\Models\CxResourceBaseModel;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Class KcCategory
 * @package Cx\DjbKc
 *
 */
class KcCategory extends CxResourceBaseModel
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
     * @var int
     */
    protected $parent_category_id;

    /**
     * @var string
     */
    protected $parent_category_path;

    /**
     * @var string
     */
    protected $category_path;

    /**
     * @var string
     */
    protected $parent_category_path_names;

    /**
     * @var string
     */
    protected $category_path_names;

    /**
     * @var int
     */
    protected $status;

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
    public function getId() {
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
     * Returns value of field parent_category_id
     *
     * @return int
     */
    public function getParentCategoryId() {
        return $this->parent_category_id;
    }

    /**
     * Method to set value of field parent_category_id
     *
     * @param int|null $parent_category_id
     * @return self
     */
    public function setParentCategoryId($parent_category_id): self {
        $this->parent_category_id = $parent_category_id;
        return $this;
    }

    /**
     * Returns the value of field parent_category_path
     *
     * @return string
     */
    public function getParentCategoryPath() {
        return $this->parent_category_path;
    }

    /**
     * Method to set the value of field parent_category_path
     *
     * @param string $parent_category_path
     * @return self
     */
    public function setParentCategoryPath($parent_category_path) : self {
        $this->parent_category_path = $parent_category_path;
        return $this;
    }

    /**
     * Returns the value of field category_path
     *
     * @return string
     */
    public function getCategoryPath() {
        return $this->category_path;
    }

    /**
     * Method to set the value of field category_path
     *
     * @param string $category_path
     * @return self
     */
    public function setCategoryPath($category_path) : self {
        $this->category_path = $category_path;
        return $this;
    }

    /**
     * Returns the value of field parent_category_path_names
     *
     * @return string
     */
    public function getParentCategoryPathNames() {
        return $this->parent_category_path_names;
    }

    /**
     * Method to set the value of field parent_category_path_names
     *
     * @param string $parent_category_path_names
     * @return self
     */
    public function setParentCategoryPathNames($parent_category_path_names) : self {
        $this->parent_category_path_names = $parent_category_path_names;
        return $this;
    }

    /**
     * Returns the value of field category_path_names
     *
     * @return string
     */
    public function getCategoryPathNames() {
        return $this->category_path_names;
    }

    /**
     * Method to set the value of field category_path_names
     *
     * @param string $category_path_names
     * @return self
     */
    public function setCategoryPathNames($category_path_names) : self {
        $this->category_path_names = $category_path_names;
        return $this;
    }

    /**
     * Returns the value of field status
     *
     * @return int
     */
    public function getStatus(): int {
        return $this->status;
    }

    /**
     * Method to set the value of field status
     *
     * @param int $status
     * @return self
     */
    public function setStatus(int $status): self {
        $this->status = $status;
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
            'id', KcAssetCat::class, 'category_id',
            'asset_id', KcAsset::class, "id",
            array(
                'alias' => 'KcAssets',
                'foreignKey' => true,
                'cxAction' => static::ACTION_CASCADE_DELETE
            )
        );

        $this->hasMany(
            'id',
            KcCategory::class,
            'parent_category_id',
            [
                'alias' => 'ChildCategories',
                'foreignKey' => [
                    'message' => 'The category cannot be deleted because other categories depend on it.',
                ],
            ]
        );

        $this->belongsTo(
            'parent_category_id',
            KcCategory::class,
            'id',
            [
                'alias' => 'ParentCategory',
                'foreignKey' => [
                    'message' => 'The parent category does not exist.',
                ],
            ]
        );
    }

    public function afterDelete()
    {
        foreach ($this->ChildCategories as $childCategory) {
            if (!$childCategory->delete()) {
                throw new Exception('Unable to delete child category.');
            }
        }
    }

    //region Static methods

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource(): string
    {
        return static::getTableName();
    }

    /**
     * @param array $parameters
     *
     * @return ResultsetInterface
     */
    public static function find($parameters = array()) {
        return parent::find($parameters);
    }

    /**
     * @param array $parameters
     *
     * @return KcCategory|Model
     */
    public static function findFirst($parameters = array()) {
        return parent::findFirst($parameters);
    }

    /**
     * Return the model source table name in static way
     *
     * @return string
     */
    public static function getTableName() {
        return 'kc_category';
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
            'CREATE' => 'Create new Kc Category',
            'VIEW' => 'View Kc Category',
            'EDIT' => 'Edit Kc Category'
        ];
    }

    public static function getTopLevelCategories($columns,$orderBy) {
        $queryBuilder = new Builder();

        return $queryBuilder->from(array(static::class))->columns($columns)
            ->where('parent_category_id = 0')
            ->orderBy($orderBy)->getQuery()->execute()
            ->setHydrateMode(Resultset::HYDRATE_ARRAYS)->toArray();
    }

    public static function searchCategories($columns,$orderBy,$searchQuery) {

        $queryBuilder = new Builder();

        return $queryBuilder->from(array(static::class))->columns($columns)
            ->where(
                "category_path_names LIKE :query:",
                [
                    'query' => '%' . $searchQuery . '%',
                ]
            )
            ->orderBy($orderBy)->getQuery()->execute()
            ->setHydrateMode(Resultset::HYDRATE_ARRAYS)->toArray();
    }

    public static function getChildCategories($columns,$orderBy,$id) {

        $queryBuilder = new Builder();

        return $queryBuilder->from(array(static::class))->columns($columns)
            ->where(
                "parent_category_id = :query:",
                [
                    'query' => $id,
                ]
            )
            ->orderBy($orderBy)->getQuery()->execute()
            ->setHydrateMode(Resultset::HYDRATE_ARRAYS)->toArray();
    }

    public static function getPath($columns,$orderBy,$idsArray) {

        $queryBuilder = new Builder();

        return $queryBuilder->from(array(static::class))->columns($columns)
            ->where('id IN ({values:array})', ['values' => $idsArray])
            ->orderBy($orderBy)->getQuery()->execute()
            ->setHydrateMode(Resultset::HYDRATE_ARRAYS)->toArray();
    }


}