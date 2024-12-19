@extends('Admin.layout')

@section('main')
<div class="container">
    <h1>إنشاء منتج</h1>
    <form action="{{ route('products.store') }}" method="POST">
        
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
        @csrf

        <!-- Product Details -->
        <div class="mb-3">
            <label for="brand" class="form-label">العلامة التجارية</label>
            <input type="text" name="brand" class="form-control" value="{{ $product->brand ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">الاسم</label>
            <input type="text" name="title" class="form-control" value="{{ $product->title ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" class="form-control" required>{{ $product->description ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">الكمية</label>
            <input type="number" name="quantity" step="0.01" class="form-control" value="{{ $product->quantity ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">السعر</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="subcategory_id" class="form-label">الفئة الفرعية</label>
            <select name="subcategory_id" class="form-control" required>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" {{ isset($product) && $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

           <!-- Image Upload Section -->
    <div class="mb-3">
        <label for="images" class="form-label">الصور</label>
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
    </div>

        <!-- Colors Section -->
        <h4>الالوان</h4>
        <div id="colors-container">
            <div class="color-row mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <select name="colors[0]" id="color_0" class="form-select" required>
                            <option value="" selected disabled>اختر لون</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-color">مسح</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-color" class="btn btn-primary mb-3">اضافة</button>

        <!-- Sizes Section -->
        <h4>المقاسات</h4>
        <div id="sizes-container">
            <div class="size-row mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <select name="sizes[0]" id="size_0" class="form-select" required>
                            <option value="" selected disabled>اختر مقاس</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-size">مسح</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add-size" class="btn btn-primary mb-3">اضافة</button>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success float-start">اضافة المنتج</button>
    </form>
</div>

<script>
    // Colors
    let colorIndex = 1;
    document.getElementById('add-color').addEventListener('click', function () {
        const colorsContainer = document.getElementById('colors-container');
        const newColorRow = document.createElement('div');
        newColorRow.classList.add('color-row', 'mb-3');
        newColorRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <select name="colors[${colorIndex}]" class="form-select" required>
                        <option value="" selected disabled>اختر لون</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-color">مسح</button>
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

    // Sizes
    let sizeIndex = 1;
    document.getElementById('add-size').addEventListener('click', function () {
        const sizesContainer = document.getElementById('sizes-container');
        const newSizeRow = document.createElement('div');
        newSizeRow.classList.add('size-row', 'mb-3');
        newSizeRow.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <select name="sizes[${sizeIndex}]" class="form-select" required>
                        <option value="" selected disabled>اختر مقاس</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-size">مسح</button>
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
