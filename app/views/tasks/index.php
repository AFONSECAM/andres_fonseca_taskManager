<?php require_once '../app/helpers/Flash.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body <?php flashBodyAttributes(); ?>>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Tareas de <?= htmlspecialchars($_SESSION['username']) ?></h3>
            <a href="../public/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>

        <!-- Botón para mostrar el formulario de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">➕ Nueva Tarea</button>

        <hr>

        <!-- Tabla de tareas -->
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light">
                <tr>
                    <th>Img</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Vencimiento</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td>
                            <?php if ($task['attachment']): ?>
                            <a class="btn btn-sm btn-info"
                                href="../public/uploads/<?= htmlspecialchars($task['attachment']) ?>" target="_blank">📎 Ver
                                archivo</a>
                            <?php else: ?>
                            <p>💬 Sin adjunto</p>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description']) ?></td>
                        <td><?= $task['due_date'] ?></td>
                        <td><?= ucfirst($task['priority']) ?></td>
                        <td><?= $task['completed'] ? '✔️ Completa' : '❌ Incompleta' ?></td>
                        <td>
                            <!-- Botón para editar -->
                            <button class="btn btn-sm btn-warning"
                                onclick="showEditModal(<?= htmlspecialchars(json_encode($task)) ?>)">✏ Editar</button>

                            <!-- Formulario de eliminación -->
                            <form method="POST" style="display:inline;" class="delete-form">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Eliminar</button>
                            </form>

                            <!-- Formulario de cambio de estado -->
                            <form method="POST" style="display:inline;" class="changeStatus-form">
                                <input type="hidden" name="action" value="changeStatus">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="completed" value="<?= $task['completed'] ?>">
                                <button type="submit"
                                    class="btn btn-sm <?= $task['completed'] ? 'btn-secondary' : 'btn-success' ?>">
                                    <?= $task['completed'] ? '↩ Marcar incompleta' : '✔ Marcar completada' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7">No se encontraron registros.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Formulario para filtros -->
        <div class="row">
            <div class="col-12 mt-4 mb-4">
                <form action="" method="post" class="row mb-3 g-2">
                    <input type="hidden" name="action" value="filterTasks">
                    <div class="col-md-3">
                        <select name="priority_filter" id="priority_filter" class="form-select">
                            <option value="">-- Prioridad --</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="status_filter" id="status_filter" class="form-select">
                            <option value="">-- Estado --</option>
                            <option value="1">Completa</option>
                            <option value="0">Incompleta</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="due_filter" id="due_filter" class="form-select">
                            <option value="">-- Fecha Vencimiento --</option>
                            <option value="asc">Más próximas</option>
                            <option value="desc">Más lejanas</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal crear -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <input class="form-control" type="text" name="title" placeholder="Título" required>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" name="description" placeholder="Descripción"></textarea>
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="date" name="due_date" required>
                    </div>
                    <div class="mb-2">
                        <select class="form-select" name="priority">
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="file" name="attachment">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal de edición -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="task_id" id="editTaskId">

                <div class="modal-header">
                    <h5 class="modal-title">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <input class="form-control" type="text" name="title" id="editTitle" required>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" name="description" id="editDescription"></textarea>
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="date" name="due_date" id="editDueDate" required>
                    </div>
                    <div class="mb-2">
                        <select class="form-select" name="priority" id="editPriority">
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="file" name="editAttachment">
                    </div>
                    <div class="mb-2">
                        <label><input type="checkbox" name="completed" id="editCompleted"> Completada</label>
                    </div>
                </div>

                <div class="modal-footer">                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/myscript.js"></script>
</body>

</html>