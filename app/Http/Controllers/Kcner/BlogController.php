<?php namespace App\Http\Controllers\Kcner;

use App\Http\Requests\BranchRequest;
use App\services\blogService;
use App\services\tagService;
use Image;
use Datatables;
use Illuminate\Http\Request;

/**
 * Class BlogController
 * @package App\Http\Controllers\Kcner
 */
class BlogController extends BaseController {

    /**
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function index(){
        $tagService = new tagService();
        $tags = $tagService->getPostTag();
        return view('kcner.blog.index', array('tags'=>$tags));
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
            case TAG_RELATION_TYPE_POST:
                $typeName = 'Chuyên mục POST';
                break;
            default:
                $typeName = '';
                break;
        }

        return view('kcner.blog.relation', array('message'=> $message, 'typeId' => $typeId, 'typeName'=>$typeName));
    }

    public function generatePostTable(Request $request){
        $params = $request->all();
        $blogService = new blogService();

        try {
            $return = $blogService->generatePostTable($params);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function generateCommentTable($domain, $postId, Request $request){
        $params = $request->all();
        $blogService = new blogService();

        try {
            $return = $blogService->generateCommentTable($params, $postId);

        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function createNewPost(Request $request){
        $blogService = new blogService();

        try {
            $title = $request->input('postTitle', '');
            $tagId = $request->input('tagId', 0);
            $userId = $this->_user->id;
            $post = $blogService->createPost($title, $tagId, $userId);

            return redirect('/blog/editPost/'.$post->id);
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function editPost($domain, $postId, Request $request){
        $blogService = new blogService();
        $tagService = new tagService();

        try {
            if($request->method() == 'POST')
            {
                $id = $request->input('id', 0);
                $title = $request->input('title', 0);
                $tagId = $request->input('tag_id', 0);
                $status = $request->input('status', KACANA_BLOG_POST_STATUS_INACTIVE);
                $postTags = $request->input('post_tags', 0);
                $body =  $request->input('post_body', '');
                $blogService->updateBlogPost($id, $title, $tagId, $status, $body, $postTags);
            }
            $post = $blogService->getPostById($postId, false);

            $tags = $tagService->getPostTag();
            $groupTag = $tagService->getTagGroup();
            return view('kcner.blog.edit-post', array('post'=>$post, 'tags' => $tags, 'groupTag' => $groupTag));
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
    }

    public function searchTagPost(Request $request)
    {
        $tagService = new tagService();

        $return['ok'] = 0;
        $name = $request->input('name');
        $postId = $request->input('postId');

        try{
            $items = $tagService->searchTagPost($name, $postId);
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

    public function updatePostMainImage(Request $request){
        $postId = $request->input('postId');
        $imageName = $request->input('name');

        try {
            $blogService = new blogService();
            $return['data'] = $blogService->updatePostMainImage($postId, $imageName);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['error'] = $e->getMessage();
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }

    public function addPostImage(Request $request){
        $blogService = new blogService();

        $return['ok'] = 0;
        $postId = $request->input('postId');
        $imageName = $request->input('name');
        $type = $request->input('type', BLOG_IMAGE_TYPE_DESC);

        try {
            $return['data'] = $blogService->addPostImage($postId, $imageName);
            $return['ok'] = 1;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            $return['errorMsg'] = $e->getMessage();
            // @codeCoverageIgnoreEnd
        }
        return response()->json($return);
    }
}
