@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h3 class="heading p-4">التنقل بين مراكز المحافظة بكل سهولة</h3>

            @if($errors->any())
                <ul class="alert list-unstyled" style="background-color: red;color: #FFF;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach        
                </ul>
            @endif

            @if(session()->has('error'))
                <div class="alert list-unstyled" style="background-color: red;color: #FFF;">
                    {{ session('error') }}
                </div>
            @endif

            @if(session()->has('success'))
                <div class="alert" style="background-color: green;color: #FFF;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Start Add Trip Form --}}
            @include('trip.add-trip-form')
            {{-- End Add Trip Form --}}
            
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
    
    $(document).on('click', '#btnPromo', function(e) {
        e.preventDefault();
        var promo_code  = $('input[name=promo_code]').val();
        var place_from  = $('#place_from').val();
        var place_to    = $('#place_to').val();
        var going       = $('input[name=going_type]:checked').val();
        console.log("mohamed")
        $.ajax({
            url: "{{ route('promo') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                place_from: place_from,
                place_to: place_to,
                going_type: going,
                promo_code: promo_code
            },
            success: function (data) {
                if (data.data != null && data.message != 'expired') {
                    price.innerHTML = parseInt(data.data)
                    $('#oldPrice').css('display', 'inline');
                    $('input[name=promo_code]').addClass('is-valid');
                } else {
                    $('input[name=promo_code]').addClass('is-invalid');
                }
            }
        });
    });

    /**
     * Update the Trip price
     * 
     * @param  int place_from
     * @param  int place_to
     * @param  string going_type
     * @return void
     */
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