<?php

/**
 * Author: Naeem ul Wahhab
 * Date: 2023-16-02
 */

namespace Cx\Admin\Extension\Controllers;

use Cx\Admin\Controllers\AdminControllerBase;
use Cx\Admin\Extension\Models\KcAsset;
use Cx\Admin\Extension\Models\KcAssetCat;
use Cx\Admin\Extension\Models\KcAssetCollection;
use Cx\Admin\Extension\Models\KcAssetTag;
use Cx\Admin\Extension\Models\KcCategory;
use Cx\Admin\Extension\Models\KcTag;
use Cx\Admin\Extension\Models\KcCollection;
use Cx\Admin\Extension\Forms\Category\KcCategoryForm;
use Cx\Admin\Extension\Forms\Tag\KcTagForm;
use Cx\Admin\Extension\Forms\Collection\KcCollectionForm;
use Cx\Admin\Extension\Forms\Asset\KcAssetForm;
use Cx\Framework\Components\CxHelper;
use Cx\Framework\Exceptions\CxAuthException;
use Cx\Framework\Exceptions\CxConfigurationException;
use Cx\Framework\Exceptions\CxModelException;
use Phalcon\Mvc\Model\Resultset;

class DashboardController extends AdminControllerBase
{
    /**
     * Execute before route to allow only loggedIn user
     *
     * @param mixed $dispatcher
     *
     * @return void
     *
     * @throws CxAuthException|CxConfigurationException
     */
    public function beforeExecuteRoute($dispatcher)
    {
        if (!$this->CxAuth->isUserLoggedInAndValidForCurrentModule()) {
            $this->response->redirect($this->CxHelper->Route('admin-login'));
            return false;
        }
    }



    /**
     * DJBKC dashboard script
     *
     * @return void
     */
    public function scriptAction()
    {
        $this->response->setContentType('text/javascript', 'UTF-8');
    }

    //Region Kc Category

    /**
     * Action for category editing page
     *
     * @return bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function categoriesAction()
    {

        // Forward to access denied if current user is not allowed to view category details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCategory::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Assign the form and acl to view variables.
        $this->view->setVars([
            "KcCategoryForm" => new KcCategoryForm(),
            "ACL" => $this->CxAuth->currentUserAclForResource(KcCategory::class)
        ]);

        return true;
    }

    /**
     * Action that returns all categories in Json format
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getCategoriesAction()
    {
        // Enable JSON response
        $this->setJsonResponse();
        // This action can be called only via ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view category details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCategory::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        /** @var $categories Resultset Get categories from DB */
        $categories = KcCategory::getAllForDataTable(['id', 'status', 'name', 'parent_category_id','parent_category_path', 'category_path', 'parent_category_path_names', 'category_path_names']);

        // loop through $categories to check if a category has parent then display its name
        foreach ($categories as &$category) {
            if ($category['status'] == 1) {
                $category['status'] = 'Active';
            } else {
                $category['status'] = 'Inactive';
            }

            if ($category['parent_category_id'] !== 0) {
                foreach ($categories as $parent_category) {
                    if ($parent_category['id'] == $category['parent_category_id']) {
                        $category['parent_category_id'] = $parent_category['name'];
                        break;
                    }
                }
            } else {
                $category['parent_category_id'] = "-";
            }
        }

        // Return data array
        return ['data' => $categories];
    }

    /**
     * Action that returns all data for required category
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getCategoryByIdAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view category details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCategory::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Get the required category ID
        $id = $this->request->get('id', null);

        // Get the category record
        if ($id == null) {
            // Return an empty record
            $category = new KcCategory();
        } else {
            // Return the required record
            $category = KcCategory::findFirst($id);
        }

        $categoryData = $category->toArray();

        // If "listParents" parameter is true, then add a list of all categories to be used on select options
        if ($this->request->get("listParents", null) === "true") {
            $categoryData['parents'] = KcCategory::getSelect2Values('id', 'name');
        }

        // Return data array
        return array('data' => $categoryData);
    }

    /**
     * Action that saves category data
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function saveCategoriesAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to edit category details
        if (!$this->CxAuth->currentUserIsAllowedTo('EDIT', KcCategory::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Instantiate new form for Kc Category model
        $form = new KcCategoryForm();

        if ($form->isValid($this->request->getPost())) {
            // Get the category ID (if any)
            $id = $this->request->get('id', null);

            // Get the existing category (if any) or create a new one
            if (null !== $id && $id !== '') {
                $category = KcCategory::findFirst($id);
            } else {
                $category = new KcCategory();
            }

            // Bind form with post data
            $form->bind($this->request->getPost(), $category);
            $category->setId($id);
            $parentCategoryId = $this->request->get('parent_category_id', null);

            if ($parentCategoryId != 0) {
                // Find parent category
                $parentCategory = KcCategory::findFirst($parentCategoryId);

                if ($parentCategory) {
                    // Set parent category path and names
                    $category->setParentCategoryPath($parentCategory->getCategoryPath());
                    $category->setParentCategoryPathNames($parentCategory->getCategoryPathNames());
                    if (empty($category->getId())) {
                        $category->save();
                    }

                    // Set category path and names
                    $categoryPath = $parentCategory->getCategoryPath() . $category->getId() . '/';
                    $category->setCategoryPath($categoryPath);

                    $categoryPathNames = $parentCategory->getCategoryPathNames() . ' > ' . $category->getName();
                    $category->setCategoryPathNames($categoryPathNames);
                }
            } else {
                // Set root category path and names
                $category->setParentCategoryId(0);
                $category->setParentCategoryPath('/');
                $category->setParentCategoryPathNames(0);

                // Set category path names
                $category->setCategoryPathNames($category->getName());

                // Save to DB, so we may get id of the category in next step
                $category->save();

                // Set category path
                if (!isset($id) || empty($id) || empty($category->getCategoryPath())) {
                    $categoryRecord = KcCategory::findFirst($category->getId());
                    $categoryPath = '/' . $category->getId() . '/';
                    $categoryRecord->setCategoryPath($categoryPath);
                    $categoryRecord->save();

                    //Populate select field with categories list
                    $categoryListData['parents'] = KcCategory::getSelect2Values('id', 'name');
                    // Return success
                    return array('data' => $categoryListData);
                }
            }

            $category->save();

            //Populate select field with categories list
            $categoryListData['parents'] = KcCategory::getSelect2Values('id', 'name');
            // Return success
            return array('data' => $categoryListData);
        } else {
            // Send error JSON response
            return CxHelper::SendJsonError($form->getHtmlFormattedErrors());
        }
    }

    //End region Kc Category

    //Region Kc Tag

    /**
     * Action for tag editing page
     *
     * @return bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function tagsAction()
    {
        // Forward to access denied if current user is not allowed to view tag details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcTag::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Assign the form and acl to view variables.
        $this->view->setVars([
            "KcTagForm" => new KcTagForm(),
            "ACL" => $this->CxAuth->currentUserAclForResource(KcTag::class)
        ]);

        return true;
    }

    /**
     * Action that returns all tags in Json format
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getTagsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();
        // This action can be called only via ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view tag details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcTag::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        /** @var $tags Resultset Get tags from DB */
        $tags = KcTag::getAllForDataTable(['id', 'name', 'status']);

        // loop through $tags to check if tag's status is 1 then set it to Active
        foreach ($tags as &$tag) {
            if ($tag['status'] == 1) {
                $tag['status'] = 'Active';
            } else {
                $tag['status'] = 'Inactive';
            }
        }

        // Return data array
        return ['data' => $tags];
    }

    /**
     * Action that returns all data for required tag
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getTagByIdAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view tag details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcTag::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Get the required tag ID
        $id = $this->request->get('id', null);

        // Get the tag record
        if ($id == null) {
            // Return an empty record
            $tag = new KcTag();
        } else {
            // Return the required record
            $tag = KcTag::findFirst($id);
        }

        $tagData = $tag->toArray();

        // Return data array
        return array('data' => $tagData);
    }

    /**
     * Action that saves tag data
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function saveTagsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to edit tag details
        if (!$this->CxAuth->currentUserIsAllowedTo('EDIT', KcTag::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Instantiate new form for Kc Tag model
        $form = new KcTagForm();

        if ($form->isValid($this->request->getPost())) {
            // Get the tag ID (if any)
            $id = $this->request->get('id', null);

            // Get the existing tag (if any) or create a new one
            if (null !== $id && $id !== '') {
                $record = KcTag::findFirst($id);
            } else {
                $record = new KcTag();
            }

            // Bind form with post data
            $form->bind($this->request->getPost(), $record);
            $record->setId($id);

            // Save to DB and Check that data is successfully saved
            if ($record->save()) {
                // Return success
                return array('data' => 'Success');
            }
        } else {
            // Send error JSON response
            return CxHelper::SendJsonError($form->getHtmlFormattedErrors());
        }
    }
    //End region Kc Tag

    //Region Kc Collection

    /**
     * Action for collection editing page
     *
     * @return bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function collectionsAction()
    {
        // Forward to access denied if current user is not allowed to view collection details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCollection::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Assign the form and acl to view variables.
        $this->view->setVars([
            "KcCollectionForm" => new KcCollectionForm(),
            "ACL" => $this->CxAuth->currentUserAclForResource(KcCollection::class)
        ]);

        return true;
    }

    /**
     * Action that returns all collections in Json format
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getCollectionsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();
        // This action can be called only via ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view collection details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCollection::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        /** @var $collections Resultset Get collections from DB */
        $collections = KcCollection::getAllForDataTable(['id', 'name', 'description', 'status']);

        // loop through $collections to check if a collection status is 1 then set it to Active
        foreach ($collections as &$collection) {
            if ($collection['status'] == 1) {
                $collection['status'] = 'Active';
            } else {
                $collection['status'] = 'Inactive';
            }
        }

        // Return data array
        return ['data' => $collections];
    }

    /**
     * Action that returns all data for required collection
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getCollectionByIdAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view collection details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcCollection::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Get the required collection ID
        $id = $this->request->get('id', null);

        // Get the collection record
        if ($id == null) {
            // Return an empty record
            $collection = new KcCollection();
        } else {
            // Return the required record
            $collection = KcCollection::findFirst($id);
        }

        $collectionData = $collection->toArray();

        // Return data array
        return array('data' => $collectionData);
    }

    /**
     * Action that saves collection data
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function saveCollectionsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to edit collection details
        if (!$this->CxAuth->currentUserIsAllowedTo('EDIT', KcCollection::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Instantiate new form for Kc Collection model
        $form = new KcCollectionForm();

        if ($form->isValid($this->request->getPost())) {
            // Get the collection ID (if any)
            $id = $this->request->get('id', null);

            // Get the existing collection (if any) or create a new one
            if (null !== $id && $id !== '') {
                $record = KcCollection::findFirst($id);
            } else {
                $record = new KcCollection();
            }

            // Bind form with post data
            $form->bind($this->request->getPost(), $record);
            $record->setId($id);

            // Save to DB and Check that data is successfully saved
            if ($record->save()) {
                // Return success
                return array('data' => 'Success');
            }
        } else {
            // Send error JSON response
            return CxHelper::SendJsonError($form->getHtmlFormattedErrors());
        }
    }
    //End region Kc Collection

    //Region Kc Asset

    /**
     * Action for asset editing page
     *
     * @return bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function assetsAction()
    {

        // Forward to access denied if current user is not allowed to view asset details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcAsset::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Assign the form and acl to view variables.
        $this->view->setVars([
            "KcAssetForm" => new KcAssetForm(),
            "ACL" => $this->CxAuth->currentUserAclForResource(KcAsset::class)
        ]);

        return true;
    }

    /**
     * Action that returns all assets in Json format
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getAssetsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();
        // This action can be called only via ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view asset details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcAsset::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        /** @var $assets Resultset Get assets from DB */
        $assets = KcAsset::getAllForDataTable(['id', 'name', 'file_path']);       

        // Return data array
        return ['data' => $assets];
    }

    /**
     * Action that returns all data for required asset
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function getAssetByIdAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to view asset details
        if (!$this->CxAuth->currentUserIsAllowedTo('VIEW', KcAsset::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Get the required asset ID
        $assetId = $this->request->get('id', null);

        // Get the asset record
        if ($assetId == null) {
            // Return an empty record
            $asset = new KcAsset();
        } else {
            // Return the required record
            $asset = KcAsset::findFirst($assetId);
        }

        $assetData = $asset->toArray();

        //Add fields which are required for select2 in form
        $assetData = array_merge($assetData, ['collection_id' => null, 'category_id' => null,'tag_id' => null]);

        // If "listCollections" parameter is true, then add a list of all collections to be used on select options
        if ($this->request->get("listCollections", null) === "true") {
            $assetData['collections'] = KcCollection::getSelect2Values('id', 'name');
        }

        // If "listCategories" parameter is true, then add a list of all categories to be used on select options
        if ($this->request->get("listCategories", null) === "true") {
            $assetData['categories'] = KcCategory::getSelect2Values('id', 'name');
        }

        // If "listTags" parameter is true, then add a list of all tags to be used on select options
        if ($this->request->get("listTags", null) === "true") {
            $assetData['tags'] = KcTag::getSelect2Values('id', 'name');
        }

        $collection = KcAsset::getAssetCollectionId($assetId);
        $collectionId = current($collection)['id'];

        if (!empty($collectionId)) {
            $assetData = array_merge($assetData, ['collection_id' => $collectionId]);
        }

        $category = KcAsset::getAssetCategoryId($assetId);
        $categoryId = current($category)['id'];

        if (!empty($categoryId)) {
            $assetData = array_merge($assetData, ['category_id' => $categoryId]);
        }

        $tag = KcAsset::getAssetTagId($assetId);
        $tagId = current($tag)['id'];

        if (!empty($tagId)) {
            $assetData = array_merge($assetData, ['tag_id' => $tagId]);
        }

        // Return data array
        return array('data' => $assetData);
    }

    /**
     * Action that saves asset data
     *
     * @return array|bool
     * @throws CxAuthException
     * @throws CxModelException
     */
    public function saveAssetsAction()
    {
        // Enable JSON response
        $this->setJsonResponse();

        // This action can only be called via Ajax
        $this->requireAjax();

        // Forward to access denied if current user is not allowed to edit asset details
        if (!$this->CxAuth->currentUserIsAllowedTo('EDIT', KcAsset::getClassResourceName())) {
            return $this->forwardToAccessDeniedError();
        }

        // Instantiate new form for Kc Asset model
        $form = new KcAssetForm();

        if ($form->isValid($this->request->getPost())) {
            // Get the asset ID (if any)
            $id = $this->request->get('id', null);

            // Get the existing asset (if any) or create a new one
            if (null !== $id && $id !== '') {
                $asset = KcAsset::findFirst($id);
            } else {
                $asset = new KcAsset();
            }

            // Bind form with post data
            $form->bind($this->request->getPost(), $asset);
            //$asset->setId($id);

            $asset->save();
            $assetId = $asset->getId();

            //Get Collection id if any
            $collectionId = $this->request->get('collection_id', null);

            // Check if Collection id is present then save the asset / collection record in lookup table
            if (!empty($collectionId)) {
                $assetCollection = new KcAssetCollection();
                $assetCollection->setAssetId($assetId);
                $assetCollection->setCollectionId($collectionId);
                $assetCollection->save();
            }

            //Get Category id if any
            $categoryId = $this->request->get('category_id', null);

            // Check if Category id is present then save the asset / category record in lookup table
            if (!empty($categoryId)) {
                $assetCategory = new KcAssetCat();
                $assetCategory->setAssetId($assetId);
                $assetCategory->setCategoryId($categoryId);
                $assetCategory->save();
            }

            //Get Tag id if any
            $tagId = $this->request->get('tag_id', null);

            // Check if Tag id is present then save the asset / tag record in lookup table
            if (!empty($tagId) ){
                $assetTag = new KcAssetTag();
                $assetTag->setAssetId($assetId);
                $assetTag->setTagId($tagId);
                $assetTag->save();
            }

            return array('data' => 'Success');
        } else {
            // Send error JSON response
            return CxHelper::SendJsonError($form->getHtmlFormattedErrors());
        }
    }

    //End region Kc Asset

}
