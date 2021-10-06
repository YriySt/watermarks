<div class="main-form">
    <form method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="input_image">
        <br>
        <input type="submit" value="Set watermark">
    </form>
</div>
