<x-layouts.main>
    <x-slot:title>
        Новое объявление
    </x-slot>

    <div class="container" style="text-align: center;">
        <h2>Выберите категорию, подкатегорию и напишите объявление</h2>
    </div>

    <div class="col-md-6 offset-md-3">

        <form action="{{ route('post.store') }}" method="post">
            @csrf

            <div class="mb-3">
                <label for="category-select" class="form-label">Категория</label>
                <select name="category"
                        id="category-select"
                        class="form-control @error('category') is-invalid @enderror"
                    {{--                        required--}}
                >
                    <option value="">-- Выберите категорию --</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach

                </select>
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subcategory-select" class="form-label">Подкатегория</label>
                <select name="subcategory"
                        id="subcategory-select"
                        class="form-control @error('subcategory') is-invalid @enderror"
                    {{--                        required--}}
                >
                    <option value="">-- Выберите подкатегорию --</option>

                </select>
                @error('subcategory')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Объявление</label>
                <textarea
                    name="content"
                    placeholder="Текст вашего объявления"
                    class="form-control @error('content') is-invalid @enderror"
                    id="content"
{{--                    required--}}
                ></textarea>
                @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Опубликовать</button>

        </form>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category"]').on('change', function() {
                var categoryID = $(this).val();
                if(categoryID) {
                    $.ajax({
                        url: '/subcategory/'+categoryID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="subcategory"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="subcategory"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="subcategory"]').empty();
                }
            });
        });
    </script>

</x-layouts.main>
