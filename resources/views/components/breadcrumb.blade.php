<!-- start page title -->
<ol class="breadcrumb">
  @foreach($page_breadcrumbs as $item)
    @if($loop->last)
      @php
        $active = ' active';
      @endphp
    @endif
    <li class="breadcrumb-item{{ $active ?? "" }}" {{ isset($active) ? "aria-current='page'" : '' }}>
      @if(!$loop->last)
        <a href={{ $item['url'] ?? "#" }}><p style="font-weight: bold; font-size:15px;">{{ $item['title'] ?? '' }}</p></a>
      @else
      <p style="font-weight: bold; font-size:15px; width:150px;">{{ $item['title' ?? ''] }}</p>
      @endif
    </li>
  @endforeach
</ol>
<!-- end page title -->


