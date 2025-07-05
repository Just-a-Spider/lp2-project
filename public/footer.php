</main>

    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo e Info -->
                <div class="md:col-span-1">
                    <a href="/index.php" class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-inner">
                            <span class="text-white font-bold text-2xl">E</span>
                        </div>
                        <span class="text-2xl font-bold text-white">Academia</span>
                    </a>
                    <p class="text-gray-400 text-sm">
                        Comprometidos con la excelencia en la enseñanza de idiomas.
                    </p>
                </div>

                <!-- Enlaces Rápidos -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Navegación</h3>
                    <ul class="space-y-2">
                        <?php if ($esEstudiante): ?>
                            <li><a href="/modules/curso/views/estudiante/lista-cursos.php" class="text-gray-400 hover:text-white transition-colors">Cursos Disponibles</a></li>
                            <li><a href="/modules/matricula/views/estudiante/mis-cursos.php" class="text-gray-400 hover:text-white transition-colors">Mis Cursos</a></li>
                        <?php elseif ($esAdmin): ?>
                            <li><a href="/modules/curso/views/admin/lista-curso.php" class="text-gray-400 hover:text-white transition-colors">Gestionar Cursos</a></li>
                            <li><a href="/modules/curso/views/admin/crear-curso.php" class="text-gray-400 hover:text-white transition-colors">Nuevo Curso</a></li>
                        <?php else: ?>
                            <li><a href="<?= $estudianteLogin ?>" class="text-gray-400 hover:text-white transition-colors">Iniciar Sesión</a></li>
                            <li><a href="<?= $estudianteRegistro ?>" class="text-gray-400 hover:text-white transition-colors">Regístrate</a></li>
                            <li><a href="<?= $adminLogin ?>" class="text-gray-400 hover:text-white transition-colors">Acceso Admin</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Contacto -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                            <span>contacto@academiae.com</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                            <span>+51 123 456 789</span>
                        </li>
                    </ul>
                </div>

                <!-- Redes Sociales -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.59 0 0 .59 0 1.325v21.351C0 23.41.59 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.735 0 1.325-.59 1.325-1.325V1.325C24 .59 23.41 0 22.675 0z" /></svg></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.011 3.584-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.07-1.645-.07-4.85s.012-3.584.07-4.85c.148-3.225 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.85-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.059-1.281.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98C15.667.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z" /></svg></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.223.085c.645 1.956 2.523 3.379 4.748 3.419a9.9 9.9 0 01-6.115 2.107c-.398 0-.79-.023-1.175-.068a13.963 13.963 0 007.548 2.212c9.058 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" /></svg></a>
                    </div>
                </div>
            </div>

            <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; <?= date('Y') ?> Academia E. Todos los derechos reservados. Un proyecto de clase.</p>
            </div>
        </div>
    </footer>

</body>
</html>