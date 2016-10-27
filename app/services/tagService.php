<?php namespace App\services;

use App\models\productModel;
use App\models\tagModel;
use Kacana\DataTables;
use Kacana\ViewGenerateHelper;
use Cache;

/**
 * Class productService
 * @package App\services
 */
class tagService {

    /**
     * @param $id
     * @param $parentId
     * @param $typeId
     * @param $imageName
     * @return int
     */
    public function updateImage($id, $parentId, $typeId, $imageName){
        $productGalleryService = new productGalleryService();
        $tagModel = new tagModel();

        $tag = $tagModel->getTagRelation($id, $typeId);
        if($tag->image)
            $productGalleryService->deleteFromS3($tag->image);

        if($imageName)
        {
            $newPath = '/images/tag/kacana_tag_'.$tag->parent_id.'_'.$tag->child_id.'_'.$tag->tag_type_id.'_'.time().'.jpg';
            $productGalleryService->uploadToS3($imageName, $newPath);
            $imageName = $newPath;
        }


        $tag = $tagModel->updateImage($id, $parentId, $typeId, $imageName);

        return $tag;
    }

    /**
     * Generate tag table for user
     *
     * @param $request
     * @return array
     */
    public function generatetagTable($request){
        $tagModel = new tagModel();
        $datatables = new DataTables();
        $viewHelper = new ViewGenerateHelper();

        $columns = array(
            array( 'db' => 'tags.id', 'dt' => 0 ),
            array( 'db' => 'tags.name', 'dt' => 1 ),
            array( 'db' => 'tags.status', 'dt' => 2 ),
            array( 'db' => 'tags.created', 'dt' => 3 ),
            array( 'db' => 'tags.updated', 'dt' => 4 )
        );

        $return = $tagModel->generateTagTable($request, $columns);
        $optionStatus = [KACANA_TAG_STATUS_ACTIVE, KACANA_TAG_STATUS_INACTIVE];

        if(count($return['data'])) {
            foreach ($return['data'] as &$res) {
                $res->status = $viewHelper->dropdownView('tags', $res->id, $res->status, 'status', $optionStatus);
            }
        }

        $return['data'] = $datatables::data_output( $columns, $return['data'] );

        return $return;
    }

    /**
     * Create Tag service
     *
     * @param $tagName
     * @param int $status
     * @return tagModel
     */
    public function createTag($tagName, $status = KACANA_TAG_STATUS_ACTIVE){

        $tag = new tagModel();

        $data = [
            'name' =>   $tagName,
            'status' => $status
        ];

        $result = $tag->createItem($data);

        return $result;
    }

    /**
     * edit tag service
     *
     * @param $id
     * @param $tagName
     * @param $shortTagDescription
     * @param int $status
     * @return \Illuminate\Support\Collection|null|static
     */
    public function editTag($id, $tagName, $shortTagDescription, $status = KACANA_TAG_STATUS_ACTIVE){

        $tag = new tagModel();

        $data = [
            'name' =>   $tagName,
            'status' => $status,
            'short_desc' => $shortTagDescription
        ];

        return $tag->updateItem($id, $data);
    }

    public function fullEditTag($id, $tagName, $shortDescription, $description, $status){

        $tag = new tagModel();

        $data = [
            'name' =>   $tagName,
            'status' => $status,
            'short_desc' => $shortDescription,
            'description' => $description

        ];

        return $tag->updateItem($id, $data);
    }

    /**
     * Create Tag service
     *
     * @return array|static[]
     */
    public function getAllTagType(){
        $tag = new tagModel();
        return $tag->getAllTagType();
    }

    /**
     * @param $tagId
     * @param $relationType
     * @return array
     */
    public function getSubTagsWithAdminData($tagId, $relationType){
        $tagModel = new tagModel();

        $subTags = $tagModel->getSubTags($tagId, $relationType );
        return $this->addAdminData($subTags, $relationType);
    }

    /**
     * add tagId have parent id at end of list
     *
     * @param $tagId
     * @param $parentId
     * @param $typeId
     * @return bool
     */
    public function addTagRelation($tagId, $parentId, $typeId)
    {
        $tagModel = new tagModel();
        $order = $tagModel->getChildCount($parentId, $typeId);
        return $tagModel->addTagRelation($parentId, $tagId, $typeId, $order);

    }

    /**
     * Basing on tags, getting count of child tag
     *
     * @param   array   $tags (example: history, technology,...)
     * @param   int     $relationType
     * @return  array
     * @access  public
     */
    public function addAdminData($tags, $relationType)
    {
        $tagModel = new tagModel();
        $productService = new productService();

        $tagsWithAdminData = array();

        foreach ($tags as $tag) {
            $tagCache = '__count_search_product_by_tag_id__';
            $tag->child_count = $tagModel->getChildCount($tag->child_id, $relationType);
            $tag->id = $tag->child_id.'_'.$tag->parent_id.'_'.$relationType;
            if(Cache::tags($tagCache)->get($tag->child_id)) {
                $tag->product_count = Cache::tags($tagCache)->get($tag->child_id);
            }
            else{
                $tag->product_count = '?';
            }
            $tagsWithAdminData[] = $tag;
        }

        return $this->formatTags($tagsWithAdminData);
    }

    /**
     * Add extra field for jqTree
     *
     * @param $data
     */
    public function formatTags($data)
    {
        foreach($data as &$tag) {
            if (isset($tag->child_count) && $tag->child_count > 0) {
                $tag->load_on_demand = true;
            }
        }

        return $data;
    }

    /**
     * remove tag relation and subg tag relation
     *
     * @param $tagId
     * @param $typeId
     * @param $parentId
     * @return int
     */
    public function removeTagRelation($tagId, $typeId, $parentId){
        $tagModel = new tagModel();
        $subTags = $tagModel->getSubTags($tagId, $typeId);

        if($subTags)
            foreach($subTags as $subTag)
            {
                $this->removeTagRelation($subTag->child_id, $typeId, $subTag->parent_id);
            }

        return $tagModel->removeTagRelation($tagId, $typeId, $parentId);
    }

    /**
     * @param $movedTagId
     * @param $targetTagId
     * @param $position
     * @param $movedTagParentId
     * @param $typeId
     * @return bool
     */
    public function processTagMove($movedTagId, $targetTagId, $position, $movedTagParentId, $typeId)
    {
        $tagModel = new tagModel();
        $targetTag = $tagModel->getTagRelation($targetTagId, $typeId);

        $subTagIndex = 1;

        if($position=='after')
        {
            $subTargetTags = $tagModel->getSubTags($targetTag->parent_id, $typeId);
            foreach($subTargetTags as $subTargetTag)
            {
                if($subTargetTag->child_id != $movedTagId)
                {
                    $tagModel->updateTagRelationOrder($subTargetTag->child_id, $typeId, ['tag_order'=>$subTagIndex]);
                    $subTagIndex++;
                }

                if($subTargetTag->child_id == $targetTagId)
                {
                    $tagModel->updateTagRelationOrder($movedTagId, $typeId, ['tag_order'=>$subTagIndex, 'parent_id'=>$subTargetTag->parent_id]);
                    $subTagIndex++;
                }
            }
        }
        elseif($position=='inside'){
            $subTargetTags = $tagModel->getSubTags($targetTagId, $typeId);

            $tagModel->updateTagRelationOrder($movedTagId, $typeId,['tag_order'=>$subTagIndex, 'parent_id'=>$targetTagId]);
            $subTagIndex++;

            if($subTargetTags)
            {
                foreach($subTargetTags as $subTargetTag)
                {
                    if($subTargetTag->child_id != $movedTagId) {
                        $tagModel->updateTagRelationOrder($subTargetTag->child_id, $typeId, ['tag_order' => $subTagIndex]);
                        $subTagIndex++;
                    }
                }
            }
        }

        $this->resetTagOrder($movedTagParentId, $typeId);

        return true;

    }


    /**
     * @param $parentId
     * @param $typeId
     * @return bool
     */
    public function resetTagOrder($parentId, $typeId){
        $tagModel = new tagModel();
        $subTags = $tagModel->getSubTags($parentId, $typeId);

        if(!$subTags)
            return true;

        $subTagIndex = 1;
        foreach($subTags as $subTag)
        {
            $tagModel->updateTagRelationOrder($subTag->child_id, $typeId, ['tag_order'=>$subTagIndex]);
            $subTagIndex++;
        }

        return true;
    }

    /**
     * @param $name
     * @param $typeId
     * @return array
     */
    public function searchTagRelation($name, $typeId){
        $tagModel = new tagModel();
        $tags = $tagModel->searchTagRelation($name, $typeId);

        return ['total' => count($tags), 'results' => $tags] ;
    }

    /**
     * get Menu for client from tag system type menu
     *
     * @return array|bool|static[]
     */
    public function getTagForClientMenu()
    {
        $tagModel = new tagModel();

        $parentId = 0;
        $typeId = TAG_RELATION_TYPE_MENU;

        $menuClients = $tagModel->getSubTags($parentId, $typeId, KACANA_TAG_STATUS_ACTIVE);

        foreach($menuClients as &$menuClient){
            $menuClient->childs = $tagModel->getSubTags($menuClient->child_id, $typeId);
        }

        return $menuClients;
    }


    /**
     * get root tag with typeId
     *
     * @param int $typeId
     * @return array|bool|static[]
     */
    public function getRootTag($typeId = TAG_RELATION_TYPE_MENU){
        $tagModel = new tagModel();
        $parentId = 0;

        return $tagModel->getSubTags($parentId, $typeId, KACANA_TAG_STATUS_ACTIVE);
    }

    /**
     * @param $tagId
     * @param $typeRelation
     * @param array $tagIds
     * @return array
     */
    public function getAllChildTag($tagId, &$tagIds = [], $typeRelation = false)
    {

        $tagModel = new tagModel();
        array_push($tagIds, $tagId);
        $tagChilds = $tagModel->getSubTags($tagId, $typeRelation);
        if($tagChilds){
            foreach($tagChilds as $tagChild)
            {
                if(!in_array($tagChild->child_id, $tagIds))
                    $this->getAllChildTag($tagChild->child_id, $tagIds, $typeRelation);
            }
        }
        return $tagIds;
    }

    /**
     * @param $tagId
     * @param $relationType
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getTagById($tagId, $relationType = TAG_RELATION_TYPE_MENU){
        $tagModel = new tagModel();
        $tag = $tagModel->getTagById($tagId, $relationType);
        if($tagModel->getSubTags($tagId, $relationType))
            $tag->childs = $tagModel->getSubTags($tagId, $relationType);
        return $tag;
    }

    public function getAllChildTagHaveProduct($tagId){
        $tagModel = new tagModel();
        $listTagRelationId = array();
        $tagRelationId = $this->getAllChildTag($tagId, $listTagRelationId);
        return  $tagModel->getTagByIdsHaveProduct($tagRelationId);
    }

    public function formatMetaKeyword($tags){
        $tagNameArray = [];
        if(count($tags))
            foreach ($tags as $tag)
                array_push($tagNameArray, $tag->name);

        return $tagNameArray;
    }

    /**
     * @return array|bool|static[]
     */
    public function getColorTag(){
        $tagModel = new tagModel();
        $tagId = 0;
        $typeId = TAG_RELATION_TYPE_COLOR;

        return $tagModel->getSubTags($tagId, $typeId, KACANA_TAG_STATUS_ACTIVE);
    }

    /**
     * @return array|bool|static[]
     */
    public function getTagGroup(){
        $tagModel = new tagModel();
        $tagId = 0;
        $typeId = TAG_RELATION_TYPE_GROUP;

        return $tagModel->getSubTags($tagId, $typeId, KACANA_TAG_STATUS_ACTIVE);
    }

    /**
     * @return array|bool|static[]
     */
    public function getSizeTag(){
        $tagModel = new tagModel();
        $tagId = 0;
        $typeId = TAG_RELATION_TYPE_SIZE;

        $tagChilds = $tagModel->getSubTags($tagId, $typeId, KACANA_TAG_STATUS_ACTIVE);

        if($tagChilds){
            foreach($tagChilds as &$tagChild){
                $tagChild->childs = $tagModel->getSubTags($tagChild->child_id, $typeId, KACANA_TAG_STATUS_ACTIVE);
            }
        }
        return $tagChilds;
    }

    /**
     * @return array|bool|static[]
     */
    public function getStyleTag(){
        $tagModel = new tagModel();
        $tagId = 0;
        $typeId = TAG_RELATION_TYPE_STYLE;

        return $tagModel->getSubTags($tagId, $typeId, KACANA_TAG_STATUS_ACTIVE);
    }

    public function searchTagProduct($name, $productId){
        $tagModel = new tagModel();
        $listTagAddedProduct = $tagModel->getlistTagAddedProduct($productId);
        $tagNotIn = array();
        foreach($listTagAddedProduct as $tagAddedProduct)
        {
            array_push($tagNotIn, $tagAddedProduct->tag_id);
        }

        return $tagModel->searchTagByName($name, $tagNotIn);
    }

    public function searchTag($name){
        $tagModel = new tagModel();
        $tags = $tagModel->searchTagByName($name)->toArray();
        foreach($tags as &$tag){
            $tag['label'] = $tag['name'];
            $tag['value'] = $tag['name'];
        }
        return $tags;
    }

    public function toggleStatusRelation($tagId, $typeId, $parentId){
        $tagModel = new tagModel();
        $tagRelation = $tagModel->getTagRelation($tagId, $typeId);

        if($tagRelation->status == TAG_RELATION_STATUS_INACTIVE)
        {
            if($parentId)
            {
                $parentTagRelation = $tagModel->getTagRelation($parentId, $typeId);
                if($parentTagRelation->status == TAG_RELATION_STATUS_INACTIVE)
                    return false;
            }
            $tagModel->updateTagRelationOrder($tagId, $typeId, ['status'  => TAG_RELATION_STATUS_ACTIVE]);

        }

        if($tagRelation->status == TAG_RELATION_STATUS_ACTIVE)
        {
            $tagModel->updateTagRelationOrder($tagId, $typeId, ['status'  => TAG_RELATION_STATUS_INACTIVE]);
            $tagArr = [];

            $subTags = $this->getAllChildTag($tagId, $tagArr, $typeId);

            foreach ($subTags as $subTag){
                $tagModel->updateTagRelationOrder($subTag, $typeId, ['status'  => TAG_RELATION_STATUS_INACTIVE]);
            }

        }

        return true;
    }

}



?>