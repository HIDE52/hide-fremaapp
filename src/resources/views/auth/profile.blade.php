<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <button type="submit">更新する</button>
</form>s