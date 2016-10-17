<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\models\Product;
use Datatables;
use App\models\TagModel;
use App\services\tagService;

use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers\Admin
 */
class TagController extends BaseController {

    /**
     * Show products.
     *
     * @return Response
     */
    public function index()
    {
        $tagService = new tagService();
        $tagTypes = $tagService->getAllTagType();
        return view('admin.tag.index', array('tagTypes'=>$tagTypes));
    }


    /**
     * get tags by parent id
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTreeTag(Request $request)
    {
        $tagService = new tagService();

        $relationType = $request->get('relationType', 0);
        $tagId = $request->get('node', 0);

        try{
            $return = $tagService->getSubTagsWithAdminData($tagId, $relationType);
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /*
     * show form create item
     */
    /**
     * @param $domain
     * @param int $parent_id
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function showFormCreate($domain, $parent_id=0)
    {
        return view('admin.tag.form-create', array('parent_id' => $parent_id));
    }


    /**
     * Tag Controller create Tag Action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTag(Request $request)
    {
        $tagService = new tagService();

        $tagName = $request->input('name', '');
        $typeId = $request->input('typeId', 0);
        $parentId = $request->input('parentId', 0);

        $return['ok'] = 0;

        try{
            if($tagName)
            {
                $return['ok'] = 1;
                $tag = $tagService->createTag($tagName);
                $return['data'] = $tag;

                if($typeId && $tag)
                {
                    $tagService->addTagRelation($tag->id, $parentId, $typeId);
                }
            }

        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editTag(Request $request)
    {
        $tagService = new tagService();

        $tagName = $request->input('name');
        $tagId = $request->input('id');
        $tagIdshortTagDescription = $request->input('shortTagDescription');

        $return['ok'] = 0;

        try{
            if($tagName)
            {
                $return['ok'] = 1;
                $return['data'] = $tagService->editTag($tagId, $tagName, $tagIdshortTagDescription);
            }
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function fullEditTag($domain, $id, Request $request){
        $tagService = new tagService();
        $success = false;
        try{
            if($request->isMethod('post')){
                $name = $request->input('name', '');
                $status = $request->input('status', KACANA_TAG_STATUS_ACTIVE);
                $shortDesc = $request->input('short_desc', '');
                $description = $request->input('description', '');

                $tagService->fullEditTag($id, $name, $shortDesc, $description, $status);
                $success = 'Cập nhật tag '.$name.' thành công!';
            }

            return view('admin.tag.edit-tag', array('tag' => $tagService->getTagById($id, false), 'success' => $success));

        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
    }

    public function removeTagRelation(Request $request)
    {
        $tagService = new tagService();
        $typeId = $request->input('typeId');
        $tagId = $request->input('id');
        $parentId = $request->input('parentId');

        $return['ok'] = 0;

        try{
            if($typeId && $tagId)
            {
                $return['ok'] = 1;
                $return['data'] = $tagService->removeTagRelation($tagId, $typeId, $parentId);
                $tagService->resetTagOrder($parentId, $typeId);
            }
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    public function searchTagRelation(Request $request)
    {
        $tagService = new tagService();
        $typeId = $request->input('typeId');
        $name = $request->input('name');

        $return['ok'] = 0;

        try{
            if($typeId && $name)
            {
                $return['ok'] = 1;
                $return['data'] = $tagService->searchTagRelation($name, $typeId);
            }
        }
        catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateImage(Request $request){

        $return['ok'] = 0;
        $id = $request->input('tagId');
        $parentId = $request->input('parentId');
        $typeId = $request->input('typeId');
        $imageName = $request->input('name');

        try {
            $tagService = new tagService();
            $return['data'] = $tagService->updateImage($id, $parentId, $typeId, $imageName);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    /**
     * Generate table for tag
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateTagTable(Request $request){
        $params = $request->all();
        $tagService = new tagService();

        try {
            $return = $tagService->generatetagTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }

        return response()->json($return);
    }

    /**
     * @param $domain
     * @param $typeId
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function relation($domain, $typeId, Request $request){

        $message = $request->input('message');

        switch($typeId){
            case TAG_RELATION_TYPE_SIZE:
                $typeName = 'Tag for product size';
                break;
            case TAG_RELATION_TYPE_GROUP:
                $typeName = 'Group Tag for product';
                break;
            case TAG_RELATION_TYPE_COLOR:
                $typeName = 'Tag for product color';
                break;
            case TAG_RELATION_TYPE_MENU:
                $typeName = 'Tag for main menu';
                break;
            case TAG_RELATION_TYPE_STYLE:
                $typeName = 'Tag for style';
                break;
            default:
                $typeName = '';
                break;
        }

        return view('admin.tag.relation', array('message'=> $message, 'typeId' => $typeId, 'typeName'=>$typeName));
    }

    public function processTagMove(Request $request){
        $return['ok'] = 0;
        $movedTagId = $request->input('movedTagId');
        $targetTagId = $request->input('targetTagId');
        $position = $request->input('position');
        $movedTagParentId = $request->input('movedTagParentId');
        $typeId = $request->input('typeId');

        try {
            $tagService = new tagService();
            $return['data'] = $tagService->processTagMove($movedTagId, $targetTagId, $position, $movedTagParentId, $typeId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function addTagToRoot(Request $request){
        $return['ok'] = 0;
        $tagId = $request->input('tagId');
        $typeId = $request->input('typeId');

        try {
            $tagService = new tagService();
            $return['data'] = $tagService->addTagRelation($tagId, 0, $typeId);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }
        return response()->json($return);
    }

    public function searchTagProduct(Request $request){
        $tagService = new tagService();

        $return['ok'] = 0;
        $name = $request->input('name');
        $productId = $request->input('productId');

        try{
            $items = $tagService->searchTagProduct($name, $productId);
            $return['items'] = $items->toArray();
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function getTag(Request $request)
    {
        $tagService = new tagService();

        $return['ok'] = 0;
        $tagId = $request->input('tagId');

        try{
            $items = $tagService->getTagById($tagId, false);
            $return['items'] = $items;
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function searchTag(Request $request){
        $tagService = new tagService();

        $return['ok'] = 0;
        $name = $request->input('name');

        try{
            $items = $tagService->searchTag($name);
            $return['items'] = $items;
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($return);
    }

    public function getGroupTag(Request $request)
    {
        $tagService = new tagService();
        $tagId = $request->input('tagId');
        $return['ok'] = 0;

        try {
            $tag = $tagService->getTagById($tagId, TAG_RELATION_TYPE_GROUP);
            $return['data'] = $tag;
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }
}
