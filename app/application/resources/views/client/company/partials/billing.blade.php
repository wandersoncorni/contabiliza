<div class="col-lg-12 col-md-12 bg-gray-100 rounded-lg shadow p-4 mb-3">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="forma_pgto_id">Forma de Pagamento</label>
            <select name="forma_pgto_id" id="forma_pgto_id" required class="form-control">
                <option value="">Selecione</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="dia_cobranca">Dia da Cobrança</label>
            <input type="number" name="dia_cobranca" id="dia_cobranca" min="1" max="31" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="recorrencia">Recorrência</label>
            <select name="recorrencia" id="recorrencia" class="form-control">
                <option value="mensal">Mensal</option>
                <option value="anual">Anual</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 mb-3">
            <label for="contrato">Contrato</label>
            <input type="file" name="contrato" id="contrato" class="form-control">
        </div>
    </div>
</div>
