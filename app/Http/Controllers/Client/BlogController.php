<?php namespace App\Http\Controllers\Client;

use App\services\blogService;
use App\services\chatService;
use App\services\mailService;
use App\services\productService;
use App\services\tagService;
use Illuminate\Http\Request;
use Kacana\Client\KPusher;

class BlogController extends BaseController {

    public function index(Request $request)
    {
        $blogService = new blogService();

        try{
            $posts = $blogService->getListPost(10, 0);
            return view('client.blog.index', ['posts' => $posts]);
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

    public function detailPost($domain, $slug, $id, Request $request){
        $blogService = new blogService();
        $productService = new productService();
        $numberProductRelated = 8;
        try{
            $post = $blogService->getPostById($id);
            $relatedPost = $blogService->getListPost(5, 0, $post->tag_id, [$post->id]);
            $products = [];
            $productIds = [];
            $tagNameArray = [];

            foreach ($post->tags as $tag)
            {
                $productRelations = $productService->getProductByTagId($tag->id, 100);

                foreach ($productRelations as $productRelation)
                {
                    if(!in_array($productRelation->id, $productIds))
                    {
                        array_push($products, $productRelation);
                        array_push($productIds, $productRelation->id);
                    }

                    if(count($products) > $numberProductRelated)
                        break;
                }

                if(count($products) > $numberProductRelated)
                    break;
            }

            foreach ($post->tags as $tag){
                array_push($tagNameArray, $tag->name);
            }

            return view('client.blog.detail', ['post' => $post, 'relatedPosts' => $relatedPost, 'products' => $products, 'metaKeyword' => $tagNameArray]);
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

    public function trackUserPostView(Request $request){
        $blogService = new blogService();
        $result['ok'] = 0;
        try{
            $postId = $request->input('postId', 0);
            $ip = $request->ip();
            $result['ok'] = 1;
            $blogService->trackUserPostView($postId, $ip);
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return response()->json($result);
    }

    public function catPost($domain, $slug, $tagId, Request $request){

        $blogService = new blogService();
        $tagService = new tagService();
        try{
            $posts = $blogService->getListPost(10, 0, $tagId);
            $tag = $tagService->getTagById($tagId);
            return view('client.blog.index', ['posts' => $posts, 'tag' => $tag]);
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
}
