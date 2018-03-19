<?php namespace App\models;

use App\services\chatService;
use Illuminate\Database\Eloquent\Model;
use Kacana\DataTables;
use DB;

class blogPostModel extends Model
{


    protected $table = 'blog_posts';

    public $timestamps = true;

    protected $appends = ['bodyLazyLoad'];

    /**
     * Get the tags associated with product
     */
    public function user()
    {
        return $this->belongsTo('App\models\User', 'user_id');
    }

    public function tag()
    {
        return $this->belongsTo('App\models\tagModel', 'tag_id');
    }

    /**
     * Get the tags associated with product
     */
    public function tags()
    {
        return $this->belongsToMany('App\models\tagModel', 'blog_post_tag', 'post_id', 'tag_id')->withPivot('type');
    }

    /**
     * Get the galleries associated with product
     */
    public function galleries()
    {
        return $this->hasMany('App\models\blogPostGalleryModel', 'post_id', 'id');
    }

    public function createItem($title, $tagId, $userId)
    {
        $post = new blogPostModel();
        $post->title = $title;
        $post->slug = str_slug($title);
        $post->tag_id = $tagId;
        $post->user_id = $userId;

        $post->save();

        return $post;
    }

    public function updateItem($id, $title, $titleSeo, $tagId, $status, $body, $meta_desc, $userId = false)
    {
        $updateData = ['title' => $title, 'title_seo' => $titleSeo, 'body' => trim($body), 'slug' => str_slug($title), 'tag_id' => $tagId, 'status' => $status, 'meta_desc' => $meta_desc];
        if($userId)
            return $this->where('id', $id)->where('user_id', $userId)->update($updateData);
        else
            return $this->where('id', $id)->update($updateData);
    }

    public function updateImage($id, $image)
    {
        $updateData = ['image' => $image];
        return $this->where('id', $id)->update($updateData);
    }

    public function generatePostTable($request, $columns, $userId = false)
    {

        $datatables = new DataTables();

        $limit = $datatables::limit($request, $columns);
        $order = $datatables::order($request, $columns);
        $where = $datatables::filter($request, $columns);

        $arraySelect = $datatables::pluck($columns, 'db');
        array_push($arraySelect, DB::raw('COUNT(kacana_blog_comments.id) as count_item_blog_comment'));

        // Main query to actually get the data
        $selectData = DB::table('blog_posts')
            ->select($arraySelect)
            ->leftJoin('blog_comments', 'blog_posts.id', '=', 'blog_comments.post_id')
            ->leftJoin('users', 'blog_posts.user_id', '=', 'users.id')
            ->leftJoin('tags', 'blog_posts.tag_id', '=', 'tags.id')
            ->orderBy($order['field'], $order['dir'])
            ->groupBy('blog_posts.id')
            ->skip($limit['offset'])
            ->take($limit['limit']);

        // Data set length
        $recordsFiltered = $selectLength = DB::table('blog_posts')
            ->select($arraySelect)
            ->leftJoin('blog_comments', 'blog_posts.id', '=', 'blog_comments.post_id')
            ->leftJoin('users', 'blog_posts.user_id', '=', 'users.id')
            ->leftJoin('tags', 'blog_posts.tag_id', '=', 'tags.id')
            ->orderBy($order['field'], $order['dir'])
            ->groupBy('blog_posts.id');

        if ($where) {
            $selectData->whereRaw($where);
            $recordsFiltered->whereRaw($where);
        }

        if ($userId) {
            $selectData->where('blog_posts.user_id', $userId);
            $recordsFiltered->where('blog_posts.user_id', $userId);
        }

        /*
         * Output
         */
        return array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($selectLength->get()),
            "recordsFiltered" => count($recordsFiltered->get()),
            "data" => $selectData->get()
        );
    }

    public function getItemById($id, $status = KACANA_BLOG_POST_STATUS_ACTIVE, $userId = false)
    {
        $query = $this;
        if ($status)
            $query = $query->where('blog_posts.status', $status);

        if($userId)
            $query = $query->where('blog_posts.user_id', $userId);

        return $query->find($id);
    }

    public function getImageAttribute($value)
    {
        if ($value)
            return AWS_CDN_URL . $value;

        return false;
    }

    public function getListPost($limit, $offset, $tagId = false, $exclude = false)
    {
        $posts = $this->leftJoin('blog_comments', 'blog_posts.id', '=', 'blog_comments.post_id')
            ->leftJoin('blog_post_views', 'blog_posts.id', '=', 'blog_post_views.post_id')
            ->leftJoin('blog_post_tag', 'blog_posts.id', '=', 'blog_post_tag.post_id')
            ->skip($offset)
            ->take($limit)
            ->select(['blog_posts.*', DB::raw('COUNT(kacana_blog_comments.id) as count_item_blog_comment'), DB::raw('COUNT(kacana_blog_post_views.id) as count_item_blog_post_view')]);

        if ($tagId)
            $posts->where(function ($query) use ($tagId) {
                $query->where('blog_posts.tag_id', $tagId)
                    ->orWhere('blog_post_tag.tag_id', $tagId);
            });

        if ($exclude)
            $posts->whereNotIn('blog_posts.id', $exclude);

        $posts->orderBy('blog_posts.updated_at', 'desc')
            ->groupBy('blog_posts.id')
            ->where('blog_posts.status', KACANA_BLOG_POST_STATUS_ACTIVE);

        return $posts->paginate($limit);
    }

    public function getALlPostAvailable()
    {
        return $this->where('blog_posts.status', KACANA_BLOG_POST_STATUS_ACTIVE)->get();
    }

    public function getBodyLazyLoadAttribute()
    {
        return str_replace('src="' . AWS_CDN_URL . '/images/blog', 'alt="'.$this->original['title'].'" src="' . AWS_CDN_URL . '/images/blog', $this->original['body']);
    }
}
