<style>
    table td {
        vertical-align: middle !important;
    }
    .total-row {
        border-top: solid 15px #f2f4f6;
        border-bottom: solid #f2f4f6;
    }
    .total-row td:first-child {
        background-color: #f2f4f6;
    }
</style>
<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-3 table-responsive">
            <table class="table bg-white" id="table-plan">
                <thead class="bg-light border-top">
                    <th scope="row" class="border-0 text-left w-0">Item</th>
                    <th scope="row" class="border-0">Descrição</th>
                    <th scope="row" class="border-0 w-0">Preço</th>
                    <th scope="row" class="border-0 w-0">Qtd</th>
                    <th scope="row" class="border-0 w-0">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="text-left fw-bold">Plano de assinatura</th>
                        <td>
                            <select name="plano_id" id="plano_id" class="form-select w-100 skeleton" required></select>
                            <input type="hidden" name="id" value="">
                        </td>
                        <td class="data"><div class="skeleton"></div></td>
                        <td class="data"><div class="skeleton"></div></td>
                        <td class="data"><div class="skeleton"></div></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-left fw-bold">Pró-labore</th>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-left fw-bold">Folha de pagamento</th>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                        <td class="data"><div class="skeleton"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3"></td>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold"><div class="skeleton" style="width: 50px"></div></td>
                    </tr>
                </tfoot>
            </table>
            <div class="obs" style="margin-top: -50px; margin-bottom: 65px;"></div>
            <div id="plan-obs"></div>
        </div>
    </div>
</div>
