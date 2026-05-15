<?php
$isEdit = isset($contrato);
$pageTitle = $isEdit ? "Editar Contrato" : "Nuevo Contrato";
include TEMPLATE_DIR . 'header.php';
?>

<div class="max-w-4xl mx-auto space-y-6 animate-fade-in-up">
    <div class="flex items-center gap-4">
        <a href="<?= PROJECT_ROOT ?>/nominas/contratos" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-gray-900 transition-all shadow-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?= $pageTitle ?></h1>
    </div>

    <form method="POST" action="<?= $isEdit ? PROJECT_ROOT . '/nominas/contratos/edit' : PROJECT_ROOT . '/nominas/contratos/create' ?>" class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
        <?php if ($isEdit): ?>
            <input type="hidden" name="contrato_id" value="<?= $contrato['contrato_id'] ?>">
        <?php endif; ?>

        <div class="p-6 sm:p-8 space-y-8">
            <!-- Sección 1: Empleado -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="bi bi-person-badge text-primary-600"></i>
                    Datos del Empleado
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Usuario</label>
                        <?php if ($isEdit): ?>
                            <input type="text" readonly value="<?= $contrato['nombre'] . ' ' . $contrato['apellidos'] ?>" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 sm:text-sm py-2.5">
                            <input type="hidden" name="usuario_id" value="<?= $contrato['usuario_id'] ?>">
                        <?php else: ?>
                            <select name="usuario_id" required class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 sm:text-sm py-2.5 transition-all">
                                <option value="">Seleccione un empleado...</option>
                                <?php foreach ($empleables as $u): ?>
                                    <option value="<?= $u['usuario_id'] ?>"><?= $u['nombre'] . ' ' . $u['apellidos'] ?> (<?= $u['usuario_id'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nº Seguridad Social</label>
                        <input type="text" name="nss" value="<?= $empleado['nss'] ?? '' ?>" placeholder="Ej: 281234567890" class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">IBAN (Cuenta Bancaria)</label>
                        <input type="text" name="iban" value="<?= $empleado['iban'] ?? '' ?>" placeholder="ES00 0000..." class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grupo de Cotización</label>
                        <select name="grupo_cotizacion" class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <?php for($i=1; $i<=11; $i++): ?>
                                <option value="<?= $i ?>" <?= (isset($empleado['grupo_cotizacion']) && $empleado['grupo_cotizacion'] == $i) ? 'selected' : '' ?>>Grupo <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Sección 2: Condiciones Contractuales -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="bi bi-file-earmark-ruled text-primary-600"></i>
                    Condiciones Contractuales
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="<?= $contrato['fecha_inicio'] ?? '' ?>" required class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin (Opcional)</label>
                        <input type="date" name="fecha_fin" value="<?= $contrato['fecha_fin'] ?? '' ?>" class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Contrato</label>
                        <select name="tipo_contrato" class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <option value="Indefinido" <?= (isset($contrato['tipo_contrato']) && $contrato['tipo_contrato'] == 'Indefinido') ? 'selected' : '' ?>>Indefinido</option>
                            <option value="Temporal" <?= (isset($contrato['tipo_contrato']) && $contrato['tipo_contrato'] == 'Temporal') ? 'selected' : '' ?>>Temporal</option>
                            <option value="Formación" <?= (isset($contrato['tipo_contrato']) && $contrato['tipo_contrato'] == 'Formación') ? 'selected' : '' ?>>Formación</option>
                            <option value="Prácticas" <?= (isset($contrato['tipo_contrato']) && $contrato['tipo_contrato'] == 'Prácticas') ? 'selected' : '' ?>>Prácticas</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-4 pt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="activo" value="1" class="sr-only peer" <?= (!isset($contrato['activo']) || $contrato['activo']) ? 'checked' : '' ?>>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Contrato Activo</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Sección 3: Retribución -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="bi bi-cash-stack text-primary-600"></i>
                    Retribución y Retenciones
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Salario Base Mensual (€)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="salario_base_mensual" value="<?= $contrato['salario_base_mensual'] ?? '' ?>" required class="block w-full rounded-xl border-gray-200 pl-4 pr-10 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">€</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Complementos (€)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="complementos_mensuales" value="<?= $contrato['complementos_mensuales'] ?? '0' ?>" class="block w-full rounded-xl border-gray-200 pl-4 pr-10 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">€</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pagas Extraordinarias</label>
                        <select name="pagas_extra" class="block w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <option value="0" <?= (isset($contrato['pagas_extra']) && $contrato['pagas_extra'] == 0) ? 'selected' : '' ?>>Prorrateadas (12 pagas)</option>
                            <option value="2" <?= (isset($contrato['pagas_extra']) && $contrato['pagas_extra'] == 2) ? 'selected' : '' ?>>2 Extras (14 pagas)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">% Retención IRPF</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="irpf_porcentaje" value="<?= $contrato['irpf_porcentaje'] ?? '15' ?>" required class="block w-full rounded-xl border-gray-200 pl-4 pr-10 focus:ring-2 focus:ring-primary-600 sm:text-sm py-2.5 transition-all">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="<?= PROJECT_ROOT ?>/nominas/contratos" class="inline-flex justify-center items-center rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                Cancelar
            </a>
            <button type="submit" class="inline-flex justify-center items-center rounded-xl bg-primary-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all">
                <?= $isEdit ? 'Guardar Cambios' : 'Crear Contrato' ?>
            </button>
        </div>
    </form>
</div>

<?php include TEMPLATE_DIR . 'footer.php'; ?>
