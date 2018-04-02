@extends('layouts.client.master')

@section('top-infomation')
    @include('layouts.client.slide')
@stop
@section('content')
    <div id="homepage" itemscope itemtype="http://schema.org/ItemList">
        @foreach($campaigns as $campaign)
            <div class="block-tag" >
                <div class="block-tag-header homepage" >
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8" >
                                <div class="row">
                                    <h2>{{$campaign->name}}</h2>
                                </div>
                                <div class="row">
                                    <h3>{{$campaign->start_date}} - {{$campaign->end_date}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-tag-body" >
                    <div class="container taglist background-white" >
                        <div class="row">
                            @if(count($campaign->campaignProductAvailable)>0)
                                @foreach($campaign->campaignProductAvailable as $campaignProduct)
                                    <?php $item = $campaignProduct->product ?>
                                    <div itemprop="itemListElement" itemscope itemtype="http://schema.org/Product" class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
                                        @include('client.product.product-campaign-item-temple')
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('javascript')
    Kacana.campaign.init();
@stop

@section('section-modal')

@stop