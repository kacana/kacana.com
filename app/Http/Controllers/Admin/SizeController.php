<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\models\Product;
use Datatables;
use App\models\Tag;
use App\services\tagService;
use Illuminate\Http\Request;

class SizeController extends BaseController {

    /**
     * Show products.
     *
     * @return Response
     */
    public function index()
    {
        $data['tags'] = Tag::all();
        return view('admin.tag.index', $data);
    }

    /*
     * get tags
     */

    public function getTag()
    {
        $tags = Tag::all();
        return Datatables::of($tags)
            ->edit_column('status', function($row){
                return showSelectStatus($row->id, $row->status, 'Kacana.tag.setStatusTag('.$row->id.', 1)', 'Kacana.tag.setStatusTag('.$row->id.', 0)');
            })
            ->edit_column('created', function($row){
                return showDate($row->created);
            })
            ->edit_column('updated', function($row){
                return showDate($row->updated);
            })
            ->add_column('action', function ($row) {
                return showActionButton('Kacana.tag.showEditTagForm('.$row->id.')', 'Kacana.tag.removeTag('.$row->id.')', true);
            })
            ->make(true);
    }

    /*
     * get tags by parent id
     */

    public function getTags($domain, $pid)
    {
        $tag = new Tag;
        $node = isset($_GET['node'])? $_GET['node']:0;

        $data = array();
        $tag_products = array();
        $parentTags = $tag->getTagByParentId($node);

        if($pid!=0){
            $tag_products = $tag->getIdTagByPid($pid);
        }

        foreach($parentTags as $item){
            $i['label'] = $item->name;
            $i['id'] = $item->id;
            $i['parent_id'] = $item->parent_id;
            $i['type'] = $item->type;

            if(in_array($i['id'], $tag_products)){
                $i['checked'] = true;
            }else{
                $i['checked'] = false;
            }

            if($item->countChild()>0){
                $i['childs'] = $item->countChild();
                $i['load_on_demand'] = true;
            }else{
                $i['childs'] = 0;
                $i['load_on_demand'] = false;
            }
            $data[] = $i;
        }
        echo json_encode($data);
    }

    /*
     * show form create item
     */
    public function showFormCreate($domain, $parent_id=0)
    {
        return view('admin.tag.form-create', array('parent_id' => $parent_id));
    }
    /**
     * create product
     *
     * @param Request request
     * @return Response
     */
    public function createTag(TagRequest $request)
    {
        $tag = new Tag;
        $re = $tag->createItem($request->all());
        $re['childs'] = $re->countChild();
        if($re->parent_id!=0){
            $parent = Tag::find($re->parent_id);
            $re['childs_of_parent'] = $parent->countChild();
        }else{
            $re['childs_of_parent'] = 0;
        }
        echo json_encode($re);
    }

    /**
     * Edit tag
     *
     * @param int $id
     * @return Response
     */
    public function editTag($domain, TagRequest $request, $id)
    {
        if($request->isMethod('put')){
            $tagModel = new Tag;
            $tag = $tagModel->updateItem($id, $request->all());
        }
        $tag = Tag::find($id);
        return view('admin.tag.edit-tag', compact('tag'));
    }

    /**
     * remove Tag
     * @param $id
     */
    public function removeTag($domain, $id)
    {
        $tag = Tag::find($id);
        if($tag->countChild()>0){
            $tag->deleteChild($id);
        }
        Tag::find($id)->delete();
    }

    /**
     * Show edit form tag
     *
     * @param TagRequest $request
     * @return Response
     */
    public function showEditFormTag($domain, $id)
    {
        if(!empty($id)){
            $tag = Tag::find($id);
            $data['item'] = $tag;
            return view('admin.tag.form-edit',$data);
        }
    }

    /**
    * Set status of tag (0 = inactive; 1 = active)
    *
    * @param id, status
    * @return str
    */
    public function setStatusTag($domain, $id, $status)
    {
        $str = '';
        $tag = new Tag();
        if($tag->updateItem($id, (array('status'=>$status)))){
            if($status == 0){
                $str = "Đã chuyển sang trạng thái inactive thành công!";
            }else{
                $str = "Đã chuyển sang trạng thái active thành công!";
            }
        }
        return $str;
    }

    public function getTagById($domain, $parent_id = 0)
    {
        $tag = new Tag;
        $tags = $tag->getTagById($parent_id);
        echo json_encode($tags);
    }

    /**
     * Set type (parent or child)
     * 1: parent; 2: child
     *
     * @param id tag
     */
    public function setType($domain, $id, $type){
        $tag = Tag::find($id);
        $result = $tag->updateItem($id, array('type' => $type));
        echo json_encode($result);
    }

    /**
     * Get Products
     *
     * @param int $id
     */
    public function getProducts($domain, $id){
        $product_model = new Product();
        $products = $product_model->getProductsByTag($id);

        return Datatables::of($products)
            ->edit_column('image', function($row) {
                if(!empty($row->image)){
                    return showImage($row->image, PRODUCT_IMAGE . $row->id);
                }
            })
            ->edit_column('status', function($row){
                return showSelectStatus($row->id, $row->status, 'Kacana.product.setStatus('.$row->id.', 1)', 'Kacana.product.setStatus('.$row->id.', 0)');
            })
            ->edit_column('created', function($row){
                return showDate($row->created);
            })
            ->edit_column('updated', function($row){
                return showDate($row->updated);
            })
            ->add_column('action', function ($row) {
                return showActionButton("/product/editProduct/".$row->id, 'Kacana.product.removeProduct('.$row->id.')', false, false);
            })
            ->make(true);
    }

    public function updateImage(Request $request){

        $return['ok'] = 0;
        $id = $request->input('tagId');
        $imageName = $request->input('name');

        try {
            $tagService = new tagService();
            $return['data'] = $tagService->updateImage($id, $imageName);
            $return['ok'] = 1;
        } catch (Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = TR::l('EDITOR/MESSAGE/ERROR/SHARE_BIN');
            $return['errorMsg'] = $e->getMessage();
            Binumi_Util::logErr($e->getMessage());
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

}
