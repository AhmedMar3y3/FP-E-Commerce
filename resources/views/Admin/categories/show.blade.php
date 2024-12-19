@extends('Admin.layout')

@section('main')
<div class="container">
    <h2>الفئة: {{ $category->name }}</h2>
    
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">العودة إلى الفئات</a>

    <!-- قائمة المنتجات في هذه الفئة -->
    <h3>الفئات الفرعية التابعة لهذه الفئة</h3>

    @if($category->subs->isEmpty())
        <p>لم يتم العثور على فئات فرعية في هذه الفئة.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>العمليات</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach($category->subs as $sub)
                    <tr>
                        <td>{{ $sub->id }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>
                            {{-- TODO: عمليات CRUD --}}
                            {{-- <a href="{{ route('subcategories.show', $sub->id) }}" class="btn btn-info">عرض</a>
                            <form action="{{ route('subcategories.destroy', $sub->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
