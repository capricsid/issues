<?php
/**
 * Author: Naeem ul Wahhab
 * Date: 2023-02-16
 */

use Cx\Admin\Extension\Forms\Asset\KcAssetForm;
?>

function KcAsset() {    
    var $cxRecordsTable = $('#cx-records-table');
    var $cxRecordEditForm = $('#cx-record-edit');

    // Init the DatTable using the Cx Admin DataTable plugin
    cx.common.data.cxAdminDataTables.kcAsset = $cxRecordsTable.cxAdminDataTable({
        ajaxUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-assets')?>',
        columns: [
            cx.common.admin.tableEditColumn('id', {edit: true, delete: false}),
            {data: 'name'},
            {data: 'file_path'}
        ],
        toolbarOptions: {
            enabled: true,
            newRecordLabel: 'Add new asset'
        },
        onNewRecord: function(){
            $cxRecordEditForm.cxForm("reset");
            $cxRecordEditForm.cxForm("enableInputs", true);
        },
        onEditRecord: function($row) {
            $cxRecordEditForm.cxForm("loadJsonData", {
                id: $row.find('.row-edit').data('id'),
                listCollections: false,
                listCategories: false,
                listTags: false
            });
        }
    });


    //Add validation to the form tacking rules and messages from Phalcon Form.
    $cxRecordEditForm.validate({
        rules: <?php echo KcAssetForm::getJsonValidateRules() ?>,
        messages: <?php echo KcAssetForm::getJsonValidateMessages() ?>,
        ignore: '.filter'
    });

    // Init the Cx Form
    $cxRecordEditForm.cxForm({
        loadDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-get-asset-by-id') ?>',
        loadData: {
            listCollections: true,
            listCategories: true,
            listTags: true
        },
        saveDataUrl: '<?php echo $this->CxHelper->Route('djbkc-dashboard-save-assets') ?>',
        inputsEnabled: true,
        submitEnabled: false,
        beforeSubmit: function(formData){
            // remove value lists to avoid sending not required data.
            //formData.collections = [];
            //formData.categories = [];
            //formData.tags = [];
            return formData;
        },
        saveSuccess: function(){
            cx.common.data.cxAdminDataTables.kcAsset.cxAdminDataTable("reloadAjax");
            $cxRecordEditForm.cxForm("loadJsonData");
        }
    });
}