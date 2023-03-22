<?php

namespace Cx\Admin\Extension\Models;

use Cx\Framework\Models\CxResourceBaseModel;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Class KcTag
 * @package Cx\DjbKc
 *
 */
class KcTag extends CxResourceBaseModel
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
            'id', KcAssetTag::class, 'tag_id',
            'asset_id', KcAsset::class, "id",
            array(
                'alias' => 'KcAssets',
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
     * @param array $parameters
     *
     * @return ResultsetInterface
     */
    public static function find($parameters = array()): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * @param array $parameters
     *
     * @return KcTag
     */
    public static function findFirst($parameters = array()): self
    {
        return parent::findFirst($parameters);
    }

    /**
     * Return the model source table name in static way
     *
     * @return string
     */
    public static function getTableName() {
        return 'kc_tag';
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
            'CREATE' => 'Create new Kc Tag',
            'VIEW' => 'View Kc Tag',
            'EDIT' => 'Edit Kc Tag'
        ];
    }
}