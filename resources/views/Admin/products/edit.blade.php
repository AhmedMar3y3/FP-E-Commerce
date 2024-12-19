@extends('Admin.layout')

@section('main')
<div class="container">
    <h1>تعديل المنتج</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @method('PUT')
        @csrf

        <!-- Success and Error Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Details -->
        <div class="mb-3">
            <label for="brand" class="form-label">العلامة التجارية</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $product->title) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">الكمية</label>
            <input type="number" name="quantity" step="0.01" class="form-control" value="{{ old('quantity', $product->quantity) }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">السعر</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label for="subcategory_id" class="form-label">الفئة الفرعية</label>
            <select name="subcategory_id" class="form-control">
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Colors Section -->
        <h4>الألوان</h4>
        <div id="colors-container">
            @foreach(old('colors', $product->colors->pluck('id')->toArray()) as $index => $color)
            <div class="color-row mb-3">
                <label for="color_{{ $index }}" class="form-label">اللون</label>
                <div class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <select name="colors[{{ $index }}]" id="color_{{ $index }}" class="form-select">
                            <option value="" selected disabled>اختر لونًا</option>
                            @foreach ($colors as $colorOption)
                                <option value="{{ $colorOption->id }}" {{ $color == $colorOption->id ? 'selected' : '' }}>
                                    {{ $colorOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-color">إزالة</button>
                    </div>
                </div>
            </div>
        @endforeach
        
        </div>
        <button type="button" id="add-color" class="btn btn-primary mb-3">إضافة لون</button>

        <!-- Sizes Section -->
        <h4>الأحجام</h4>
        <div id="sizes-container">
            @foreach(old('sizes', $product->sizes->pluck('id')->toArray()) as $index => $size)
                <div class="size-row mb-3">
                    <label for="size_{{ $index }}" class="form-label">الحجم</label>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-8">
                            <select name="sizes[{{ $index }}]" id="size_{{ $index }}" class="form-select">
                                <option value="" selected disabled>اختر حجمًا</option>
                                @foreach ($sizes as $sizeOption)
                                    <option value="{{ $sizeOption->id }}" {{ $size == $sizeOption->id ? 'selected' : '' }}>
                                        {{ $sizeOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger remove-size">إزالة</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-size" class="btn btn-primary mb-3">إضافة حجم</button>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success float-start">تحديث</button>
    </form>
</div>

<script>
    // JavaScript for dynamically adding/removing color and size options
    let colorIndex = {{ count(old('colors', $product->colors)) }};
    document.getElementById('add-color').addEventListener('click', function () {
        const colorsContainer = document.getElementById('colors-container');
        const newColorRow = document.createElement('div');
        newColorRow.classList.add('color-row', 'mb-3');
        newColorRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <select name="colors[${colorIndex}]" class="form-select">
                        <option value="" selected disabled>اختر لونًا</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-color">إزالة</button>
                </div>
            </div>
        `;
        colorsContainer.appendChild(newColorRow);
        colorIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-color')) {
            e.target.closest('.color-row').remove();
        }
    });

    // Sizes handling
    let sizeIndex = {{ count(old('sizes', $product->sizes)) }};
    document.getElementById('add-size').addEventListener('click', function () {
        const sizesContainer = document.getElementById('sizes-container');
        const newSizeRow = document.createElement('div');
        newSizeRow.classList.add('size-row', 'mb-3');
        newSizeRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <select name="sizes[${sizeIndex}]" class="form-select">
                        <option value="" selected disabled>اختر حجمًا</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-size">إزالة</button>
                </div>
            </div>
        `;
        sizesContainer.appendChild(newSizeRow);
        sizeIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-size')) {
            e.target.closest('.size-row').remove();
        }
    });
</script>
@endsection
