<html>

@include('image.header')

<body>
<div class="main-block">
    <img src="{{asset($output_image)}}">
</div>
<div class="back-to">
    <br>
    <button>
    <a href="{{asset($output_image)}}" download>Download</a>
    </button>
    <button>
    <a href="/">Back to main</a>
    </button>
</div>
</body>

@include('image.footer')

</html>
