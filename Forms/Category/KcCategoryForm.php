<?php
/**
 * @author Naeem ul Wahhab
 * @date 2023-02-15
 *
 * Represents a form for editing a category.
 */
namespace Cx\Admin\Extension\Forms\Category;

use Cx\Admin\Forms\CxAdminBaseForm;

class KcCategoryForm extends CxAdminBaseForm
{
    public function initialize()
    {
        // Set rules for client-side validation
        $clientValidationRules = [
            'name' => ['required' => true]
        ];

        // Set validation error messages for client-side validation
        $clientValidationMessages = [
            'name' => ['required' => 'Name is required']
        ];

        // Create hidden field for category ID
        $this->add($this->createHiddenField('id'));

        // Create text field for category name
        $this->add($this->createTextField('name', 'Name', true));

        // Create switch field for category status
        $this->add($this->createSwitchField('status', 'Status', 'Active', 'Inactive'));

        // Create select2 field for parent category selection
        $this->add($this->createSelect2Field('parent_category_id', 'Parent Category', 'Select parent category...', 'parents'));

        // Set client-side validation rules and error messages
        $this->setClientRulesFromArray($clientValidationRules);
        $this->setValidateMessagesFromArray($clientValidationMessages);
    }
}
