<form method="POST" action="{{ route('add_trip') }}">
                
    {{ csrf_field() }}

    <div class="row justify-content-center ">
        
        <div class="col-md-6 col-sm-10">
            
            <div class="form-group text-right">
                <label for="place_from" class="text-white">من مركز:</label>
                <select class="form-control" id="place_from" name="place_from">
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}"
                            {{ $center->id == 1 || old('place_from') == $center->id? 'selected' : '' }}>{{ $center->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="place_from_address" value="{{ old('place_from_address') }}" id="place_from_address" class="form-control" placeholder="اكتب عنوان التحرك">
            </div>
        </div>

        <div class="col-md-6 col-sm-10">
            <div class="form-group text-right">
                <label for="place_to" class="text-white">الى مركز:</label>
                <select class="form-control" id="place_to" name="place_to">
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}"
                            {{ $center->id == 2 || old('place_to') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="place_to_address" value="{{ old('place_to_address') }}" id="place_to_address" class="form-control" placeholder="اكتب عنوان الوصول">
            </div>
        </div>
        <div class="col-md-6 col-sm-10">
            <div class="form-group text-right">
                <label for="date" class="text-white">التاريخ:</label>
                <input class="form-control datepicker" id="date" name="date" value="{{ old('date') }}" placeholder="MM/DD/YYY" type="date"/>
            </div>
        </div>
        <div class="col-md-6 col-sm-10">
            <div class="form-group text-right">
                <label for="time" class="text-white">الوقت:</label>
                <input class="form-control datepicker" id="time" name="time" value="{{ old('time') }}" placeholder="MM/DD/YYY" type="time"/>
            </div>
        </div>
        <div class="col-md-12 col-sm-10 ">
            <div class="form-group text-right">
                <label for="notes" class="text-white">ملاحظات:</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="col-md-12 col-sm-10">
            <div class="form-group text-right">
                <div>
                    <label class="text-white" for="going">
                        <input type="radio" name="going_type" value="going" id="going" checked
                            value="{{ old('going_type') == 'going' ? 'checked' : ''}}">
                        ذهاب فقط
                    </label>
                </div>
                <div>
                    <label class="text-white" for="going_and_comingback">
                        <input type="radio" name="going_type" value="going_and_comingback" id="going_and_comingback"
                            value="{{ old('going_type') == 'going_and_comingback' ? 'checked' : ''}}">
                        ذهاب وعودة قي نفس اليوم (انتظار حتى 4 ساعات) 
                    </label>
                </div>
                <div>
                    <label class="text-white" for="going_and_comingback_otherday">
                        <input type="radio" name="going_type" value="going_and_comingback_otherday" id="going_and_comingback_otherday"
                            value="{{ old('going_type') == 'going_and_comingback_otherday' ? 'checked' : ''}}">
                        ذهاب وعودة في يوم إخر 
                    </label>
                    <div class="form-group" style="display: none;" id="div_other">
                        <div class="row">
                            <div class="col-md-6 col-sm-10">
                                <div class="form-group text-right">
                                    <label for="other_date" class="text-white">التاريخ:</label>
                                    <input value="{{ old('other_date') }}" class="form-control datepicker other-input" id="other_date" name="other_date" placeholder="MM/DD/YYY" type="date"/>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-10">
                                <div class="form-group text-right">
                                    <label for="other_time" class="text-white">الوقت:</label>
                                    <input value="{{ old('other_time') }}" class="form-control datepicker other-input" id="other_time" name="other_time" placeholder="MM/DD/YYY" type="time"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-10 row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="promo_code" class="form-control" value="{{ old('promo_code') }}" 
                        style="border-radius: 5px;" placeholder="كود خصم">
                    <div class="input-group-prepend" 
                        style="margin-right: -60px;z-index: 10000;">
                        <button id="btnPromo" class="btn btn-primary" type="button" 
                            style="border-radius: 4px;height: 41px;margin-top: 2px;">تحقق</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="price">
                        <span id="price">{{ $price->price }}</span> جنيه
                        <del style="font-size: 12px; color: red;display: none;" id="oldPrice">
                            <span id="old-price">{{ $price->price }}</span> جنيه
                        </del>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-10">
            <div class="form-group">
                <input type="submit" class="btnContactSubmit" value="ارسال طلب الرحلة" />
            </div>
        </div>
    </div>
</form>