<?php
/**
 * @author Naeem ul Wahhab
 * @date 2023-02-15
 *
 * Represents a form for editing a collection.
 */
namespace Cx\Admin\Extension\Forms\Collection;

use Cx\Admin\Forms\CxAdminBaseForm;

class KcCollectionForm extends CxAdminBaseForm
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

        // Create hidden field for collection ID
        $this->add($this->createHiddenField('id'));

        // Create text field for collection name
        $this->add($this->createTextField('name', 'Name', true));

        // Create switch field for collection status
        $this->add($this->createSwitchField('status', 'Status', 'Active', 'Inactive'));

        // Create text field for collection description
        $this->add($this->createTextField('description', 'Description'));

        // Set client-side validation rules and error messages
        $this->setClientRulesFromArray($clientValidationRules);
        $this->setValidateMessagesFromArray($clientValidationMessages);
    }
}