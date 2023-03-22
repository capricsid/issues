<?php
/**
 * @author Naeem ul Wahhab
 * @date 2023-02-15
 *
 * Represents a form for editing a tag.
 */
namespace Cx\Admin\Extension\Forms\Tag;

use Cx\Admin\Forms\CxAdminBaseForm;

class KcTagForm extends CxAdminBaseForm
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

        // Create hidden field for tag ID
        $this->add($this->createHiddenField('id'));

        // Create text field for tag name
        $this->add($this->createTextField('name', 'Name', true));

        // Create switch field for tag status
        $this->add($this->createSwitchField('status', 'Status', 'Active', 'Inactive'));

        // Set client-side validation rules and error messages
        $this->setClientRulesFromArray($clientValidationRules);
        $this->setValidateMessagesFromArray($clientValidationMessages);
    }
}