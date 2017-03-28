@if(Admin::user()->visible($item['roles']))
    @if(!isset($item['children']))
        <li class="{{ (Request::is(config('admin.prefix').'/'.$item['uri']) === true || Request::is(config('admin.prefix').'/'.$item['uri'].'/*') === true) ? 'active' : '' }}">
            <a href="{{ Admin::url($item['uri']) }}"><i class="fa {{$item['icon']}}"></i>
                <span>{{$item['title']}}</span>
            </a>
        </li>
    @elseif(count($item['children']) > 0)
        @php
            $active = false;
            foreach($item['children'] as $child){
                if(Request::is(config('admin.prefix').'/'.$child['uri']) === true || Request::is(config('admin.prefix').'/'.$child['uri'].'/*') === true){
                    $active = true;
                }
            }
        @endphp
        <li class="treeview {{ ($active === true) ? 'active' : '' }}">
            <a href="#">
                <i class="fa {{$item['icon']}}"></i>
                <span>{{$item['title']}}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif
