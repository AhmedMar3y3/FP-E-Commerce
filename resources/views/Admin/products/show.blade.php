@extends('Admin.layout')

@section('main')
<div class="container">
    <h1 class="mb-4">تفاصيل المنتج</h1>

    <!-- Success and Error Messages -->
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

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3>{{ $product->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Product Images -->
                <div class="col-md-4">
                    <h5>الصور</h5>
                    @if($product->images->count() > 0)
                        <div class="d-flex flex-wrap">
                            @foreach ($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_url) }}" class="img-thumbnail me-2 mb-2" style="width: 100px; height: 100px;" alt="Product Image">
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">لا توجد صور لهذا المنتج</p>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>العلامة التجارية</th>
                            <td>{{ $product->brand }}</td>
                        </tr>
                        <tr>
                            <th>الوصف</th>
                            <td>{{ $product->description }}</td>
                        </tr>
                        <tr>
                            <th>الكمية</th>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                        <tr>
                            <th>السعر</th>
                            <td>{{ $product->price }} جنيه</td>
                        </tr>
                        @if($product->is_on_sale)
                            <tr>
                                <th>سعر التخفيض</th>
                                <td>{{ $product->sale_price }} جنيه</td>
                            </tr>
                        @endif
                        <tr>
                            <th>الفئة الفرعية</th>
                            <td>{{ $product->subcategory->name ?? 'غير محددة' }}</td>
                        </tr>
                        <tr>
                            <th>الألوان</th>
                            <td>
                                @if($product->colors->count() > 0)
                                    {{ $product->colors->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-muted">لا توجد ألوان</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>المقاسات</th>
                            <td>
                                @if($product->sizes->count() > 0)
                                    {{ $product->sizes->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-muted">لا توجد مقاسات</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">رجوع</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">تعديل</a>
        </div>
    </div>
</div>
@endsection
