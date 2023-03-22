<?php

namespace Cx\Admin\Extension\Models;

use Cx\Framework\Models\CxResourceBaseModel;

/**
 * Class KcAssetCat
 * @package Cx\Admin\Extension
 *
 */
class KcAssetCat extends CxResourceBaseModel
{

    //region Properties

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $asset_id;

    /**
     * @var int
     */
    protected $category_id;

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
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns value of field asset_id
     *
     * @return int
     */
    public function getAssetId(): int {
        return $this->asset_id;
    }

    /**
     * Method to set value of field asset_id
     *
     * @param int $asset_id
     * @return self
     */
    public function setAssetId(int $asset_id): self {
        $this->asset_id = $asset_id;
        return $this;
    }

    /**
     * Returns value of field category_id
     *
     * @return int
     */
    public function getCategoryId(): int {
        return $this->category_id;
    }

    /**
     * Method to set value of field category_id
     *
     * @param int $category_id
     * @return self
     */
    public function setCategoryId(int $category_id): self {
        $this->category_id = $category_id;
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
        $this->belongsTo('asset_id', KcAsset::class, 'id', array('alias' => 'KcAsset', 'foreignKey' => true));
        $this->belongsTo('category_id', KcCategory::class, 'id', array('alias' => 'KcCategory', 'foreignKey' => true));


    }

    //region Static methods

    /**
     * Get the related KcAsset.
     *
     * @return KcAsset
     */
    public function getKcAsset()
    {
        return $this->getRelated('KcAsset');
    }

    /**
     * Get the related KcCategory.
     *
     * @return KcCategory
     */
    public function getKcCategory()
    {
        return $this->getRelated('KcCategory');
    }

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
        return 'kc_asset_cat';
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
            'CREATE' => 'Create new Kc Asset Category',
            'VIEW' => 'View Kc Asset Category',
            'EDIT' => 'Edit Kc Asset Category'
        ];
    }
}