<div class="col-sm-3 column as-search-filters as-filter-animation" aria-hidden="true" id="as-search-filters" style="position:fixed;">
    <div class="as-search-filter-container" style="transform: translate3d(0px, 0px, 0px);">
        <ul class="as-accordion-list">
            <!-- Category -->
            <li class="as-accordion-box">
                <div class="as-search-facet Category">
                    <div class="as-search-accordion-header as-accordion-isexpanded" data-ase-materializer="as-accordion-id0" data-toggle="toggle">
                        <span id="as-accordion-label-id0" class="as-search-accordion-title">Category</span>
                        <button id="as-accordion-header-button0" tabindex="0" class="as-accordion-button" aria-controls="as-accordion-id0" aria-expanded="true">
                            <span class="as-accordion-close"></span>
                        </button>
                    </div>
                    <materializer data-show-height="computed" data-hide-height="0" id="as-accordion-id0" class="as-search-facet-materializer ase-materializer ase-materializer-show" data-shown-init="true">
                        <div class="as-accordion-box-animation">
                            <ul class="as-search-filter-items as-filter-text-type tag">
                                @forelse($links as $link)
                                <li class="as-filter-item">
                                    @if(sizeof($link['childs'])>0)
                                        <a href="javascript:void(0)" class="as-search-filter-child" data-id="{{$link['id']}}">
                                            <span class="as-filter-name">
                                                <span class="as-search-filter-content">
                                                    <span class="as-search-filter-text">{{$link['name']}}
                                                        @if(sizeof($link['childs'])>0)
                                                            <i class="fa fa-angle-down"></i>
                                                        @endif
                                                    </span>
                                               </span>
                                           </span>
                                        </a>
                                    @else
                                        <a href="{{$link['tag_url']}}?page=1&tag={{$link['id']}}" class="as-filter-option" aria-disabled="false" tabindex="0" data-type="tag" role="checkbox" aria-checked="false">
                                        <span class="as-filter-name">
                                            <span class="as-search-filter-content">
                                                <span class="as-search-filter-text">{{$link['name']}}</span>
                                           </span>
                                       </span>
                                        </a>
                                    @endif
                                    @if(isset($link['childs']) && sizeof($link['childs'])>0)
                                        <ul id="as-seach-filter-childs{{$link['id']}}" class="as-search-filter-childs ase-materializer-gone tag">
                                            <li class="as-filter-child-item as-filter-item">
                                                <a href="{{$link['tag_url']}}?page=1&tag={{$link['id']}}" data-type="tag" class="as-filter-option" aria-disabled="false" tabindex="0" role="checkbox" aria-checked="false">
                                                    <span class="as-filter-name">
                                                        <span class="as-search-filter-content">
                                                            <span class="as-search-filter-text">Tất cả</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @foreach($link['childs'] as $child)
                                            <li class="as-filter-child-item as-filter-item">
                                                <a href="{{urlCategory($child)}}?page=1&tag={{$child->id}}" class="as-filter-option" data-type="tag" role="checkbox" aria-checked="false">
                                                    <span class="as-filter-name">
                                                        <span class="as-search-filter-content">
                                                            <span class="as-search-filter-text">{{$child->name}}</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                        </ul>
                                    @endif
                                </li>
                                @empty
                                    <li>Dữ liệu đang được cập nhật...</li>
                                @endforelse
                            </ul>
                        </div>
                    </materializer>
                </div>
            </li>
            <!-- //end category-->

            <!-- color -->
            <li class="as-accordion-box">
                <div class="as-search-facet Category ">
                    <div class="as-search-accordion-header " data-ase-materializer="as-accordion-id0" data-toggle="toggle">
                        <span id="as-accordion-label-id2" class="as-search-accordion-title">Color</span>
                        <button id="as-accordion-header-button0" tabindex="0" class="as-accordion-button" aria-controls="as-accordion-id0" aria-expanded="true">
                            <span class="as-accordion-close"></span>
                        </button>
                    </div>
                    <materializer data-show-height="computed" data-hide-height="0" id="as-accordion-id2" class="as-search-facet-materializer ase-materializer ase-materializer-gone ase-materializer-hide" data-shown-init="true">
                        <div class="as-accordion-box-animation">
                            <ul class="as-search-filter-items as-filter-image-type as-search-color-links color">
                                @forelse($colors as $color)
                                    <li class="as-filter-item as-search-image-item colorselector-link">
                                        <a href="{{Request::url()}}?page=1&color={{$color->id}}" class="as-filter-option" aria-disabled="false" tabindex="0" data-type="color" role="checkbox" aria-checked="false">
                                            <figure class="colorselector-swatch">
                                                <span class="colorselector-circle" style="background-color:{{$color->code}}; border-radius: 50%; padding:4px 12px"></span>
                                                <figcaption class="colorselector-caption">{{$color->name}}</figcaption>
                                            </figure>
                                        </a>
                                    </li>
                                @empty
                                    <li>Dữ liệu đang được cập nhật...</li>
                                @endforelse
                            </ul>
                        </div>
                    </materializer>
                </div>
            </li>
            <!-- //end color -->
        </ul>
    </div>
</div>
