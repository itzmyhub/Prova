<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Title</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestão financeira</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Pagamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Parcelamentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container mt-2">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="accordion mb-3" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header " id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    + Novo Pagamento
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <form action="{{ route('pagamentos.store') }} " method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_description"> </label>
                                <input type="text" class="form-control @error('descricao') is-invalid @enderror"  id="payment_description" name="descricao" value="{{old('descricao')}}">
                                @error('descricao')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="payment_amount">Amount</label>
                                <input type="text" class="form-control @error('valor') is-invalid @enderror"  id="payment_amount" name="valor" value="{{old('valor')}}">
                                @error('valor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="payment_date">Date</label>
                                <input type="date" class="form-control @error('data') is-invalid @enderror"  id="payment_date" name="data" value="{{old('data')}}">
                                @error('data')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_method">Method</label>
                                <select id="payment_method" name="metodo_pagamento" class="form-select @error('metodo_pagamento') is-invalid @enderror"
                                        aria-label="Default select example">
                                    <option {{old('metodo_pagamento') == null ? 'selected' : ''}}>Open this select menu</option>
                                    <option value="Pix" {{old('metodo_pagamento') == 'Pix' ? 'selected' : ''}}>Pix</option>
                                    <option value="Cartão Black" {{old('metodo_pagamento') == 'Cartão Black' ? 'selected' : ''}}>Cartão black</option>
                                    <option value="Cartão Amazon" {{old('metodo_pagamento') == 'Cartão Amazon' ? 'selected' : ''}}>Cartão Amazon</option>
                                    <option value="Cartão Inter" {{old('metodo_pagamento') == 'Cartão Inter' ? 'selected' : ''}}>Cartão Inter</option>
                                </select>
                                @error('metodo_pagamento')
                                <div class="invalid-feedback">
                                    {{ "Selecione um método de pagamento." }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category">Category</label>
                                <select id="category" name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror"
                                        aria-label="Default select example">
                                    <option {{old('categoria_id') == null ? 'selected' : ''}}>Open this select menu</option>
                                    @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}" {{old('categoria_id') == $categoria->id ? 'selected' : ''}}>{{$categoria->nome}}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                <div class="invalid-feedback">
                                    {{ "Selecione uma categoria." }}
                                </div>
                                @enderror
                            </div>

                        </div>
                        <input type="hidden" name="pago" value="0">
                        <div class="d-grid gap-2 d-md-flex justify-content-end mb-3">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_paid" name="pago" value="1">
                                <label class="form-check-label" for="is_paid">Pago</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <h1>Pagamentos</h1>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
            <th scope="col">Method</th>
            <th scope="col">Category</th>
            <th scope="col">Pago</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pagamentos as $pagamento)
        <tr>
            <td>{{$pagamento->descricao}}</td>
            <td>{{$pagamento->valor}}</td>
            <td>{{$pagamento->data}}</td>

            <form action="{{ route('pagamento.update', $pagamento->id) }}" method="POST">
                @csrf
                @method('PUT')

            <td>

                <select name="metodo_pagamento" class="form-select"
                        aria-label="Default select example">
                    <option selected>{{ucwords($pagamento->metodo_pagamento)}}</option>
                    @if($pagamento->metodo_pagamento != 'pix')
                        <option value="Pix">Pix</option>
                    @endif

                    @if($pagamento->metodo_pagamento != 'cartao black')
                        <option value="Cartão Black">Cartão black</option>
                    @endif

                    @if($pagamento->metodo_pagamento != 'cartao amazon')
                        <option value="Cartão Amazon">Cartão Amazon</option>
                    @endif

                    @if($pagamento->metodo_pagamento != 'cartao inter')
                        <option value="Cartão Inter">Cartão Inter</option>
                    @endif
                </select>

            </td>
            <td>
                <select name="categoria_id" class="form-select" aria-label="Default select example">

                    <option selected value="{{$pagamento->categoria_id}}">{{$pagamento->categoria->nome}}</option>
                    @foreach($categorias as $categoria)
                        @if($categoria->nome != $pagamento->categoria->nome)
                            <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" name="pago" {{$pagamento->pago == 1 ? 'checked' : ''}} value="1">
                </div>
            </td>

            <td>
                <button type="submit" class="update-btn">Atualizar</button>
            </td>
            </form>
        </tr>
        @endforeach
        </tbody>
    </table>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    fillPaymentDateInputWithCurrentDate();

    function fillPaymentDateInputWithCurrentDate() {
        const paymentDateInput = document.getElementById('date');
        paymentDateInput.value = new Date().toLocaleString('pt-BR', {timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone});
    }
</script>


</body>
</html>
