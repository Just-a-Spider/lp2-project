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
            <table class="table-auto min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nombre del curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Costo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID del aula</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Acciones</th>
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
                            <td class='px-6 py-4 whitespace-nowrap'>
                                <div class='flex items-center space-x-3'>
                                    <a href='editarCurso.php?id=".$curso["id_curso"]."' class='text-blue-600 hover:text-blue-900'>
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99' />
                                        </svg>
                                    </a>
                                    <a href='eliminarCurso.php?id=".$curso["id_curso"]."' class='text-red-600 hover:text-red-900'>
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0' />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>";
                }
                ?>
                </tbody>
            </table>
            
        </div>
    </div>
</body>
