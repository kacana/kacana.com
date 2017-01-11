<?php namespace App\Http\Controllers\Client;

use App\services\blogService;
use App\services\productService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;

/**
 * Class SitemapController
 * @package App\Http\Controllers\Client
 */
class SitemapController extends BaseController {

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        // create sitemap
        $sitemap = \App::make("sitemap");

        $sitemap->addSitemap(\URL::to('sitemap-pages.xml'), date("F j, Y, g:i a"));
        $sitemap->addSitemap(\URL::to('sitemap-tags.xml'), date("F j, Y, g:i a"));
        $sitemap->addSitemap(\URL::to('sitemap-products.xml'), date("F j, Y, g:i a"));
        $sitemap->addSitemap(\URL::to('sitemap-posts.xml'), date("F j, Y, g:i a"));

        // show sitemap
        return $sitemap->render('sitemapindex');
	}

	public function sitemapPages(Request $request){
        $sitemap_pages = \App::make("sitemap");
        $domain = str_replace('http://', '', $request->root());
        // set cache
        $sitemap_pages->setCache('__sitemap_pages__', 3600);

        $sitemap_pages->add(route('homepage', [$domain]), null, '1', 'weekly');
        $sitemap_pages->add(route('authGetLogin'), null, '1', 'weekly');
        $sitemap_pages->add(route('authGetSignup'), null, '1', 'weekly');
        $sitemap_pages->add(route('CustomerTrackingOrder', [$domain]), null, '1', 'weekly');

        return $sitemap_pages->render('xml');
    }

	public function sitemapTags(Request $request)
    {
        $tagService = new tagService();
        $productService = new productService();

        // create sitemap
        $sitemap_tags = \App::make("sitemap");

        $mainTags = $tagService->getRootTag();
        $allTags = $tagService->getAllTagHaveProduct();


        $tagIdCheck = [];

        foreach ($mainTags as $tag)
        {
            $sitemap_tags->add(urlTag($tag), $tag->updated, '0.9', 'weekly');
            array_push($tagIdCheck , $tag->id);
        }


        foreach ($allTags as $tagChild)
        {
            if(!in_array($tagChild->id, $tagIdCheck))
            {
                array_push($tagIdCheck , $tagChild->id);
                $sitemap_tags->add(urlTag($tagChild), $tagChild->updated, '0.8', 'weekly');
            }
        }

        return $sitemap_tags->render('xml');
    }

    public function sitemapProducts(){
        $productService = new productService();
        // create sitemap
        $sitemap_products = \App::make("sitemap");

//        set cache
        $sitemap_products->setCache('__sitemap_products__', 3600);

        $products = $productService->getAllProductAvailable();

        foreach ($products as $product)
        {
            $images = [
                ['url' => 'http:'.$product->image, 'title' => $product->name, 'caption' => $product->name],
            ];
            if(count($product->galleries))
                foreach ($product->galleries as $gallery)
                {
                    $image = ['url' => 'http:'.$gallery->image, 'title' => $product->name, 'caption' => $product->name];
                    array_push($images, $image);
                }

            $sitemap_products->add(urlProductDetail($product), $product->updated, '0.9', 'daily', $images);
        }

        return $sitemap_products->render('xml');
    }

    public function sitemapPosts(){
        $blogService = new blogService();

        $post = $blogService->getALlPostAvailable();

        $sitemap_posts = \App::make("sitemap");

//        set cache
        $sitemap_posts->setCache('__sitemap_posts__', 3600);

        foreach ($post as $post)
        {
            $images = [
                ['url' => 'http:'.$post->image, 'title' => $post->title, 'caption' => $post->title],
            ];
            if(count($post->galleries))
                foreach ($post->galleries as $gallery)
                {
                    $image = ['url' => 'http:'.$gallery->image, 'title' => $post->title, 'caption' => $post->title];
                    array_push($images, $image);
                }

            $sitemap_posts->add(\URL::to('/tin-tuc/'.str_slug($post->title).'.'.$post->id), $post->updated_at, '0.9', 'daily', $images);
        }

        return $sitemap_posts->render('xml');

    }

}
