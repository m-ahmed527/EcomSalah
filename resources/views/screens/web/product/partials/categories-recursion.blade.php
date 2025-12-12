@foreach($children as $child)
    <li class="closed">
        <a href="#">{{ $child->name }}</a>
        @if($child->childrenRecursive->count())
            <ul>
                @include('screens.web.product.partials.categories-recursion', ['children' => $child->childrenRecursive])
            </ul>
        @endif
    </li>
@endforeach