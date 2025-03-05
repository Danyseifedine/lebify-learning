@props(['title', 'class' => '', 'filterValue' => ''])

<a href="#" class="tag rounded-pill {{ $class }}"
    data-filter-value="{{ $filterValue }}">{{ $title }}</a>
