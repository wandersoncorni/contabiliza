$(document).ready(function () {
    fetch('/api/v1/plans', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include'
    })
        .then(response => response.json())
        .then(data => {

            // 1. Lista original dos planos
            const planos = data;

            // 2. Obter todas as categorias e seus serviços (únicos)
            const mapaCategoriasGlobais = {};

            planos.forEach(plano => {
                plano.categorias_servicos.forEach(item => {
                    const cat = item.categoria.nome;
                    const serv = item.servico.nome;

                    if (!mapaCategoriasGlobais[cat]) {
                        mapaCategoriasGlobais[cat] = new Set();
                    }
                    mapaCategoriasGlobais[cat].add(serv);
                });
            });

            // 3. Transformar Sets em arrays
            const todasCategorias = {};
            for (const [cat, servicos] of Object.entries(mapaCategoriasGlobais)) {
                todasCategorias[cat] = Array.from(servicos);
            }

            // 4. Montar os planos com todas as categorias, marcando os serviços
            const planosCompletos = planos.map(plano => {
                const categorias = {};

                // Criar um set com os serviços que o plano realmente possui
                const servicosDoPlano = new Set(
                    plano.categorias_servicos.map(item =>
                        `${item.categoria.nome}|${item.servico.nome}`
                    )
                );

                // Iterar sobre todas as categorias/serviços globais
                for (const [categoria, servicos] of Object.entries(todasCategorias)) {
                    categorias[categoria] = servicos.map(servico => {
                        const chave = `${categoria}|${servico}`;
                        return {
                            nome: servico,
                            checked: servicosDoPlano.has(chave)
                        };
                    });
                }
                const planoTag = plano.nome.toLowerCase();
                $('.plans .cards').append(
                    $('<div>', { class: 'col-12 col-lg-6 col-xl-4' }).append(
                        $('<div>', { class: `card mb-4 mb-xl-0 shadow plano-${planoTag}` }).append(
                            $('<div>', { class: 'card-header border-gray-100 py-4 px-4' }).append(
                                $('<div>', { class: 'd-flex mb-3' }).append(
                                    $('<span>', { class: 'h5 mb-0' }).text('A partir de'),
                                    $('<span>', { class: 'price display-2 mb-0', 'data-annual': plano.valor_anual, 'data-monthly': plano.valor_mensal })
                                        .text( 'R$' + formatCurrency(plano.valor_mensal)),
                                    $('<span>', { class: 'h6 fw-normal align-self-end' }).text('/mês')
                                ),
                                $('<h2>', { class: 'mb-3 text-black d-flex' }).html(plano.nome + `<div class="border-rounded-circle bg-success tag-plano-${planoTag}"></div>`),
                            ),
                            $('<div>', { class: 'card-body py-4 px-4' }).append(
                                (() => {
                                    const categoria_item = [];
                                    Object.keys(categorias).map(categoria => {
                                        const servicos = categorias[categoria].map(servico =>
                                            $('<div>', { class: 'd-flex align-items-center mb-3' }).append(
                                                $('<i>', { class: `heroicon heroicon-${servico.checked ? 'check' : 'x'} text-${servico.checked ? 'success' : 'danger'} me-2` }),
                                                $('<span>', { class: 'text-black' }).text(servico.nome)
                                            )
                                        );
                                        categoria_item.push($('<div>', { class: 'mb-4' }).append(
                                            $('<div>', { class: 'h5 fw-bolder mb-3' }).text(categoria),
                                            servicos
                                        ));
                                    });
                                    return categoria_item;
                                })(),
                            ),
                            $('<div>', { class: 'card-footer border-gray-100 d-grid px-4 pb-4' }).append(
                                $('<a>', { class: `btn btn-metal btn-${planoTag} d-inline-flex align-items-center justify-content-center`, href: `/plans/${plano.id}` }).text('Assinar'),
                            )
                        ),
                    )
                );
            });
        });
    $('#app-content').on('change', '#billingSwitch', function () {
        const  isChecked = $(this).is(':checked');
        $('.plans .cards').find('.card').each(function() {
            const valorAnual = parseFloat($(this).find('.price').data('annual'));
            const valorMensal = parseFloat($(this).find('.price').data('monthly'));
            if(isChecked) {
                animatePriceChange(valorMensal, valorAnual, $(this).find('.price'));
            } else {
                animatePriceChange(valorAnual, valorMensal, $(this).find('.price'));
            }
        });
    });
    $('#app-content').on('click', '#labelMensal, #labelAnual', function () {
        if($(this).prop('id') === 'labelMensal' && $('#billingSwitch').is(':checked')) {
            $('#billingSwitch').prop('checked', false).trigger('change');
        }
        else if($(this).prop('id') === 'labelAnual' && !$('#billingSwitch').is(':checked')) {
            $('#billingSwitch').prop('checked', true).trigger('change');
        }
    }); 
});
function animatePriceChange(start, end, display, duration = 1500) {
    const startTime = performance.now();
    const diff = end - start;
    function easeInOut(t) {
    // ease-in-out cubic
        return t < 0.5
        ? 4 * t * t * t
        : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easedProgress = easeInOut(progress);

        const currentValue = start + diff * easedProgress;
        display.text(formatCurrency(currentValue));

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

function formatCurrency(value) {
        return value.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
            minimumFractionDigits: 2
        });
    }