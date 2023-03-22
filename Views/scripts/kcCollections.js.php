<?php
/**
 * Author: Naeem ul Wahhab
 * Date: 2023-02-16
 */

use Cx\Admin\Extension\Forms\Collection\KcCollectionForm;
?>

function KcCollection() {
    var $body = $('body');
    var $cxRecordsTable = $('#cx-records-table');

    // Init the DatTable using the Cx Admin DataTable plugin
    cx.common.data.cxAdminDataTables.kcCollection = $cxRecordsTable.cxAdminDataTable({
        ajaxUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-collections')?>',
        columns: [
            cx.common.admin.tableEditColumn('id', {edit: true, delete: false}),
            {data: 'name'},
            {data: 'status'},
            {data: 'description'}
        ],
        toolbarOptions: {
            enabled: true,
            newRecordLabel: 'Add new Collection'
        },
        onNewRecord: function(){
            $cxRecordEditForm.cxForm("reset");
            $cxRecordEditForm.cxForm("enableInputs", true);
        },
        onEditRecord: function($row) {
            $cxRecordEditForm.cxForm("loadJsonData", {
                id: $row.find('.row-edit').data('id')
            });
        }
    });

    // Save the form object so that jquery selector will be executed once.
    var $cxRecordEditForm = $('#cx-record-edit');
    //Add validation to the form tacking rules and messages from Phalcon Form.
    $cxRecordEditForm.validate({
        rules: <?php echo KcCollectionForm::getJsonValidateRules() ?>,
        messages: <?php echo KcCollectionForm::getJsonValidateMessages() ?>,
        ignore: '.filter'
    });

    // Init the Cx Form
    $cxRecordEditForm.cxForm({
        loadDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-collection-by-id') ?>',
        loadData: {
        },
        saveDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-save-collections') ?>',
        inputsEnabled: true,
        submitEnabled: false,

        beforeSubmit: function(formData){
            return formData;
        },
        saveSuccess: function(){
            cx.common.data.cxAdminDataTables.kcCollection.cxAdminDataTable("reloadAjax");
        }
    });
}