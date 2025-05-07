@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Nueva Venta</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Ventas</a></li>
                        <li class="breadcrumb-item active">Nueva</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.sales.store') }}" method="POST" id="saleForm">
                        @csrf
                        <input type="hidden" name="cash_register_id" value="{{ $cashRegister->id }}">

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Cliente</label>
                                    <select class="form-select form-control" name="customer_id">
                                        <option value="">Cliente General</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }} - {{ $customer->document_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Producto</label>
                                    <select class="form-select form-control" id="productSelect">
                                        <option value="">Seleccione un producto</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->stock }}">
                                                {{ $product->name }} - Stock: {{ $product->stock }} - Precio: {{ $product->price }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="quantity" min="1" value="1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-primary d-block w-100" id="addProduct">
                                        Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table" id="productsTable">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unit.</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong id="totalAmount">$0.00</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select form-control" name="payment_method" required>
                                        <option value="CASH">Efectivo</option>
                                        <option value="CARD">Tarjeta</option>
                                        <option value="TRANSFER">Transferencia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Notas</label>
                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                Registrar Venta
                            </button>
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const quantityInput = document.getElementById('quantity');
    const addProductBtn = document.getElementById('addProduct');
    const productsTable = document.getElementById('productsTable').getElementsByTagName('tbody')[0];
    const totalAmountElement = document.getElementById('totalAmount');
    const submitBtn = document.getElementById('submitBtn');
    const saleForm = document.getElementById('saleForm');

    let products = [];
    let total = 0;

    function updateTotal() {
        total = products.reduce((sum, product) => sum + product.subtotal, 0);
        totalAmountElement.textContent = `$${total.toFixed(2)}`;
        submitBtn.disabled = products.length === 0;
    }

    function addProduct() {
        const productId = productSelect.value;
        if (!productId) return;

        const option = productSelect.options[productSelect.selectedIndex];
        const quantity = parseInt(quantityInput.value);
        const price = parseFloat(option.dataset.price);
        const stock = parseInt(option.dataset.stock);

        if (quantity > stock) {
            alert('La cantidad excede el stock disponible');
            return;
        }

        const product = {
            id: productId,
            name: option.text.split(' - ')[0],
            quantity: quantity,
            price: price,
            subtotal: quantity * price
        };

        products.push(product);
        updateTable();
        updateTotal();

        // Reset form
        productSelect.value = '';
        quantityInput.value = 1;
    }

    function updateTable() {
        productsTable.innerHTML = '';
        products.forEach((product, index) => {
            const row = productsTable.insertRow();
            row.innerHTML = `
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>$${product.price.toFixed(2)}</td>
                <td>$${product.subtotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${index})">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </td>
            `;
        });
    }

    window.removeProduct = function(index) {
        products.splice(index, 1);
        updateTable();
        updateTotal();
    };

    addProductBtn.addEventListener('click', addProduct);

    saleForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Crear array de productos para el formulario
        const productsInput = document.createElement('input');
        productsInput.type = 'hidden';
        productsInput.name = 'products';
        productsInput.value = JSON.stringify(products);
        saleForm.appendChild(productsInput);

        // Enviar formulario
        saleForm.submit();
    });
});
</script>
@endpush
@endsection
