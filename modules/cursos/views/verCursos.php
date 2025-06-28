<?php
require_once '../controllers/CursosControllers.php';
$curs = new CursosController();
$cursos = $curs->mostrar();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Cursos de la Academia E</h1>

        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nombre del curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Costo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID del aula</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php
                foreach($cursos as $curso){
                    echo "<tr class='hover:bg-gray-50 transition-colors duration-200'>
                            <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>".$curso["id_curso"]."</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>".$curso["nombre_curso"]."</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>".$curso["duracion"]."</td>
                            <td class='px-6 py-4 whitespace-nowrap'>
                                <span class='inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800'>".$curso["estado"]."</span>
                            </td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>$".$curso["costo"]."</td>
                            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-900'>".$curso["id_aula"]."</td>
                        </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
