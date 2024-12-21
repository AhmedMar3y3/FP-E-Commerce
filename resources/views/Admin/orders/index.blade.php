@extends('Admin.layout')

@section('main')
<div class="container">
    <h1>إدارة الطلبات</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>العنوان</th>
                    <th>تفاصيل المنتج</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            {{ $order->user->name ?? 'غير متوفر' }} <br>
                            <small>{{ $order->user->email ?? '' }}</small>
                        </td>
                        <td>{{ $order->address }}</td>
                        <td>
                            <strong>المنتج:</strong> {{ $order->products->title}} <br>
                            <strong>اللون:</strong> {{ $order->products->colors->name }} <br>
                            <strong>المقاس:</strong> {{ $order->products->sizes->name }}
                        </td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if ($order->status === 'قيد الانتظار')
                                <a href="{{ route('orders.accept', $order->id) }}" class="btn btn-success btn-sm">قبول</a>
                                <a href="{{ route('orders.reject', $order->id) }}" class="btn btn-danger btn-sm">رفض</a>
                            @elseif ($order->status === 'تم الموافقة')
                                <a href="{{ route('orders.delivery', $order->id) }}" class="btn btn-primary btn-sm">تم التوصيل</a>
                            @else
                                <span class="text-muted">لا توجد إجراءات</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $orders->links() }}
    @else
        <div class="alert alert-info">لا توجد طلبات لعرضها</div>
    @endif
</div>
@endsection
