<?php
/**
 * Author: Naeem ul Wahhab
 * Date: 2023-02-16
 */

use Cx\Admin\Extension\Forms\Category\KcCategoryForm;
?>

function KcCategory() {
    var $body = $('body');
    var $cxRecordsTable = $('#cx-records-table');

    // Init the DatTable using the Cx Admin DataTable plugin
    cx.common.data.cxAdminDataTables.kcCategory = $cxRecordsTable.cxAdminDataTable({
        ajaxUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-categories')?>',
        columns: [
            cx.common.admin.tableEditColumn('id', {edit: true, delete: false}),
            {data: 'name'},
            {data: 'status'},
            {data: 'parent_category_id'}
        ],
        toolbarOptions: {
            enabled: true,
            newRecordLabel: 'Add new category'
        },
        onNewRecord: function(){
            $cxRecordEditForm.cxForm("reset");
            $cxRecordEditForm.cxForm("enableInputs", true);
        },
        onEditRecord: function($row) {
            $cxRecordEditForm.cxForm("loadJsonData", {
                id: $row.find('.row-edit').data('id'),
                listParents: false
            });
        }
    });

    // Save the form object so that jquery selector will be executed once.
    var $cxRecordEditForm = $('#cx-record-edit');
    //Add validation to the form tacking rules and messages from Phalcon Form.
    $cxRecordEditForm.validate({
        rules: <?php echo KcCategoryForm::getJsonValidateRules() ?>,
        messages: <?php echo KcCategoryForm::getJsonValidateMessages() ?>,
        ignore: '.filter'
    });

    // Init the Cx Form
    $cxRecordEditForm.cxForm({
        loadDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-category-by-id') ?>',
        loadData: {
            listParents: true
        },
        saveDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-save-categories') ?>',
        inputsEnabled: true,
        submitEnabled: false,

        beforeSubmit: function(formData){
            return formData;
        },
        saveSuccess: function(){
            $cxRecordEditForm.cxForm("loadJsonData");
            cx.common.data.cxAdminDataTables.kcCategory.cxAdminDataTable("reloadAjax");
        }
    });
}