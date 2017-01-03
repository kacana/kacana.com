<div id="modal-create-post" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Thêm sản phẩm</h4>
            </div>
            <form role="form" method="post" action="/blog/createNewPost">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="productName">Tên POST</label>
                            <input required name="postTitle" placeholder="Tên post" id="post_title" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="postType">Chuyên mục</label>
                            <select id="post_tag_id" required class="form-control" name="tagId">
                                <option value="">Chuyên mục</option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-primary" value="Tạo mới"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>