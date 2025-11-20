@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@php($brand = trim($slot))
@if (true)
    {{-- Branding fijo de Comisoft --}}
    Comisoft
@else
    {!! $slot !!}
@endif
</a>
</td>
</tr>
