@extends('layouts.app')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h3 class="heading p-4">التنقل بين مراكز المحافظة بكل سهولة</h3>
            <form method="POST" action="{{ route('add_trip') }}">
                
                {{ csrf_field() }}

                <div class="row justify-content-center ">
                    
                    <div class="col-md-6">
                        
                        <div class="form-group text-right">
                            <label for="place_from" class="text-white">من مركز:</label>
                            <select class="form-control" id="place_from" name="place_from">
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}"
                                        {{ $center->id == 1 ? 'selected' : '' }}>{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="place_from_address" id="place_from_address" class="form-control" placeholder="اكتب عنوان التحرك">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group text-right">
                            <label for="place_to" class="text-white">الى مركز:</label>
                            <select class="form-control" id="place_to" name="place_to">
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}"
                                        {{ $center->id == 2 ? 'selected' : '' }}>{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="place_to_address" id="place_to_address" class="form-control" placeholder="اكتب عنوان الوصول">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group text-right">
                            <label for="date" class="text-white">التاريخ:</label>
                            <input class="form-control datepicker" id="date" name="date" placeholder="MM/DD/YYY" type="date"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group text-right">
                            <label for="time" class="text-white">الوقت:</label>
                            <input class="form-control datepicker" id="time" name="time" placeholder="MM/DD/YYY" type="time"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <label for="notes" class="text-white">ملاحظات:</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <div>
                                <label class="text-white" for="going">
                                    <input type="radio" name="going_type" value="going" id="going" checked>
                                    ذهاب فقط
                                </label>
                            </div>
                            <div>
                                <label class="text-white" for="going_and_comingback">
                                    <input type="radio" name="going_type" value="going_and_comingback" id="going_and_comingback">
                                    ذهاب وعودة قي نفس اليوم (انتظار حتى 4 ساعات) 
                                </label>
                            </div>
                            <div>
                                <label class="text-white" for="going_and_comingback_otherday">
                                    <input type="radio" name="going_type" value="going_and_comingback_otherday" id="going_and_comingback_otherday">
                                    ذهاب وعودة في يوم إخر 
                                </label>
                                <div class="form-group" style="display: none;" id="div_other">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group text-right">
                                                <label for="other_date" class="text-white">التاريخ:</label>
                                                <input class="form-control datepicker other-input" id="other_date" name="other_date" placeholder="MM/DD/YYY" type="date"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group text-right">
                                                <label for="other_time" class="text-white">الوقت:</label>
                                                <input class="form-control datepicker other-input" id="other_time" name="other_time" placeholder="MM/DD/YYY" type="time"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="promo_code" class="form-control" style="border-radius: 5px;" placeholder="كود خصم">
                                <div class="input-group-prepend" style="margin-right: -58px;z-index: 10000;">
                                    <button class="btn btn-primary" type="button" style="border-radius: 5px">تحقق</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="price">
                                    <span id="price">{{ $price->price }}</span>
                                 جنيه
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btnContactSubmit" value="ارسال طلب الرحلة" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('change', '#place_from', function() {
        var place_from  = $('#place_from').val();
        var place_to    = $('#place_to').val();
        var going       = $('input[name=going_type]:checked').val();

        updatePrice(place_from, place_to, going);
    });

    $(document).on('change', '#place_to', function() {
        var place_from  = $('#place_from').val();
        var place_to    = $('#place_to').val();
        var going       = $('input[name=going_type]:checked').val();

        updatePrice(place_from, place_to, going);
    });

    $(document).on('change', 'input[name=going_type]:checked', function() {
        var place_from  = $('#place_from').val();
        var place_to    = $('#place_to').val();
        var going       = $('input[name=going_type]:checked').val();

        if (going == 'going_and_comingback_otherday') {
            $('#div_other').css('display', 'block');
        } else {
            $('#div_other').css('display', 'none');
        }

        updatePrice(place_from, place_to, going);
    });

    function updatePrice(place_from, place_to, going_type)
    {
        price = document.getElementById('price');
        $.ajax({
            url: "{{ route('get_price') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                place_from: place_from,
                place_to: place_to,
                going_type: going_type
            },
            success: function (data) {
                console.log()
                if (data.data != null) {
                    price.innerHTML = parseInt(data.data.price)
                }
            }
        })
    }
</script>
@endsection