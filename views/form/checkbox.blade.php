<div class="form-group {!! !$errors->has($column) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-{{$width['label']}} control-label">{{$label}}</label>

    <div class="col-sm-{{$width['field']}}" id="{{$id}}">
        <ul class="list-inline">
            @foreach($options as $option => $label)
                <li>
                    <label @if($inline)class="checkbox-inline"@endif>
                        <input type="checkbox" name="{{$name}}[]" value="{{$option}}" class="{{$class}}" {{ in_array($option, (array)old($column, $value))?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
                    </label>
                </li>
            @endforeach
        </ul>
        @include('admin::form.error')
        @foreach($options as $option => $label)
            @if(!$inline)<div class="checkbox">@endif
            <label @if($inline)class="checkbox-inline"@endif>
                <input type="checkbox" name="{{$name}}[]" value="{{$option}}" class="{{$class}}" {{ in_array($option, (array)old($column, $value))?'checked':'' }} {!! $attributes !!} />&nbsp;{{$label}}&nbsp;&nbsp;
            </label>
            @if(!$inline)</div>@endif
        @endforeach


        <input type="hidden" name="{{$name}}[]">

        @include('admin::form.help-block')

    </div>
</div>
