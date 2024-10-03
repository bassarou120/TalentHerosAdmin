@if($url)

{{--<h style="color: #ebde8f"></h>--}}
    <video width="250" height="100" controls>
        <source src="{{ $url }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
@endif
