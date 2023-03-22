<?php
/**
 * @author Naeem ul Wahhab
 * @date 2023-02-15
 *
 * Represents a form for editing a category.
 */
namespace Cx\Admin\Extension\Forms\Asset;

use Cx\Admin\Forms\CxAdminBaseForm;

class KcAssetForm extends CxAdminBaseForm
{
    public function initialize()
    {
        // Set rules for client-side validation
        $clientValidationRules = [
            'name' => ['required' => true],
            'file_path' => ['required' => true]
        ];

        // Set validation error messages for client-side validation
        $clientValidationMessages = [
            'name' => ['required' => 'Name is required'],
            'file_path' => ['required' => 'File path is required']
        ];

        // Create hidden field for category ID
        $this->add($this->createHiddenField('id'));

        // Create text field for category name
        $this->add($this->createTextField('name', 'Name', true));

        // Create text field for category name
        $this->add($this->createTextField('file_path', 'File Path', true));

        // Create select2 field for collection selection
        $this->add($this->createSelect2Field('collection_id', 'Collection', 'Select collection...', 'collections'));

        // Create select2 field for category selection
        $this->add($this->createSelect2Field('category_id', 'Category', 'Select category...', 'categories'));

        // Create select2 field for tag selection
        $this->add($this->createSelect2Field('tag_id', 'Tag', 'Select tag...', 'tags'));

        // Set client-side validation rules and error messages
        $this->setClientRulesFromArray($clientValidationRules);
        $this->setValidateMessagesFromArray($clientValidationMessages);
    }
}
