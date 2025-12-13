@foreach($children as $child)
    <li class="{{ $child->childrenRecursive->count() ? 'has' : ''}}">
        <input type="checkbox" name="child[]" value="{{ $child->id }}">
        <label>{{ $child->name }}<span class="total">({{ $child->childrenRecursive->count() }})</span> </label>
        <ul>
            @include('screens.web.product.partials.categories-recursion', ['children' => $child->childrenRecursive])
        </ul>
    </li>
@endforeach
{{-- @foreach($children as $child)
<li class="closed">
    <a href="#">{{ $child->name }}</a>
    @if($child->childrenRecursive->count())
    <ul>
        @include('screens.web.product.partials.categories-recursion', ['children' => $child->childrenRecursive])
    </ul>
    @endif
</li>
@endforeach --}}
