@extends('Admin.layout')
@section('main')

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <h2>جميع الفئات</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Category Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        إضافة فئة جديدة
    </button>

    <!-- Category Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <!-- Category Name with Toggle Arrow -->
                        <span class="d-flex align-items-center">
                            <button class="btn btn-sm btn-link text-decoration-none" onclick="toggleSubcategories({{ $category->id }})">
                                <i class="fas fa-chevron-down" id="toggleIcon{{ $category->id }}"></i>
                            </button>
                            {{ $category->name }}
                        </span>

                        <!-- Subcategories List -->
                        <ul class="list-group mt-2 d-none" id="subcategories{{ $category->id }}">
                            @forelse ($category->subs as $sub)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $sub->name }}
                                    <!-- Delete Subcategory Button -->
                                    <form action="{{ route('subs.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الفئة الفرعية؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </li>
                            @empty
                                <li class="list-group-item text-center">لا توجد فئات فرعية</li>
                            @endforelse
                        </ul>
                    </td>
                    <td>
                        <!-- Add Subcategory Button -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal{{ $category->id }}">
                            إضافة فئة فرعية
                        </button>

                        <!-- Delete Category Button -->
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه الفئة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> حذف
                                </button>
                        </form>

                        <!-- Subcategory Modal -->
                        <div class="modal fade" id="addSubCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="addSubCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('subs.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addSubCategoryModalLabel{{ $category->id }}">إضافة فئة فرعية</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="subcategoryName" class="form-label">اسم الفئة الفرعية</label>
                                                <input type="text" name="name" class="form-control" id="subcategoryName" required>
                                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">لم يتم العثور على فئات.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">إضافة فئة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">اسم الفئة</label>
                        <input type="text" name="name" class="form-control" id="categoryName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    function toggleSubcategories(categoryId) {
        const subcategories = document.getElementById(`subcategories${categoryId}`);
        const icon = document.getElementById(`toggleIcon${categoryId}`);
        
        if (subcategories.classList.contains('d-none')) {
            subcategories.classList.remove('d-none');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            subcategories.classList.add('d-none');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>

@endsection
