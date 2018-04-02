<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div  class="nivo-slider">
                <div class="slider-wrapper theme-default">
                    <div id="homepage-main-slider" class="nivoSlider">
                        @foreach($campaignDisplay as $campaign)
                            @if($campaign->image)
                                <a href="/khuyen-mai/{{str_slug($campaign->name)}}.{{$campaign->id}}">
                                    <img src="{{$campaign->image}}" alt="" />
                                </a>
                            @endif
                        @endforeach
                        <a href="/san-pham/balo-laptop-nam-mixi-thiet-ke-chong-trom-hoan-hao-bm0601-m5510--1891--442">
                            <img src="{{AWS_CDN_URL}}/images/client/balochongtrom.jpg" data-thumb="{{AWS_CDN_URL}}/images/client/balochongtrom.jpg" alt="" />
                        </a>
                    </div>
                    <div id="htmlcaption" class="nivo-html-caption"></div>
                </div>
            </div>
        </div>
    </div>
</div>