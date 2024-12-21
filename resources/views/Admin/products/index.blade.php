@extends('Admin.layout')

@section('main')
<div class="container">
    <h1>المنتجات</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">إضافة منتج</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>العلامة التجارية</th>
                <th>الاسم</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->title }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">عرض</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
