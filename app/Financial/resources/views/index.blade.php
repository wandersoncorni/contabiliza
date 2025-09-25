<div class="container-fluid py-4">
    <!-- Seção do nome da empresa -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body bg-light">
                    <h2 class="h4 fw-bold mb-0">
                        <i class="heroicon heroicon-building-office me-2" style="width: 24px; height: 24px;"></i>
                        Olá, {{ session('company_name', 'Maissoft Sistemas - ME') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards -->
    <div class="row mb-4">
        <!-- Card Recebidas -->
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow">
                <div class="card-body" style="background-color: #192BC2; color: white;">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape rounded me-4 me-sm-0" style="background-color: rgba(255, 255, 255, 0.2);">
                                <svg class="icon icon-md" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5" style="color: white;">Recebidas</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($clientes ?? 345678, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5" style="color: white;">Recebidas</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($recebidas ?? 2980.80, 2, ',', '.') }}</h3>
                            </div>
                            <small class="d-flex align-items-center" style="color: white;">
                                Feb 1 - Apr 1,
                                <svg class="icon icon-xxs ms-2 me-1" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.476-.004 6.01 6.01 0 01-1.912 2.706A3.75 3.75 0 0012 9.75h-1.5a3.75 3.75 0 00-3.75 3.75v1.5a.75.75 0 01-1.5 0v-1.5a5.25 5.25 0 015.25-5.25h1.5a1.5 1.5 0 011.5 1.5v.75a.75.75 0 001.5 0v-.75a3 3 0 00-.588-1.803 8.238 8.238 0 00-3.412-.9z" clip-rule="evenodd" />
                                </svg> SUA
                            </small>
                            <div class="small d-flex mt-1">
                                <svg class="icon icon-xs text-success" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 5.25a.75.75 0 01.75.75v5.59l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V6a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                </svg>
                                <div style="color: white;"><span class="text-success fw-bolder me-1">22%</span> Since last month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Confirmadas -->
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow">
                <div class="card-body" style="background-color: #1188FE; color: white;">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape rounded me-4 me-sm-0" style="background-color: rgba(255, 255, 255, 0.2);">
                                <svg class="icon icon-md" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5" style="color: white;">A Receber</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($confirmadas ?? 345678, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5" style="color: white;">A Receber</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($confirmadas_valor ?? 8754.26, 2, ',', '.') }}</h3>
                            </div>
                            <small class="d-flex align-items-center" style="color: white;">
                                Feb 1 - Apr 1,
                                <svg class="icon icon-xxs ms-2 me-1" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.476-.004 6.01 6.01 0 01-1.912 2.706A3.75 3.75 0 0012 9.75h-1.5a3.75 3.75 0 00-3.75 3.75v1.5a.75.75 0 01-1.5 0v-1.5a5.25 5.25 0 015.25-5.25h1.5a1.5 1.5 0 011.5 1.5v.75a.75.75 0 001.5 0v-.75a3 3 0 00-.588-1.803 8.238 8.238 0 00-3.412-.9z" clip-rule="evenodd" />
                                </svg> SUA
                            </small>
                            <div class="small d-flex mt-1">
                                <svg class="icon icon-xs text-success" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 5.25a.75.75 0 01.75.75v5.59l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V6a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                </svg>
                                <div style="color: white;"><span class="text-success fw-bolder me-1">22%</span> Since last month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Pendentes -->
        
        <!-- Card Vencidas -->
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow">
                <div class="card-body" style="background-color: #9026F0; color: white;">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape rounded me-4 me-sm-0" style="background-color: rgba(255, 255, 255, 0.2);">
                                <svg class="icon icon-md" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm0 15a.75.75 0 01-.75-.75v-2.25a.75.75 0 011.5 0v2.25a.75.75 0 01-.75.75zm0-6a.75.75 0 01-.75-.75v-1.5a.75.75 0 111.5 0v1.5a.75.75 0 01-.75.75z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5" style="color: white;">Vencidas</h2>
                                <h3 class="mb-1" style="color: white;">{{ number_format($vencidas ?? 50.88, 2, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5" style="color: white;"> Pagos</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($vencidas ?? 50.88, 2, ',', '.') }}</h3>
                                
                            </div>
                                                   <small class="d-flex align-items-center" style="color: white;">
                                Feb 1 - Apr 1,
                                <svg class="icon icon-xxs ms-2 me-1" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.476-.004 6.01 6.01 0 01-1.912 2.706A3.75 3.75 0 0012 9.75h-1.5a3.75 3.75 0 00-3.75 3.75v1.5a.75.75 0 01-1.5 0v-1.5a5.25 5.25 0 015.25-5.25h1.5a1.5 1.5 0 011.5 1.5v.75a.75.75 0 001.5 0v-.75a3 3 0 00-.588-1.803 8.238 8.238 0 00-3.412-.9z" clip-rule="evenodd" />
                                </svg> SUA
                            </small>
                            <div class="small d-flex mt-1">
                                <svg class="icon icon-xs text-danger" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 18.75a.75.75 0 01-.75-.75V6.41l-2.22 2.22a.75.75 0 01-1.06-1.06l3.5-3.5a.75.75 0 011.06 0l3.5 3.5a.75.75 0 01-1.06 1.06l-2.22-2.22V18a.75.75 0 01-.75.75z" clip-rule="evenodd" />
                                </svg>
                                <div style="color: white;"><span class="text-danger fw-bolder me-1">2%</span> Since last month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-3">
            <div class="card border-0 shadow">
                <div class="card-body" style="background-color: #FA146E; color: white;">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape rounded me-4 me-sm-0" style="background-color: rgba(255, 255, 255, 0.2);">
                                <svg class="icon icon-md" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="fw-extrabold h5" style="color: white;">Pendentes</h2>
                                <h3 class="mb-1" style="color: white;">{{ number_format($pendentes ?? 430.50, 2, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h5" style="color: white;">A Pagar</h2>
                                <h3 class="fw-extrabold mb-1" style="color: white;">{{ number_format($pendentes ?? 430.50, 2, ',', '.') }}</h3>
                            </div>
                            <small class="d-flex align-items-center" style="color: white;">
                                Feb 1 - Apr 1,
                                <svg class="icon icon-xxs ms-2 me-1" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.476-.004 6.01 6.01 0 01-1.912 2.706A3.75 3.75 0 0012 9.75h-1.5a3.75 3.75 0 00-3.75 3.75v1.5a.75.75 0 01-1.5 0v-1.5a5.25 5.25 0 015.25-5.25h1.5a1.5 1.5 0 011.5 1.5v.75a.75.75 0 001.5 0v-.75a3 3 0 00-.588-1.803 8.238 8.238 0 00-3.412-.9z" clip-rule="evenodd" />
                                </svg> SUA
                            </small>
                            <div class="small d-flex mt-1">
                                <svg class="icon icon-xs text-danger" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 18.75a.75.75 0 01-.75-.75V6.41l-2.22 2.22a.75.75 0 01-1.06-1.06l3.5-3.5a.75.75 0 011.06 0l3.5 3.5a.75.75 0 01-1.06 1.06l-2.22-2.22V18a.75.75 0 01-.75.75z" clip-rule="evenodd" />
                                </svg>
                                <div style="color: white;"><span class="text-danger fw-bolder me-1">2%</span> Since last month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão com Menu Dropdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="financialMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                    </svg>
                    Ações
                </button>
                <ul class="dropdown-menu" aria-labelledby="financialMenu">
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25V9a2.25 2.25 0 00-2.25-2.25h-7.5zM7.5 9.75a.75.75 0 01.75-.75h7.5a.75.75 0 01.75.75v6a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75v-6z" clip-rule="evenodd" />
                            </svg>
                            Lançamento
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                            </svg>
                            Caixa
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('view.accounts') }}">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25V9a2.25 2.25 0 00-2.25-2.25h-7.5zM7.5 9.75a.75.75 0 01.75-.75h7.5a.75.75 0 01.75.75v6a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75v-6z" clip-rule="evenodd" />
                            </svg>
                            Contas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 3.75A2.75 2.75 0 008.75 1h6.5A2.75 2.75 0 0018 3.75v.443c.572.055 1.14.122 1.706.2.566.077 1.065-.34 1.065-.892 0-.672-.727-1.044-1.218-.718-.55.366-1.122.657-1.706.88v15.337c.584.223 1.156.514 1.706.88.491.326 1.218-.046 1.218-.718 0-.552-.499-.969-1.065-.892-.566.078-1.134.145-1.706.2V20.25A2.75 2.75 0 0015.25 23h-6.5A2.75 2.75 0 006 20.25v-.443c-.572-.055-1.14-.122-1.706-.2-.566.077-1.065.34-1.065.892 0 .672.727 1.044 1.218.718.55-.366 1.122-.657 1.706-.88V5.193c-.584-.223-1.156-.514-1.706-.88C3.727 3.987 3 4.359 3 5.031c0 .552.499.969 1.065.892.566-.078 1.134-.145 1.706-.2V3.75zm3.757 6.032a.75.75 0 01.743.832l-.5 4a.75.75 0 11-1.486-.164l.5-4a.75.75 0 01.743-.668zm5.5 0a.75.75 0 01.743.668l-.5 4a.75.75 0 11-1.486.164l.5-4a.75.75 0 01.743-.832z" clip-rule="evenodd" />
                            </svg>
                            Planos de Contas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.897 7.897 0 00-.398.15c-.414.16-.755.456-.98.876l-.047.1c-.205.436-.404.912-.513 1.398-.108.487-.188.975-.188 1.475 0 .498.08.986.188 1.474.109.487.308.963.514 1.4l.046.1c.224.42.565.716.98.876a7.89 7.89 0 00.398.15c.182.088.277.228.297.349l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.143-.055.279-.112.398-.15.415-.16.756-.456.98-.876l.047-.1c.205-.437.404-.913.513-1.4.108-.487.188-.974.188-1.474s-.08-.987-.188-1.475c-.109-.486-.308-.962-.514-1.398l-.046-.1c-.224-.42-.565-.717-.98-.876a7.89 7.89 0 00-.398-.15c-.183-.088-.277-.229-.297-.349l-.178-1.071c-.151-.904-.933-1.567-1.85-1.567h-1.844zM12 15.75a3.75 3.75 0 110-7.5 3.75 3.75 0 010 7.5z" clip-rule="evenodd" />
                            </svg>
                            Configurações
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Lançamentos, Impostos, Contas -->
    <div class="row mb-4">
        <!-- Lançamentos -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Lançamentos</h2>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-sm btn-primary">Ver Todos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-bottom" scope="col">Data</th>
                                <th class="border-bottom" scope="col">Descrição</th>
                                <th class="border-bottom" scope="col">Plano de Contas</th>
                                <th class="border-bottom" scope="col">Valor</th>
                                <th class="border-bottom" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lancamentos ?? [
                                ['data' => '14/07/2025', 'descricao' => 'Serviço de Alarme Jun2025', 'plano' => 'Água', 'valor' => -120.00, 'status' => 'success'],
                                ['data' => '14/07/2025', 'descricao' => 'Segurança Jun2025', 'plano' => 'Água', 'valor' => -200.00, 'status' => 'success'],
                                ['data' => '14/07/2025', 'descricao' => 'Conta de Água Jun2025', 'plano' => 'Água', 'valor' => -282.50, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Conta de Internet Jun2025', 'plano' => 'Internet', 'valor' => -199.99, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Conta de Telefone Jun2025', 'plano' => 'Telefone', 'valor' => -150.00, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Conta de Energia Jun2025', 'plano' => 'Energia Elétrica', 'valor' => -434.26, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Tratamento Capilar', 'plano' => 'Prestação de Serviços', 'valor' => 1200.00, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Aplicação Botulínica', 'plano' => 'Prestação de Serviços', 'valor' => 800.00, 'status' => 'success'],
                                ['data' => '15/07/2025', 'descricao' => 'Bombeiro Hidráulico', 'plano' => 'Manutenção Predial', 'valor' => -230.00, 'status' => 'success']
                            ] as $lancamento)
                                <tr>
                                    <th class="text-gray-900" scope="row">{{ $lancamento['data'] }}</th>
                                    <td class="fw-bolder text-gray-500">{{ $lancamento['descricao'] }}</td>
                                    <td class="fw-bolder text-gray-500">{{ $lancamento['plano'] }}</td>
                                    <td class="fw-bolder text-gray-500">
                                        <div class="d-flex">
                                            <svg class="icon icon-xs {{ $lancamento['valor'] < 0 ? 'text-danger' : 'text-success' }} me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="{{ $lancamento['valor'] < 0 ? 'M12 18.75a.75.75 0 01-.75-.75V6.41l-2.22 2.22a.75.75 0 01-1.06-1.06l3.5-3.5a.75.75 0 011.06 0l3.5 3.5a.75.75 0 01-1.06 1.06l-2.22-2.22V18a.75.75 0 01-.75.75z' : 'M12 5.25a.75.75 0 01.75.75v5.59l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V6a.75.75 0 01.75-.75z' }}" clip-rule="evenodd" />
                                            </svg>
                                            {{ number_format(abs($lancamento['valor']), 2, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-gray-500">
                                        <svg class="icon icon-xs text-{{ $lancamento['status'] }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                                        </svg>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Impostos e Contas -->
        <div class="col-12 col-md-6 mb-3">
            <!-- Impostos -->
            <div class="card border-0 shadow mb-3">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h2 class="fs-5 fw-bold mb-0">Vencidos (mês)</h2>
                    <a href="#" class="btn btn-sm btn-primary">Detalhar</a>
                </div>
                <div class="card-body">
                    @foreach ($impostos ?? [
                        ['nome' => 'A Pagar', 'quantidade' => 9, 'percentual' => 75, 'cor' => 'success'],
                        ['nome' => 'A Receber', 'quantidade' => 3, 'percentual' => 25, 'cor' => 'info'],                        
                    ] as $imposto)
                        <div class="row mb-4">
                            <div class="col-auto">
                                <svg class="icon icon-sm text-gray-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 3.75A2.75 2.75 0 008.75 1h6.5A2.75 2.75 0 0018 3.75v.443c.572.055 1.14.122 1.706.2.566.077 1.065-.34 1.065-.892 0-.672-.727-1.044-1.218-.718-.55.366-1.122.657-1.706.88v15.337c.584.223 1.156.514 1.706.88.491.326 1.218-.046 1.218-.718 0-.552-.499-.969-1.065-.892-.566.078-1.134.145-1.706.2V20.25A2.75 2.75 0 0015.25 23h-6.5A2.75 2.75 0 006 20.25v-.443c-.572-.055-1.14-.122-1.706-.2-.566.077-1.065.34-1.065.892 0 .672.727 1.044 1.218.718.55-.366 1.122-.657 1.706-.88V5.193c-.584-.223-1.156-.514-1.706-.88C3.727 3.987 3 4.359 3 5.031c0 .552.499.969 1.065.892.566-.078 1.134-.145 1.706-.2V3.75zm3.757 6.032a.75.75 0 01.743.832l-.5 4a.75.75 0 11-1.486-.164l.5-4a.75.75 0 01.743-.668zm5.5 0a.75.75 0 01.743.668l-.5 4a.75.75 0 11-1.486.164l.5-4a.75.75 0 01.743-.832z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="col">
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <div class="h6 mb-0">{{ $imposto['nome'] }} ({{ $imposto['quantidade'] }})</div>
                                        <div class="small fw-bold text-gray-500"><span>{{ $imposto['percentual'] }} %</span></div>
                                    </div>
                                    <div class="progress mb-0">
                                        <div class="progress-bar bg-{{ $imposto['cor'] }}" role="progressbar" aria-valuenow="{{ $imposto['percentual'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $imposto['percentual'] }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Contas -->
            <div class="card border-0 shadow">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h2 class="fs-5 fw-bold mb-0">Contas</h2>
                    <a href="#" class="btn btn-sm btn-primary">Detalhar</a>
                </div>
                <div class="card-body">
                    @foreach ($contas ?? [
                        ['nome' => 'Sicoob', 'numero' => 'R$ 8.239,78', 'tipo' => '031 - 03489-9', 'status' => 'success'],
                        ['nome' => 'Itaú', 'numero' => 'R$ 62.321,09', 'tipo' => '341 - 0876-6', 'status' => 'success']
                    ] as $conta)
                        <div class="d-flex align-items-center justify-content-between {{ $loop->last ? 'pt-3' : 'border-bottom py-3' }}">
                            <div>
                                <div class="h6 mb-0 d-flex align-items-center">
                                    <svg class="icon icon-xs text-gray-500 me-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25V9a2.25 2.25 0 00-2.25-2.25h-7.5zM7.5 9.75a.75.75 0 01.75-.75h7.5a.75.75 0 01.75.75v6a.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75v-6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $conta['nome'] }}
                                </div>
                                <div class="small card-stats">
                                    {{ $conta['tipo'] }}
                                    <svg class="icon icon-xs text-{{ $conta['status'] }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 5.25a.75.75 0 01.75.75v5.59l2.22-2.22a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 111.06-1.06l2.22 2.22V6a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="d-flex align-items-center fw-bold">
                                    {{ $conta['numero'] }}
                                    <svg class="icon icon-xs text-gray-500 ms-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.252 2.252 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <!-- Gráfico de Lançamentos -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Gráfico de Lançamentos</h2>
                </div>
                <div class="card-body p-2">
                    <div class="ct-chart-ranking ct-golden-section ct-series-a">
                        <div class="chartist-tooltip" style="top: -29.7px; left: 809px;"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                            <g class="ct-grids">
                                <line x1="10" x2="10" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                                <line x1="154.76666259765625" x2="154.76666259765625" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                                <line x1="299.5333251953125" x2="299.5333251953125" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                                <line x1="444.29998779296875" x2="444.29998779296875" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                                <line x1="589.066650390625" x2="589.066650390625" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                                <line x1="733.8333129882812" x2="733.8333129882812" y1="15" y2="517.2833251953125" class="ct-grid ct-horizontal"></line>
                            </g>
                            <g>
                                <g class="ct-series ct-series-a">
                                    <line x1="74.88333129882812" x2="74.88333129882812" y1="517.2833251953125" y2="454.49790954589844" class="ct-bar" ct:value="1"></line>
                                    <line x1="219.64999389648438" x2="219.64999389648438" y1="517.2833251953125" y2="203.3562469482422" class="ct-bar" ct:value="5"></line>
                                    <line x1="364.4166564941406" x2="364.4166564941406" y1="517.2833251953125" y2="391.7124938964844" class="ct-bar" ct:value="2"></line>
                                    <line x1="509.1833190917969" x2="509.1833190917969" y1="517.2833251953125" y2="203.3562469482422" class="ct-bar" ct:value="5"></line>
                                    <line x1="653.9499816894531" x2="653.9499816894531" y1="517.2833251953125" y2="266.14166259765625" class="ct-bar" ct:value="4"></line>
                                    <line x1="798.7166442871094" x2="798.7166442871094" y1="517.2833251953125" y2="328.9270782470703" class="ct-bar" ct:value="3"></line>
                                </g>
                                <g class="ct-series ct-series-b">
                                    <line x1="89.88333129882812" x2="89.88333129882812" y1="517.2833251953125" y2="391.7124938964844" class="ct-bar" ct:value="2"></line>
                                    <line x1="234.64999389648438" x2="234.64999389648438" y1="517.2833251953125" y2="328.9270782470703" class="ct-bar" ct:value="3"></line>
                                    <line x1="379.4166564941406" x2="379.4166564941406" y1="517.2833251953125" y2="266.14166259765625" class="ct-bar" ct:value="4"></line>
                                    <line x1="524.1833190917969" x2="524.1833190917969" y1="517.2833251953125" y2="15" class="ct-bar" ct:value="8"></line>
                                    <line x1="668.9499816894531" x2="668.9499816894531" y1="517.2833251953125" y2="454.49790954589844" class="ct-bar" ct:value="1"></line>
                                    <line x1="813.7166442871094" x2="813.7166442871094" y1="517.2833251953125" y2="391.7124938964844" class="ct-bar" ct:value="2"></line>
                                </g>
                            </g>
                            <g class="ct-labels">
                                <foreignObject style="overflow: visible;" x="10" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Mon</span></foreignObject>
                                <foreignObject style="overflow: visible;" x="154.76666259765625" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Tue</span></foreignObject>
                                <foreignObject style="overflow: visible;" x="299.5333251953125" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Wed</span></foreignObject>
                                <foreignObject style="overflow: visible;" x="444.29998779296875" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Thu</span></foreignObject>
                                <foreignObject style="overflow: visible;" x="589.066650390625" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Fri</span></foreignObject>
                                <foreignObject style="overflow: visible;" x="733.8333129882812" y="522.2833251953125" width="144.76666259765625" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 145px; height: 20px;">Sat</span></foreignObject>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gráfico de Contas -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h2 class="fs-5 fw-bold mb-0">Gráfico de Contas</h2>
                </div>
                <div class="card-body">
                    <canvas id="chartContas" style="height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Garantir que os ícones Heroicons sejam dimensionados corretamente */
    .icon {
        width: 24px;
        height: 24px;
    }
    .icon-xs {
        width: 16px;
        height: 16px;
    }
    .icon-xxs {
        width: 12px;
        height: 12px;
    }
    /* Ajustar responsividade dos gráficos */
    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
</style>

<script type="text/javascript" src="@manifest('financial.js')"></script>