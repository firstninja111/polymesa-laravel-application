@extends('layouts.master-layouts-landing')
@section('title')
    @lang('translation.Detail')
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body container">
                    <div class="row my-4">
                        <center>
                            <img src="{{ asset($user->avatar) }}" alt="" class="rounded-circle avatar-md">
                            <h3>Buy Me A Coffee</h3>
                        </center>
                    </div>
                    <div class="row" style="padding-bottom: 180px;">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{$user->paypal == '' ? 'btn-danger': 'btn-success'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">Paypal</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if($user->paypal != "")
                                    <p class="font-size-20">
                                        <span>{{$user->paypal}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{$user->stripe == '' ? 'btn-danger': 'btn-success'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">Stripe</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if($user->stripe != "")
                                    <p class="font-size-20">
                                        <span>{{$user->stripe}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                       
                       
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{$user->zelle == '' ? 'btn-danger': 'btn-success'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">Zelle</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if($user->zelle != "")
                                    <p class="font-size-20">
                                        <span>{{$user->zelle}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                       
                       
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{$user->venmo == '' ? 'btn-danger': 'btn-success'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">Venmo</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if($user->venmo != "")
                                    <p class="font-size-20">
                                        <span>{{$user->venmo}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                       
                       
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{$user->cashapp == '' ? 'btn-danger': 'btn-success'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">CashApp</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if($user->cashapp != "")
                                    <p class="font-size-20">
                                        <span>{{$user->cashapp}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @foreach($cryptos as $crypto)
                            <div class="row">
                                <div class="col-md-3 col-sm-12 d-flex">
                                    <button type="button" class="btn {{array_key_exists($crypto->name, $user->cryptos) && $user->cryptos[$crypto->name] != '' ? 'btn-success': 'btn-danger'}} p-0 waves-effect status-lamp mt-2 me-2"></button>
                                    <p class="font-size-20 mb-1">{{ $crypto->name }}</p>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    @if(array_key_exists($crypto->name, $user->cryptos) && $user->cryptos[$crypto->name] != '')
                                    <p class="font-size-20">
                                        <span>{{array_key_exists($crypto->name, $user->cryptos) ? $user->cryptos[$crypto->name] : ''}}</span>
                                        <i class="fas fa-copy ms-2 myTooltip" style="cursor: pointer" onclick="copyClipboard(this)" onmouseout="outButton()">
                                            <span class="tooltiptext">Copy to clipboard</span>
                                        </i>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('script')
<script>
    function copyClipboard(obj) {
        var jObj = $(obj);
        // obj.select();
        // obj.setSelectionRange(0, 99999);

        console.log(jObj.parent().children()[0].innerHTML);
        var clipText = jObj.parent().children()[0].innerHTML;
        navigator.clipboard.writeText(clipText);

        $('.tooltiptext').html("Copied: " + clipText);
    }

    function outButton() {
        $('.tooltiptext').html('Copy to clipboard');
    }
</script>
@endsection
